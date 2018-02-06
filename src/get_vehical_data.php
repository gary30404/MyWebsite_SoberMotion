<?php
$servername = "localhost";
$username = "root";
$password = "barrylam7f";
$dbname = "SoberMotion";

$userid = $_POST['userid'];
//$userid = 'DUI_009';

$alcoholtest_x = array();
$alcoholtest_o = array();
$checkstart = array();
//$arr = array ('response'=>'error','comment'=>'test comment here');
//echo json_encode($arr);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM VehicleUseTag WHERE UserID='$userid'";

$result = $conn->query($sql) or die("Could not select examples");;

//echo json_encode($userid);
$selfpredict = '';
$lasttime = '';

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
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
	$stime = $shr . ":" . $smin;
	$etime = $ehr . ":" . $emin;
	//$time = $shr . ":" . $smin . "-" . $ehr . ":" . $emin;
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
		        			$lasttime = $row2['Timestamp'];
		    	    		$min = $row['VehicleUseStartTimestampMillis'] - $row2['TimestampMillis'];
		    	    		$selfpredict = $row2['SelfPredict'];
					$brac = $row2['Brac'];
						}
		    		}
	    		}
	    }
	}
	$seconds = floor($min / 1000);
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $seconds = $seconds % 60;
    $minutes = $minutes % 60;
	$last = $hours . ":" . $minutes;
	//$checkstart = array($row['VehicleUseStartTimestampMillis']);
	array_push($checkstart, $row['VehicleUseStartTimestampMillis']);
	if ($row['TagTimestamp'] == null){
		$row['TagTimestamp'] = '--';
	}
	$alcoholtest_x[] = array(
			       'date' => $date,
			       'stime' => $stime,
			       'etime' => $etime,
			       'last' => $last,
			       'lasttime' => $lasttime,
			       'brac' => $brac,
			       'selfpredict' => $selfpredict,
			       'tag' => $row['TagTimestamp'],
			       'selfdrive' => $row['IsSelfDrive'],
			       'screening' => $row['AlcoholScreeningID']
			       );
    }
}

$sql = "SELECT * FROM VehicleUse WHERE UserID='$userid'";

$result = $conn->query($sql) or die("Could not select examples");;

//echo json_encode($userid);
$selfpredict = '';
$lasttime = '';

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	if(!in_array($row['StartTimestampMillis'], $checkstart)){
    		list($year, $month, $day) = explode("-",$row['StartDate']);
			$date = $month . "-" . $day;
			$start = $row['StartTimestampMillis'] / 1000;
			$end = $row['EndTimestampMillis'] / 1000;
			$interval = round(($end - $start) / 60);
			$startdaytime = date("d/m/Y H:i:s", $start);
			$enddaytime = date("d/m/Y H:i:s", $end);
			list($startday, $starttime) = explode(" ",$startdaytime);
			list($endday, $endtime) = explode(" ",$enddaytime);
			list($shr, $smin, $ssec) = explode(":", $starttime);
			list($ehr, $emin, $esec) = explode(":", $endtime);
			$stime = $shr . ":" . $smin;
			$etime = $ehr . ":" . $emin;
			$sql2 = "SELECT * FROM AlcoholInfluenceAssessment WHERE UserID = '$userid'";
		    $result2 = $conn->query($sql2) or die("Could not select examples");;
		    $min = $row['StartTimestampMillis'];
		    if ($result2->num_rows > 0) {
	    	        while($row2 = $result2->fetch_assoc()) {
			    		if($row['StartTimestampMillis'] > $row2['TimestampMillis']){
			        		if(($row['StartTimestampMillis'] - $row2['TimestampMillis']) < $min){
			        			$lasttime = $row2['Timestamp'];
			    	    		$min = $row['StartTimestampMillis'] - $row2['TimestampMillis'];
						$brac = $row2['Brac'];	
						}
			    		}
		    		}
		    }
		    $seconds = floor($min / 1000);
		    $minutes = floor($seconds / 60);
		    $hours = floor($minutes / 60);
		    $seconds = $seconds % 60;
		    $minutes = $minutes % 60;
			$last = $hours . ":" . $minutes;
			$alcoholtest_o[] = array('date' => $date,
					       'stime' => $stime,
					       'etime' => $etime,
					       'last' => $last,
					       'lasttime' => $lasttime,
					       'brac' => $brac);
    	}
    }
}

echo json_encode(array('result1' => $alcoholtest_o, 'result2' => $alcoholtest_x));


?>
