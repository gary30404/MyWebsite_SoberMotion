<?php
$servername = "localhost";
$username = "root";
$password = "barrylam7f";
$dbname = "SoberMotion";

$userid = $_POST['userid'];
$month = $_POST['month'];
$week = $_POST['week'];

$alcoholtest = array();

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

$sql = "SELECT * FROM AlcoholInfluenceAssessment WHERE UserID='$userid'";

$result = $conn->query($sql) or die("Could not select examples");;


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	if (strtotime($row['Date']) >= $start_date_secs && strtotime($row['Date']) <= $end_date_secs){
    		list($year, $month, $day) = explode("-",$row['Date']);
			list($hr, $min, $sec) = explode(":",$row['Datetime']);
			$date = $month . '-' . $day;
			$time = $hr . ':' . $min;
			$key = $row['TimestampMillis'];
			$sql2 = "SELECT FinalTarget FROM FaceDetection WHERE KeyInAlcoholInfluenceAssessment='$key'";
			$result2 = $conn->query($sql2) or die("Could not select examples");;
			if ($result2->num_rows > 0) {
	    	    while($row2 = $result2->fetch_assoc()) {
					$finaltarget = $row2['FinalTarget'];
		    	}
			}
	    	$alcoholtest[] = array('brac' => $row['Brac'],
				       'date' => $date,
				       'time' => $time,
				       'finaltarget' => $finaltarget,
				       'reason' => $row['Reason']);
    	}
    }
}

echo json_encode($alcoholtest);

?>
