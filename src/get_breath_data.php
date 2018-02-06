<?php
$servername = "localhost";
$username = "root";
$password = "barrylam7f";
$dbname = "SoberMotion";

$userid = $_POST['userid'];
//$userid = 'DUI_011';

$alcoholtest = array();
$photo = array();
//$arr = array ('response'=>'error','comment'=>'test comment here');
//echo json_encode($arr);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Date, 
		SUM(CASE WHEN FailedState='3' OR FailedState='6' THEN 1 ELSE 0 END), 
		SUM(CASE WHEN SUBSTRING(FailedReason,1,4)='IN_N' THEN 1 ELSE 0 END), 
		SUM(CASE WHEN SUBSTRING(FailedReason,1,4)='IN_F' THEN 1 ELSE 0 END), 
		SUM(CASE WHEN SUBSTRING(FailedReason,1,4)='INIT' THEN 1 ELSE 0 END), 
		SUM(CASE WHEN SUBSTRING(FailedReason,1,4)='ABNO' THEN 1 ELSE 0 END) 
		FROM `BreathDetail` WHERE UserID='$userid' GROUP BY Date";

$result = $conn->query($sql) or die("Could not select examples");;
$unknown = 0;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	$date = $row['Date'];
    	$bluetooth = $row["SUM(CASE WHEN FailedState='3' OR FailedState='6' THEN 1 ELSE 0 END)"];
    	$noface = $row["SUM(CASE WHEN SUBSTRING(FailedReason,1,4)='IN_N' THEN 1 ELSE 0 END)"];
    	$nomarker = $row["SUM(CASE WHEN SUBSTRING(FailedReason,1,4)='IN_F' THEN 1 ELSE 0 END)"];
    	$init = $row["SUM(CASE WHEN SUBSTRING(FailedReason,1,4)='INIT' THEN 1 ELSE 0 END)"];
    	$abnormal = $row["SUM(CASE WHEN SUBSTRING(FailedReason,1,4)='ABNO' THEN 1 ELSE 0 END)"];
    	$sql2 = "SELECT TimestampMillis FROM AlcoholInfluenceAssessment WHERE UserID='$userid' AND Date='$date'";
    	$result2 = $conn->query($sql2) or die("Could not select examples222");;
    	if ($result2->num_rows > 0) {
    		while($row2 = $result2->fetch_assoc()) {
    			$keyin = $row2['TimestampMillis'];
    			$sql3 = "SELECT * FROM FaceDetection WHERE UserID='$userid' AND KeyInAlcoholInfluenceAssessment='$keyin'";
    			$result3 = $conn->query($sql3) or die("Could not select examples33333");;
		    	if ($result3->num_rows > 0) {
		    		while($row3 = $result3->fetch_assoc()) {
		    			if ($row3['FinalTarget']=='unknown'){
		    				$unknown++;
		    				list($da, $time) = explode(" ",$row3['Timestamp']);
		    				$photo[] = array('date' => $da,
		    								'time' => $time,
		    								'name' => $row3['PhotoName'],
		    								'assessment' => $row3['KeyInAlcoholInfluenceAssessment']);
		    			}
		    		}
		    	}
    		}
    	}
    	$alcoholtest[] = array('date' => $date,
			       'bluetooth' => $bluetooth,
			       'noface' => $noface,
			       'nomarker' => $nomarker,
			       'init' => $init,
			       'abnormal' => $abnormal,
			       'unknown' => $unknown);
    	$unknown = 0;
    }
}
echo json_encode(array('result1' => $alcoholtest, 'result2' => $photo));

/*
foreach ($result as $item) {
    echo $item['Brac'],",",$item['Date'],",",$item['Datetime'],"\n";
}*/
?>
