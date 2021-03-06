<?php require('../functions/page_loading.php');
require('../functions/student_entry.php');
require('../config.php');
require('../data.php');
display_student_menu(true);

$database = "if19_TimeSort"; 
$Timestamp = date('Y-m-d H:i:s');
$notice = null;
$notice2 = null;
$Subject_Subject_ID = null;
$Subject_Subject_ID_Error = null;
$Activity_Activity_ID = null;
$Time_Spent = null;
$Activity_Activity_ID_Error = null;
$Time_Spent_Error = null;
$newTime = null;
$activeID = null;


//kui on salvestamise nuppu vajutatud
//echo '<pre>';
//var_dump($_POST);
//var_dump($_POST["submitTime"]);
//$timeStart = $_POST["timeValue"];
//var_dump(round($timeStart * 1000));
//var_dump('Kulus' . (round(microtime(true) * 1000) - round($timeStart * 1000)) / 1000 . ' sekundit');
if (isset($_POST["submitTime"])) {

    if (isset($_POST["homework"]) and !empty($_POST["homework"])) {
        $Activity_Activity_ID = intval($_POST["homework"]);
    } else {
        $Activity_Activity_ID_Error = "Palun vali õppeaine!";
    }

    if (isset($_POST["allSubjects"]) and !empty($_POST["allSubjects"])) {
        $Subject_Subject_ID = intval($_POST["allSubjects"]);
    } else {
        $Subject_Subject_ID_Error = "Palun vali õpitegevus!";
    }


    //ajakulu
    if (isset($_POST["timeValue"]) and !empty($_POST["timeValue"])) {
        $Time_Spent = $_POST["timeValue"];
      
    } else {
        echo $Time_Spent_Error = "Ei saa salvestada null ajaga!";
    }
    //echo $Activity_Activity_ID . ";" . $Time_Spent .";" . $Timestamp . ";" . $Subject_Subject_ID . ";";
    $notice = saveResult($Activity_Activity_ID, $Time_Spent, $Timestamp, $Subject_Subject_ID);
    //echo "Edukalt salvestatud";
} else {
    //echo "Ei ole salvestatud ";
}

if (isset($_POST["changeTime"])) {
    //ajakulu muutmine
    if (isset($_POST["timeChoices"]) and !empty($_POST["timeChoices"]) and isset($_POST["activeID"]) and !empty($_POST["activeID"])) {
        $newTime = $_POST["timeChoices"];
        $activeID = $_POST["activeID"];
     
        $notice2 = changeResult($newTime, $activeID);

    } else {
      //  echo $Time_Spent_Error = "Ei saa salvestada null ajaga!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/timer.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script defer src="../javascript/timer.js"></script>
    <link rel="shortcut icon" href="~/favicon.ico">
    <title>Aja salvestamine</title>
</head>

<body>
    <div id="imageDiv">
    <form id="submitForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="chooseSubject">

            <label class="subjectLabel" for='allSubjects'>Vali õppeaine </label><br>
            <select name="allSubjects">
                <option value="1">Tarkvaraarenduse projekt</option>
                <option value="2">Objektorienteeritud programmeerimine</option>
                <option value="3">Interaktsioonidisain</option>
                <option value="4">Üldotstarbelised arendusplatvormid</option>
                <option value="5">Hulgateoooria ja loogika elemendid</option>
                <option value="6">Tarkvara testimise alused</option> 
                <option value="7">Sissejuhatus infosüsteemidesse</option>
            </select>
            <br>
            <span><?php echo $Time_Spent_Error . " " . $Activity_Activity_ID_Error . " " .  $Subject_Subject_ID_Error?></span>
            <br>
            <label for='homework'>Vali õpitegevus </label><br>
            <select name="homework">
                <option value="9">Akadeemiline õppetöö</option>
                <option value="10">Rühmatöö</option>
                <option value="11">Harjutamine</option>
                <option value="12">Kodutööde lahendamine</option>
                <option value="13">Õppematerjali lugemine</option>
                <option value="14">Õppevideote vaatamine</option>
                <option value="15">Teiste õpetamine</option>
                <option value="16">Täpsustamata õpimeetod</option>
            </select>
            <br>
        </div>
        <div class="timerDiv">
            <div class="timerButtons">
                <button class="timerButtons startButton" onclick="start()" type="button"><i class="fa fa-play" aria-hidden="true"></i> Start</button>
                <button class="timerButtons pauseButton" onclick="pause()" type="button"><i class="fa fa-pause-circle-o" aria-hidden="true"></i> Pause</button>
                <button class="timerButtons restartButton" onclick="stop()" type="button"><i class="fa fa-trash-o" aria-hidden="true"></i> Restart</button>
                <hr>
            </div>

            <div name="stopwatch" id="stopwatch" class="stopwatch">00:00:00 </div>
           
 
            <input class="submitTime" name="submitTime" id="submitTime" type="submit" value="Salvesta tulemus" onclick="submit()"><span id="notice"><?php echo $notice; ?></span>
            

            <input type="hidden" value="00:00:00" name="timeValue" class="timeValue" id="timeValue">

        </div>
        

    </form>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <div class=timerDiv>
  <label id="activeIDLabel" for="activeID">Siin saad muuta eelnevaid aegu</label>
        <select id="activeID" name="activeID">
        <?php 
        global $subject_Names;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $sql = mysqli_query($conn, "SELECT * FROM Student_Entry WHERE Timestamp >= now() - interval 3 day");
        while ($row = $sql->fetch_assoc()){
        echo "<option value=" .$row['Student_Entry_ID']. ">" . $row['Student_Entry_ID'] . " | " . $subject_Names[$row['Subject_Subject_ID']] . " | "  . $subject_Names[$row['Activity_Activity_ID']] . " | " . $row['Time_Spent'] . " | " . $row['Timestamp'] . "</option>";
        }
        ?>
        </select>
      
        <br>
     
        <label id="timeChoices" for='timeChoices'>Vali aeg </label><br>
            <select name="timeChoices">
                <option value="00:10:00">00:10:00</option>
                <option value="00:20:00">00:20:00</option>
                <option value="00:30:00">00:30:00</option>
                <option value="00:40:00">00:40:00</option>
                <option value="00:50:00">00:50:00</option>
                <option value="01:00:00">01:00:00</option>
                <option value="01:10:00">01:10:00</option>
                <option value="01:20:00">01:20:00</option>
                <option value="01:30:00">01:30:00</option>
                <option value="01:40:00">01:40:00</option>
                <option value="01:50:00">01:50:00</option>
                <option value="02:00:00">02:00:00</option>
                <option value="02:10:00">02:10:00</option>
                <option value="02:20:00">02:20:00</option>
                <option value="02:30:00">02:30:00</option>
                <option value="02:40:00">02:40:00</option>
                <option value="02:50:00">02:50:00</option>
                <option value="03:10:00">03:10:00</option>
                <option value="03:20:00">03:20:00</option>
                <option value="03:00:00">03:30:00</option>
                <option value="03:30:00">03:30:00</option>
                <option value="03:40:00">03:40:00</option>
                <option value="03:50:00">03:50:00</option>
                <option value="04:00:00">04:00:00</option>
            </select>
            <input class="changeTime" name="changeTime" id="changeTime" type="submit" value="Muuda aega" onclick="submit()"><span id="notice"><?php echo $notice2; ?></span>
   </div>
    </form>
    </div>
</body> 

</html>