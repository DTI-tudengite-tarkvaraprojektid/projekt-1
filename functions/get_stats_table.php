<?php
require('../config.php');
require('../data.php');
//require('stats.php');



function readAllStats($searchable, $direction)
{
	global $conn;
	global $subject_Names;
	$sql = "SELECT * FROM Student_Entry ORDER BY " . $searchable ." " . $direction;
	$statsHTML = ""; 
	$result = mysqli_query($conn, $sql);
	echo $conn->error;
	$queryResults = mysqli_num_rows($result);
	
	if ($queryResults > 0) {
		while ($row = mysqli_fetch_assoc($result)) {

			$statsHTML .= "<h3>" . $row['Student_Entry_ID'] . " | " . $subject_Names[$row['Subject_Subject_ID']] . " | " . $subject_Names[$row['Activity_Activity_ID']] . " | " . $row['Time_Spent'] . " | " . $row['Timestamp'] . "</h3>";
		}
	}
	
	if ($statsHTML == null) {
		$statsHTML = "<p>Andmebaas on tühi!</p>";
	}
	
	return $statsHTML;
}





/*
class queryThis{

public function test(){
	$this -> fix();
}

private function fix()
{
	$query = $this->get('id');
	foreach ($query->result() as $row) {
		$data['Student_Entry_ID'] = $row->Student_Entry_ID;
		$data['Activity_Activity_ID'] = $row->Activity_Activity_ID;
		$data['Time_Spent'] = $row->Time_Spent;
		$data['Timestamp'] = $row->Timestamp;
		$data['Subject_Subject_ID'] = $row->Timestamp;
		$sounds_like = $this-> _make_sounds_like($data);
		echo $sounds_like.'<br>';
	}
}

private function _make_sounds_like($data)
{
	$sounds_like = '';

	if (isset($data['Student_Entry_ID'])) {
		$sounds_like .= metaphone($data['Student_Entry_ID']) . ' ';
	}

	if(isset($data['Activity_Activity_ID'])){
		$sounds_like .= metaphone($data['Activity_Activity_ID']). ' ';
	}

	if(isset($data['Time_Spent'])){
		$sounds_like .= metaphone($data['Time_Spent']). ' ';
	}

	if(isset($data['Timestamp'])){
		$sounds_like .= metaphone($data['Timestamp']). ' ';
	}

	if(isset($data['Subject_Subject_ID'])){
		$sounds_like .= metaphone($data['Subject_Subject_ID']). ' ';
	}

	return $sounds_like;
	
}

function _create_custom_search($Student_Entry_ID, $location){
	$location = metaphone($location);
	$mysql_query = "select * from Student_Entry where sounds_like like '%$location'";
	$mysql_query .= " order by Student_Entry_ID desc"; 

	$query = $this -> $mysql_query;
	$num_of_rows = $query->num_of_rows();
	echo $mysql_query;
}
}

$QueryObject = new queryThis();
$QueryObject ->test();
*/