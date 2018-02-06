<?php
$servername = "localhost";
$username = "root";
$password = "barrylam7f";
$dbname = "SoberMotion";

$userid = $_POST['userid'];
//$userid = 'DUI_003';

$alcoholtest = array();
//$arr = array ('response'=>'error','comment'=>'test comment here');
//echo json_encode($arr);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Brac, Date, Datetime, ReasonChoice, Reason FROM AlcoholInfluenceAssessment WHERE UserID='$userid'";

$result = $conn->query($sql) or die("Could not select examples");;

//echo json_encode($userid);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	list($year, $month, $day) = explode("-",$row['Date']);
	list($hr, $min, $sec) = explode(":",$row['Datetime']);
	$time = $month . '-' . $day . ' ' . $hr . ':' . $min;
    	$alcoholtest[] = array('brac' => $row['Brac'],
			       'time' => $time,
			       'reason' => $row['ReasonChoice'],
			       'reason_string' => $row['Reason']);
    }
}
echo json_encode($alcoholtest);

/*
foreach ($result as $item) {
    echo $item['Brac'],",",$item['Date'],",",$item['Datetime'],"\n";
}*/
?>
