<?php require('../functions/page_loading.php');
require('../config.php');
require('../data.php');
require('../functions/get_stats_table.php');
display_student_menu(true);

global $conn;
global $subject_Names;
$searchable = "";
$statsHTML = null;

switch($_POST['chooseSearchValue']){
   
    case 'Student_Entry_ID':
        $searchable = 'Student_Entry_ID';
        
    break;

    case 'Subject_Subject_ID':
        $searchable = 'Subject_Subject_ID';
    
    break;

    case 'Activity_Activity_ID':
        $searchable = 'Activity_Activity_ID';
   
    break;

    case 'Time_Spent':
        $searchable = 'Time_Spent';
      
    break;
    
    case 'Timestamp':
        $searchable = 'Timestamp';

    break;
    
    default:
        echo "Midagi pole valitud";
        
    }
  
?>


<head>

    <link rel="stylesheet" href="../style/stats.css"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script defer src="../javascript/stats.js"></script>
</head>
<h1>Esileht</h1>

<form action="search.php" method="POST">
    <input name="search" type="text" id="searchInput" placeholder="Otsi kuupäeva järgi..." title="Sisesta otsitav ülesanne" onclick="">
    <button type="submit" name="submit-search">Otsi!</button>
</form>
<button onclick="location.href = 'stats.php';" id="redirectButton" class="float-left submit-button" >Vaata tulemusi joonise kujul</button>
<h2>Kõik salvestused:</h2>
<form method="POST">
    <select name="chooseSearchValue">
        <option value="Student_Entry_ID">Järjekorra numbri järgi</option>
        <option value="Subject_Subject_ID">Aine nimetuse järgi</option>
        <option value="Activity_Activity_ID">Tegevuse järgi</option>
        <option value="Time_Spent">Ajakulu järgi</option>
        <option value="Timestamp">Kuupäeva ja kellaaja järgi</option>
    </select>
    <input name="ASC" class="ASC" id="ASC" type="submit" value="Tõusvalt">
    <input name="DESC" class="DESC" id="DESC" type="submit" value="Kahanevalt"> 
    
</form>

<div class="article-container">

    <?php
    echo "Hetkel valitud: " . $searchable;
    if (isset($_POST["DESC"])) {

        $statsHTML = readAllStatsDESC($_POST['chooseSearchValue']);
    } else {
        echo " DESC Error";
    }


    if (isset($_POST["ASC"])) {
        $statsHTML = readAllStatsASC($_POST['chooseSearchValue']);
    } else {
        echo " ASC Error";
    }
    ?>
</div>

<body>
    
    <div id="statsHTML">
        <ul class="statsList">
            <?php

        echo $statsHTML;
            ?>
        </ul>
    </div>

    <!--<button value="fix" onclick="test()"></button>-->

</body>

</html>