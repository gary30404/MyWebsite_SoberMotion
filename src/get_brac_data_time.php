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
mysqli_set_charset($conn, "utf8");
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

$sql = "SELECT Brac, Date, Datetime, ReasonChoice, Reason FROM AlcoholInfluenceAssessment WHERE UserID='$userid'";

$result = $conn->query($sql) or die("Could not select examples");;


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if (strtotime($row['Date']) >= $start_date_secs && strtotime($row['Date']) <= $end_date_secs){
        	list($year, $month, $day) = explode("-",$row['Date']);
        	list($hr, $min, $sec) = explode(":",$row['Datetime']);
        	$time = $month . '-' . $day . ' ' . $hr . ':' . $min;
            $alcoholtest[] = array('brac' => $row['Brac'],
                                   'time' => $time,
                                   'reason' => $row['ReasonChoice'],
				   'reason_string' => $row['Reason']);
        }
    }
}
echo json_encode($alcoholtest);

?>
