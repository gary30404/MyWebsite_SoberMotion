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

$sql = "SELECT * FROM AlcoholInfluenceAssessment WHERE UserID='$userid'";

$result = $conn->query($sql) or die("Could not select examples");;

//echo json_encode($userid);
$reason = '';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	list($year, $month, $day) = explode("-",$row['Date']);
	list($hr, $min, $sec) = explode(":",$row['Datetime']);
	$date = $month . '-' . $day;
	$time = $hr . ':' . $min;
	/*
	$key = $row['TimestampMillis'];
	$sql2 = "SELECT FinalTarget FROM FaceDetection WHERE KeyInAlcoholInfluenceAssessment='$key'";
	$result2 = $conn->query($sql2) or die("Could not select examples");;
	if ($result2->num_rows > 0) {
    	while($row2 = $result2->fetch_assoc()) {
			$finaltarget = $row2['FinalTarget'];
	    }
	}
	*/
	switch($row['ReasonChoice']){
                            case "0":
                                $reason = "工作提神";
                                break;
                            case "1":
                            	$reason = "交際應酬";
                                break;
                            case "2":
                            	$reason = "幫助睡眠";
                                break;
                            case "3":
                            	$reason = "無聊";
                                break;
                            case "4":
                            	$reason = "別人勸酒";
                                break;
                            case "5":
                            	$reason = "親友聚餐";
                                break;
                            case "6":
                            	$reason = "親友吵架";
                                break;
                            case "7":
                            	$reason = "鬱卒";
                                break;
                            case "8":
                            	$reason = $row['Reason'];
                                break;
                            case "9":
                            	$reason = "沒填理由";
                                break;
                            defaults:
                            	$reason = "--";
                                break;
                        }
    	$alcoholtest[] = array(
    			   'date' => $date,
			       'time' => $time,
    			   'brac' => $row['Brac'],
    			   'reason' => $reason,
			       'timeslot' => $row['TimeSlot'],
			       'selfpredict' => $row['SelfPredict']);
    }
}
echo json_encode($alcoholtest);

/*
foreach ($result as $item) {
    echo $item['Brac'],",",$item['Date'],",",$item['Datetime'],"\n";
}*/
?>
