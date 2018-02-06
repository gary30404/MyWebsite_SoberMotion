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


$sql = "SELECT StartDate FROM `Offender` WHERE UserID = '". $userid . "'" ;
$result = $conn->query($sql) or die("Could not select examples");;

while($row = $result->fetch_assoc()) {
	$date_pivote_point0 = date("Y-m-d", strtotime($row["StartDate"]));
}
$date_pivote_point1 = date('Y-m-d', strtotime($date_pivote_point0. ' + 28 days'));
$date_pivote_point2 = date('Y-m-d', strtotime($date_pivote_point0. ' + 56 days'));

$sql = "SELECT Date FROM `BreathDetail` WHERE UserID='$userid' GROUP BY Date";

$result = $conn->query($sql) or die("Could not select examples");;

$stack = [];

$tab1_1 = 0;
$tab2_1 = 0;
$tab3_1 = 0;
$tab4_1 = 0;
$tab1_2 = 0;
$tab2_2 = 0;
$tab3_2 = 0;
$tab4_2 = 0;
$tab1_3 = 0;
$tab2_3 = 0;
$tab3_3 = 0;
$tab4_3 = 0;
$current_state = 0;
$last_state = 0;
$current_timestamp = 0;
$last_timestamp = 0;
$five_min = 3*60*1000;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	if ($row['Date'] >= $date_pivote_point0 && $row['Date'] < $date_pivote_point1){
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
			            				$tab1_1 = $tab1_1 + $five_min;
			            			} else{
			            				$tab1_1 = $tab1_1 + ($current_timestamp - $last_timestamp);
			            			}
			            			break;
			            		case '2':
			            			if (($current_timestamp - $last_timestamp) > $five_min){
			            				$tab2_1 = $tab2_1 + $five_min;
			            			} else{
			            				$tab2_1 = $tab2_1 + ($current_timestamp - $last_timestamp);
			            			}
			            			break;
			            		case '3':
			            			if (($current_timestamp - $last_timestamp) > $five_min){
			            				$tab3_1 = $tab3_1 + $five_min;
			            			} else{
			            				$tab3_1 = $tab3_1 + ($current_timestamp - $last_timestamp);
			            			}
			            			break;
			            		case '4':
			            			if (($current_timestamp - $last_timestamp) > $five_min){
			            				$tab4_1 = $tab4_1 + $five_min;
			            			} else{
			            				$tab4_1 = $tab4_1 + ($current_timestamp - $last_timestamp);
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

			    	$current_state = 0;
					$last_state = 0;
					$current_timestamp = 0;
					$last_timestamp = 0;
				} 
			}
		} else if ($row['Date'] >= $date_pivote_point1 && $row['Date'] < $date_pivote_point2) {
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
			            				$tab1_2 = $tab1_2 + $five_min;
			            			} else{
			            				$tab1_2 = $tab1_2 + ($current_timestamp - $last_timestamp);
			            			}
			            			break;
			            		case '2':
			            			if (($current_timestamp - $last_timestamp) > $five_min){
			            				$tab2_2 = $tab2_2 + $five_min;
			            			} else{
			            				$tab2_2 = $tab2_2 + ($current_timestamp - $last_timestamp);
			            			}
			            			break;
			            		case '3':
			            			if (($current_timestamp - $last_timestamp) > $five_min){
			            				$tab3_2 = $tab3_2 + $five_min;
			            			} else{
			            				$tab3_2 = $tab3_2 + ($current_timestamp - $last_timestamp);
			            			}
			            			break;
			            		case '4':
			            			if (($current_timestamp - $last_timestamp) > $five_min){
			            				$tab4_2 = $tab4_2 + $five_min;
			            			} else{
			            				$tab4_2 = $tab4_2 + ($current_timestamp - $last_timestamp);
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
			    	
			    	$current_state = 0;
					$last_state = 0;
					$current_timestamp = 0;
					$last_timestamp = 0;
				}
			}
		} else if ($row['Date'] >= $date_pivote_point2) {
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
			            				$tab1_3 = $tab1_3 + $five_min;
			            			} else{
			            				$tab1_3 = $tab1_3 + ($current_timestamp - $last_timestamp);
			            			}
			            			break;
			            		case '2':
			            			if (($current_timestamp - $last_timestamp) > $five_min){
			            				$tab2_3 = $tab2_3 + $five_min;
			            			} else{
			            				$tab2_3 = $tab2_3 + ($current_timestamp - $last_timestamp);
			            			}
			            			break;
			            		case '3':
			            			if (($current_timestamp - $last_timestamp) > $five_min){
			            				$tab3_3 = $tab3_3 + $five_min;
			            			} else{
			            				$tab3_3 = $tab3_3 + ($current_timestamp - $last_timestamp);
			            			}
			            			break;
			            		case '4':
			            			if (($current_timestamp - $last_timestamp) > $five_min){
			            				$tab4_3 = $tab4_3 + $five_min;
			            			} else{
			            				$tab4_3 = $tab4_3 + ($current_timestamp - $last_timestamp);
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
			    	
			    	
			    	$current_state = 0;
					$last_state = 0;
					$current_timestamp = 0;
					$last_timestamp = 0;
				}
			}
		}	  
    }
    $tab1_min_1 = floor($tab1_1/(1000*60));
	$tab1_sec_1 = floor($tab1_1/1000) - $tab1_min_1*60;
	$tab2_min_1 = floor($tab2_1/(1000*60));
	$tab2_sec_1 = floor($tab2_1/1000) - $tab2_min_1*60;
	$tab3_min_1 = floor($tab3_1/(1000*60));
	$tab3_sec_1 = floor($tab3_1/1000) - $tab3_min_1*60;
	$tab4_min_1 = floor($tab4_1/(1000*60));
	$tab4_sec_1 = floor($tab4_1/1000) - $tab4_min_1*60;
	$tab1_min_2 = floor($tab1_2/(1000*60));
	$tab1_sec_2 = floor($tab1_2/1000) - $tab1_min_2*60;
	$tab2_min_2 = floor($tab2_2/(1000*60));
	$tab2_sec_2 = floor($tab2_2/1000) - $tab2_min_2*60;
	$tab3_min_2 = floor($tab3_2/(1000*60));
	$tab3_sec_2 = floor($tab3_2/1000) - $tab3_min_2*60;
	$tab4_min_2 = floor($tab4_2/(1000*60));
	$tab4_sec_2 = floor($tab4_2/1000) - $tab4_min_2*60;
	$tab1_min_3 = floor($tab1_3/(1000*60));
	$tab1_sec_3 = floor($tab1_3/1000) - $tab1_min_3*60;
	$tab2_min_3 = floor($tab2_3/(1000*60));
	$tab2_sec_3 = floor($tab2_3/1000) - $tab2_min_3*60;
	$tab3_min_3 = floor($tab3_3/(1000*60));
	$tab3_sec_3 = floor($tab3_3/1000) - $tab3_min_3*60;
	$tab4_min_3 = floor($tab4_3/(1000*60));
	$tab4_sec_3 = floor($tab4_3/1000) - $tab4_min_3*60;
    $alcoholtest[] = array('date' => '1', 'tab1' => $tab1_min_1.":".$tab1_sec_1, 'tab2' => $tab2_min_1.":".$tab2_sec_1, 'tab3' => $tab3_min_1.":".$tab3_sec_1, 'tab4' => $tab4_min_1.":".$tab4_sec_1, );
    $alcoholtest[] = array('date' => '2', 'tab1' => $tab1_min_2.":".$tab1_sec_2, 'tab2' => $tab2_min_2.":".$tab2_sec_2, 'tab3' => $tab3_min_2.":".$tab3_sec_2, 'tab4' => $tab4_min_2.":".$tab4_sec_2);
    $alcoholtest[] = array('date' => '3', 'tab1' => $tab1_min_3.":".$tab1_sec_3, 'tab2' => $tab2_min_3.":".$tab2_sec_3, 'tab3' => $tab3_min_3.":".$tab3_sec_3, 'tab4' => $tab4_min_3.":".$tab4_sec_3);
}
echo json_encode($alcoholtest);

?>
