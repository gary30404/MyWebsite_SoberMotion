<?php
$servername = "localhost";
$username = "root";
$password = "barrylam7f";
$dbname = "SoberMotion";

$userid = $_POST['userid'];
//$userid = 'DUI_008b';

$alcoholtest = array();
$clicklog = array(
'ENTER_MAIN_ACTIVITY',
'LEAVE_MAIN_ACTIVITY',
'ENTER_ABOUT_ACTIVITY',
'LEAVE_ABOUT_ACTIVITY',
'ENTER_SETTING_ACTIVITY',
'LEAVE_SETTING_ACTIVITY',
'ENTER_CHECK_ACTIVITY ',

'LEAVE_CHECK_ACTIVITY',
'CLICK_GPS_SETTING',
'CLICK_BLE_SETTING',
'CLICK_ABOUT_SETTING',
'CLICK_SETTING',
'CLICK_TAB1',
'CLICK_TAB2',
'CLICK_TAB3',
'CLICK_TAB4',
'CLICK_BACK',//

//
'ENTER_CAMERA_ACTIVITY',//
'LEAVE_CAMERA_ACTIVITY',//
'ENTER_CHOOSE_REASON_ACTIVITY',//
'LEAVE_CHOOSE_REASON_ACTIVITY',//
'ENTER_AFTER_TEST_ACTIVITY',//
'LEAVE_AFTER_TEST_ACTIVITY',//
'ENTER_FILL_SELF_DRIVE_ACTIVITY',//
'LEAVE_FILL_SELF_DRIVE_ACTIVITY',//
'ENTER_REVIEW_AFTER_TEST_ACTIVITY',//
'LEAVE_REVIEW_AFTER_TEST_ACTIVITY',//
'ENTER_REVIEW_CHOOSE_REASON_ACTIVITY',//
'LEAVE_REVIEW_CHOOSE_REASON_ACTIVITY',//
'ENTER_TAB1_ACTIVITY',//
'ENTER_TAB2_ACTIVITY',//
'ENTER_TAB3_ACTIVITY',//
'ENTER_TAB4_ACTIVITY',//

//settingActivity
'OPEN_ALARM_SETTING',//
'SET_ALARM_THIRTY_MIN',//
'SET_ALARM_ONE_HOUR',//
'SET_ALARM_THREE_HOUR',//
'SET_ALARM_DISABLE',//
'CLOSE_ALARM_SETTING',//
'OPEN_MARKER_IMAGE_SETTING',//
'SET_MARKER_IMAGE_NOT_UPLOAD',//
'SET_MARKER_IMAGE_UPLOAD',//
'CLOSE_MARKER_IMAGE_SETTING',//

'CLICK_CHECK_TEST_START',

'TAG_ALC_TEST_CLICK',
'Tag_Self_Drive_Click',
'Tag_None_Self_Drive_Click',
'Tag_Confirm_Click',
'Tag_Cancel_Click',

'Achieve_Self_Manage_Record_Scroll_Left',
'Achieve_Self_Manage_Record_Scroll_Right',

'Tag_Alc_Test_Self_Drive_Click',
'Tag_Alc_Test_None_Self_Drive_Click',
'Tag_Alc_Test_Drive_Question_Skip_Click',
'Tag_Alc_Test_Drive_Question_Confirm_Click',

'Alc_Record_Detail_Click',
'Alc_Record_Slide_Left',
'Alc_Record_Slide_Right ',

'Alc_Record_Other_Reason_Edit_Click',
'Alc_Record_Detail_Confirm_Click',

'Alc_Test_Reason_Edit_Energy_Click',
'Alc_Test_Reason_Edit_Social_Click',
'Alc_Test_Reason_Edit_Sleep_Click',
'Alc_Test_Reason_Edit_Bored_Click',
'Alc_Test_Reason_Edit_SocialPressure_Click',
'Alc_Test_Reason_Edit_Family_Click',
'Alc_Test_Reason_Edit_Conflict_Click',
'Alc_Test_Reason_Edit_Upset_Click',
'Alc_Test_Reason_Edit_Other_Click',
'Alc_Test_Reason_Edit_Complete_Click',
'Reason_Input_Click',
'Reason_confirm_Click',

'Test_Start_Click',

'Alc_Test_Can_Drive_Click',
'Alc_Test_Can_Not_Drive_Click',

'Alc_Test_Reason_Energy_Click',
'Alc_Test_Reason_Social_Click',
'Alc_Test_Reason_Sleep_Click',
'Alc_Test_Reason_Bored_Click',
'Alc_Test_Reason_SocialPressure_Click',
'Alc_Test_Reason_Family_Click',
'Alc_Test_Reason_Conflict_Click',
'Alc_Test_Reason_Upset_Click',
'Alc_Test_Reason_Other_Click',
'Alc_Test_Reason_Skip_Click',
'Alc_Test_Reason_Complete_Click',

'Alc_Test_Other_Reason_Input_Click',
'Alc_Test_Other_Reason_Confirm_Click',

'Alc_Test_Report_Confirm_Click'
);

$long = array(
//access activity
'90000000',
'90000001',
'90000002',
'90000003',
'90000004',
'90000005',
'90000006',
'90000007',
'90000008',
'90000009',
'90000010',

//option menu
'90000011',

//option menu
'90000012',
'90000013',
'90000014',
'90000015',
'99999999',//

//access activity
'90000016',//
'90000017',//
'90000018',//
'90000019',//
'90000020',//
'90000021',//
'90000022',//
'90000023',//
'90000024',//
'90000025',//
'90000026',//
'90000027',//
'90000028',//
'90000029',//
'90000030',//
'90000031',//

//settingActivity
'50010000',//
'50010001',//
'50010002',//
'50010003',//
'50010004',//
'50020000',//
'50030000',//
'50030001',//
'50030002',//
'50040000',//

'4000000',
'40100000',
'40200000',
'40210000',
'40300000',
'40400000',

'40500000',
'40510000',

'40600000',
'40700000',
'40800000',
'40900000',

'30110000',
'30120000',
'30130000',

'30200000',
'30300000',

'30400000',
'30500000',
'30600000',
'30700000',
'30800000',
'30900000',
'31000000',
'31100000',
'31200000',
'31300000',
'31400000',
'31500000',

'10100000',

'10200000',
'10300000',

'10400000',
'10500000',
'10600000',
'10700000',
'10800000',
'10900000',
'11000000',
'11100000',
'11200000',
'11300000',
'11400000',

'11500000',
'11600000',

'11700000'
);

//$arr = array ('response'=>'error','comment'=>'test comment here');
//echo json_encode($arr);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Date FROM `BreathDetail` WHERE UserID='$userid' GROUP BY Date";

$result = $conn->query($sql) or die("Could not select examples");;

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
					//$codes = substr($codes, 0, 8);
					//echo substr($codes, 0, 8) . "\n";		
					if (false !== $key = array_search(substr($codes, 0, 8), $long)) {
			    		    //echo $clicklog[$key] . "\n";
					    $seconds = $timemills / 1000;
					    $date = date("d/m/Y H:i:s", $seconds);
					    $alcoholtest[] = array('times' => $date, 'clicklog' => $clicklog[$key]);
					} else {
			   		    $alcoholtest[] = array('times' => $date, 'clicklog' => "I CANNOT UNDERSTAND THE LOG.");
					}
			    }
		    	fclose($handle);
			} 

		}
    }
}
echo json_encode($alcoholtest);
?>
