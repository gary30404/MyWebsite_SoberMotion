<?php
$servername = "localhost";
$username = "root";
$password = "barrylam7f";
$dbname = "SoberMotion";

$userid = $_POST['userid'];
//$userid = 'DUI_003a';

$alcoholtest = array();
$tab1_key = array(
'90000012', '90000028', '90000016', '90000018', '90000020', '90000022',
'10100000', '10200000', '10300000', '10400000', '10500000', '10600000', '10700000', '10800000', '10900000',
'11000000', '11100000', '11200000', '11300000', '11400000', '11500000', '11600000', '11700000',
'90000101', '90000016', '90000018', '90000020', '90000022',
'11800000', '11800001', '11800002',
'40600000', '40700000', '40800000', '40900000');
$tab2_key = array('90000013', '90000029');
$tab3_key = array(
'90000014', '90000030',
'30110000', '30120000', '30130000', '30200000', '30300000', '30400000', '30500000', '30600000', '30700000', '30800000', '30900000',
'3100000', '31100000', '31200000', '31300000', '31400000', '31500000');
$tab4_key = array(
'90000015', '90000031',
'40090000', '40500000', '40510000',
'90000006',
'40100000', '40200000', '40210000', '40300000', '40400000');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Date FROM `BreathDetail` WHERE UserID='$userid' GROUP BY Date";

$result = $conn->query($sql) or die("Could not select examples");;

$stack = [];

$tab1 = 0;
$tab2 = 0;
$tab3 = 0;
$tab4 = 0;
$current_state = 0;
$last_state = 0;
$current_timestamp = 0;
$last_timestamp = 0;
$five_min = 3*60*1000;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		list($year, $month, $day) = explode("-",$row['Date']);
	   	$path = '/var/www_https/SoberMotion/upload/offender/offenders_clicklog/' . $userid . "/" . $year . "_" . $month . "_" . $day . ".log";
		//echo $path . "\n";
		if (file_exists($path)){
			$handle = fopen($path, "r");
			if ($handle) {
		        while (($line = fgets($handle)) != false) {
		            list($timemills, $codes) = explode("\t", $line);
					$codes = substr($codes, 0, 8);
		            if (in_array($codes, $tab1_key)){
		            	$current_state = 1;
		            	$current_timestamp = $timemills;
		            } else if(in_array($codes, $tab2_key)){
		            	$current_state = 2;
		            	$current_timestamp = $timemills;
		           	} else if(in_array($codes, $tab3_key)){
		           		$current_state = 3;
		           		$current_timestamp = $timemills;
		           	} else if(in_array($codes, $tab4_key)){
		           		$current_state = 4;
		           		$current_timestamp = $timemills;
		           	} else{
		            	$current_state = 0;
		           		$current_timestamp = 0;
		            }
		            if ($current_state != 0){
		            	switch ($last_state) {
		            		case '1':
		            			if (($current_timestamp - $last_timestamp) > $five_min){
		            				$tab1 = $tab1 + $five_min;
		            			} else{
		            				$tab1 = $tab1 + ($current_timestamp - $last_timestamp);
		            			}
		            			break;
		            		case '2':
		            			if (($current_timestamp - $last_timestamp) > $five_min){
		            				$tab2 = $tab2 + $five_min;
		            			} else{
		            				$tab2 = $tab2 + ($current_timestamp - $last_timestamp);
		            			}
		            			break;
		            		case '3':
		            			if (($current_timestamp - $last_timestamp) > $five_min){
		            				$tab3 = $tab3 + $five_min;
		            			} else{
		            				$tab3 = $tab3 + ($current_timestamp - $last_timestamp);
		            			}
		            			break;
		            		case '4':
		            			if (($current_timestamp - $last_timestamp) > $five_min){
		            				$tab4 = $tab4 + $five_min;
		            			} else{
		            				$tab4 = $tab4 + ($current_timestamp - $last_timestamp);
		            			}
		            			break;
		            		default:
		            			break;
		            	}	
		            }
		            $last_state = $current_state;
		            $last_timestamp = $current_timestamp;

					//$codes = substr($codes, 0, 8);
					//echo substr($codes, 0, 8) . "\n";		
			    }
		    	fclose($handle);
		    	$tab1_min = floor($tab1/(1000*60));
		    	$tab1_sec = floor($tab1/1000) - $tab1_min*60;
		    	$tab2_min = floor($tab2/(1000*60));
		    	$tab2_sec = floor($tab2/1000) - $tab2_min*60;
		    	$tab3_min = floor($tab3/(1000*60));
		    	$tab3_sec = floor($tab3/1000) - $tab3_min*60;
		    	$tab4_min = floor($tab4/(1000*60));
		    	$tab4_sec = floor($tab4/1000) - $tab4_min*60;
		    	
		    	$tab1 = 0;
		    	$tab2 = 0;
		    	$tab3 = 0;
		    	$tab4 = 0;
		    	$current_state = 0;
				$last_state = 0;
				$current_timestamp = 0;
				$last_timestamp = 0;
		    	$alcoholtest[] = array('date' => $row['Date'], 'tab1' => $tab1_min.":".$tab1_sec, 'tab2' => $tab2_min.":".$tab2_sec, 'tab3' => $tab3_min.":".$tab3_sec, 'tab4' => $tab4_min.":".$tab4_sec);
			} 

		}
    }
}
echo json_encode($alcoholtest);
?>
