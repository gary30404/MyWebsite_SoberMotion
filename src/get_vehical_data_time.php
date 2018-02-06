<?php
$servername = "localhost";
$username = "root";
$password = "barrylam7f";
$dbname = "SoberMotion";

$userid = $_POST['userid'];
$userid = $_POST['userid'];
$month = $_POST['month'];
$week = $_POST['week'];

$alcoholtest = array();
//$arr = array ('response'=>'error','comment'=>'test comment here');
//echo json_encode($arr);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Join Date
$sql = "SELECT * FROM Offender WHERE UserID='$userid'";

$result = $conn->query($sql) or die("Could not select examples");;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	$join = $row['JoinDate'];
    }
}
$join_secs = strtotime($join);
if ($month == 1){
	$end_date_secs = $join_secs + 60*60*24*7*$week;
} else if ($month == 2){
	$end_date_secs = $join_secs + 60*60*24*7*$week*4;
}else if ($month == 3){
	$end_date_secs = $join_secs + 60*60*24*7*$week*8;
}
$start_date_secs = $end_date_secs - 60*60*24*7;
$end_date_secs = $end_date_secs - 60*60*24;

//$end_date = date("Y-m-d H:i:s", $end_date_secs);
//$start_date = date("Y-m-d H:i:s", $start_date_secs);
//$alcoholtest[] = array('start' => $start_date, 'end' => $end_date);
//echo json_encode($alcoholtest);

$sql = "SELECT * FROM VehicleUseTag WHERE UserID='$userid'";

$result = $conn->query($sql) or die("Could not select examples");;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	if (strtotime($row['VehicleUseDate']) >= $start_date_secs && strtotime($row['VehicleUseDate']) <= $end_date_secs){
			list($year, $month, $day) = explode("-",$row['VehicleUseDate']);
			$date = $month . "-" . $day;
			$start = $row['VehicleUseStartTimestampMillis'] / 1000;
			$end = $row['VehicleUseEndTimestampMillis'] / 1000;
			$interval = round(($end - $start) / 60);
			$startdaytime = date("d/m/Y H:i:s", $start);
			$enddaytime = date("d/m/Y H:i:s", $end);
			list($startday, $starttime) = explode(" ",$startdaytime);
			list($endday, $endtime) = explode(" ",$enddaytime);
			list($shr, $smin, $ssec) = explode(":", $starttime);
			list($ehr, $emin, $esec) = explode(":", $endtime);
			$time = $shr . ":" . $smin . "-" . $ehr . ":" . $emin;
			//echo $time, " ", $interval, "\n";
			if ($row['AlcoholScreeningID'] != 0){
			    $last = "--";
			}else{	
			    $sql2 = "SELECT * FROM AlcoholInfluenceAssessment WHERE UserID = '$userid'";
			    $result2 = $conn->query($sql2) or die("Could not select examples");;
			    $min = $row['VehicleUseStartTimestampMillis'];
			    if ($result2->num_rows > 0) {
		    	        while($row2 = $result2->fetch_assoc()) {
				    if($row['VehicleUseStartTimestampMillis'] > $row2['TimestampMillis']){
				        if(($row['VehicleUseStartTimestampMillis'] - $row2['TimestampMillis']) < $min){
				    	    $min = $row['VehicleUseStartTimestampMillis'] - $row2['TimestampMillis'];
					}
				    }
			    	}
			    }
			}
			$last = round($min/(1000*60*60));
			$alcoholtest[] = array('tag' => $row['IsSelfDrive'],
					       'date' => $date,
					       'time' => $time,
					       'last' => $last,
					       'interval' => $interval);
		}
    }
}
echo json_encode($alcoholtest);

?>
