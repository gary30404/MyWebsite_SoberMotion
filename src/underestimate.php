<?php
$servername = "localhost";
$username = "root";
$password = "barrylam7f";
$dbname = "SoberMotion";

$userid = $_POST['userid'];
//$userid = 'DUI_003a';


$alcoholtest = array();
//$arr = array ('response'=>'error','comment'=>'test comment here');
//echo json_encode($arr);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM AlcoholInfluenceAssessment, Offender WHERE AlcoholInfluenceAssessment.UserID='$userid' and Offender.UserID='$userid' and AlcoholInfluenceAssessment.Date > Offender.StartDate";

$result = $conn->query($sql) or die("Could not select examples");;

//echo json_encode($userid);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	list($year, $month, $day) = explode("-",$row['Date']);
	//echo (strtotime($row['Date'])-strtotime($row['StartDate']))/(60*60*24) . " ";
	//echo $row['Timestamp'] . "\n";
    	$alcoholtest[] = array('brac' => $row['Brac'],
			       'selfpredict' => $row['IsSelfPredictCorrect'],
			       'date' => (strtotime($row['Date'])-strtotime($row['StartDate']))/(60*60*24),
			       
			       'time' => $row['Timestamp']);
    }
}

//echo json_encode($alcoholtest);

$drink = 0;
$num = 0;
$len=count($alcoholtest);
$lastdate = $alcoholtest[$len-1]['date'];
$weeks_default = 0;
$return = array();
for($i=0;$i<12;$i++){
    $return[] = array('week' => $i+1, 'percent' => null, 'num' => '');
}
for ($i=0;$i<$len;$i++){
    //echo $alcoholtest[$i]['date'] . "";
    //echo $alcoholtest[$i]['time'] . "\n";
    if ($alcoholtest[$i]['brac'] >= 0.15){
    	//echo $alcoholtest[$i]['time'] . "\n";
	$drink++;
    }
    if ($alcoholtest[$i]['brac'] >= 0.15 && $alcoholtest[$i]['selfpredict'] == 0){
	//echo $alcoholtest[$i]['date'] . " ";
	//echo $alcoholtest[$i]['time'] . "\n";
        $num++;
    }
    if (floor($alcoholtest[$i]['date']/7) != $weeks_default){
	$weeks_default++;
	if ($drink == 0){
	    $percent = 0;
	} else{
	    $percent = round(($num/$drink)*100);
	}
	$return[$weeks_default-1]['week'] = $weeks_default;
	$return[$weeks_default-1]['percent'] = $percent;
	$return[$weeks_default-1]['num'] = $num . "/" . $drink;
	$drink = 0;
	$num = 0;
    }
}

echo json_encode($return);
//$uuu = $alcoholtest[0]['date'] - $joindate;
//echo $uuu;
//echo $alcoholtest[0]['date'];
/*
foreach ($result as $item) {
    echo $item['Brac'],",",$item['Date'],",",$item['Datetime'],"\n";
}*/
?>
