<?php
/* Main page with two forms: sign up and log in */
require 'db.php' ;
include('session.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>首頁</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<style>
table.GeneratedTable {
  width: 100%;
  background-color: #ffffff;
  border-collapse: collapse;
  border-width: 2px;
  border-color: #ffcc00;
  border-style: solid;
  color: #000000;
}

table.GeneratedTable td {
  border-width: 2px;
  border-color: #9e9e9e;
  border-style: solid;
  padding: 2px;
  text-align: center;
   font-size: 92%; 
}
table.GeneratedTable th {
  border-width: 2px;
  border-color: #9e9e9e;
  border-style: solid;
  padding: 2px;
  text-align: center;
}
table.GeneratedTable thead {
  background-color: #c4d8db;
}

</style>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<!-- Navbar (sit on top) -->

<div class="w3-top">
    <div class="w3-bar w3-white w3-wide w3-padding w3-card-2">
        <a href="#home" class="w3-bar-item w3-button"><b>NTUIOX</b>  UbiCompLab</a>

        <div class="w3-right w3-hide-small">
            <?php 
                session_start();
                $user_check=$_SESSION['login_user'];
                if($user_check == 'ioxubicomp'){
                    echo '<a href="upload/FinalTarget_Web_User.php" class="w3-bar-item w3-button">臉部辨識</a>';
                }
            ?>
            <!--
            <a href="#projects" class="w3-bar-item w3-button">Projects</a>
            <a href="#about" class="w3-bar-item w3-button">About</a>
            <a href="#contact" class="w3-bar-item w3-button">Contact</a>
            -->
            <a href="dropout_index.php" class="w3-bar-item w3-button">Dropout</a>
            <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
	   </div>
    </div>
</div>


<div>
    <div id="projects" style="background-color: #112F5F; height: 105px; width: 97.5%; margin-left:1.3%;">
        <h2><FONT COLOR=white>SoberMotion</FONT></h2>
        <h3><FONT COLOR=white>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SoberMotion</FONT></h3>
<!-- Data  Section -->
<?php

$tag = 0;

abstract class ColumnTitle //enum column
{   
    const   JoinDate = 1;
    const   CheckIfReturn = 2;
    const   ReturnDate = 3;
    const   RevisitDate =4;
	const   WifiCheckDate = 5;
    const   SelfDriveLastMonth =6;
    const   UnknownDriveLastMonth =7;
    const   NotSelfDriveLastMonth =8;
    const   SelfDriveThisMonth =9;
    const   UnknownDriveThisMonth =10;
    const   NotSelfDriveThisMonth =11;
    const   UnderestimateRatioLastMonth = 12;
    const   UnderestimateRatioThisMonth = 13;
    const   SoberTestCompleteness_2_Ratio = 14;
    const   SoberTestCompleteness_3_Ratio= 15;
    const   FailFaceDetection = 16; 
    const   AchieveGainedProgress = 17;
    const   AppVersion = 18;
    const   More =19;
}
/*
$sql = "SELECT distinct Offender.UserID 
        FROM AlcoholInfluenceAssessment, Offender 
        WHERE AlcoholInfluenceAssessment.UserID = Offender.UserID and IsRegular = '1' and Dropout = '0'";
*/
$sql = "SELECT UserID FROM Offender WHERE Dropout!='1' ORDER BY id DESC";

foreach( $mysqli->query($sql) as $row){
    $UserIDs[] = $row["UserID"];
}

echo "<table id='table-1' class = 'GeneratedTable' >";
//first row
echo "<thead>";
echo "  <tr> 
        <th rowspan='2'>個案編號</th>
    	<th rowspan='2'>研究開始日期</th>
        <th rowspan='2'>結算日期</th>
    	<th rowspan='2'>下次觀護日期</th>
    	<th rowspan='2'>下次回診日期</th>
	    <th rowspan='2'>最後連線日期</th>
	    <th colspan='6'>未酒測確認的高速移動</th>
	    <th colspan='2'>低估比例</th>
	    <th colspan='2'>酒測完成度</th>
    	<th rowspan='2'>人臉辨識非本人次數</th>
    	<th colspan='3'>達標進度</th>
        <th rowspan='2'>APP版本</th>
    	<th rowspan='2'>想看更多</th>
        </tr>";
echo "  <tr>
	    <th>前月自駕</th>
        <th>前月未回報</th>
        <th>前月非自駕</th>
        <th>當月自駕</th>       
        <th>當月未回報</th>
        <th>當月非自駕</th>
        <th>前月</th>
        <th>當月</th>
        <th>一天兩個時段</th>
        <th>一天三個時段</th>
        <th>第一個月</th>
        <th>第二個月</th>
        <th>第三個月</th>
        </tr>";
echo "</thead>";

//data row
echo "<tbody>";
foreach($UserIDs as $UserID){
    echo "<tr>";
    echo "<td>";
    echo $UserID;
    echo "</td>";
	for ($i = 1 ; $i <= 19 ; $i++ ){
        switch ($i){
            case ColumnTitle::JoinDate:
                echo "<td>";
                $sql = "SELECT StartDate FROM `Offender` WHERE UserID = '". $UserID . "'" ;
                foreach ( $mysqli->query($sql) as $row){
				    $date_pivote_point0 = date("Y-m-d", strtotime($row["StartDate"]));
                	echo date("Y-m-d", strtotime($row["StartDate"]));
        		}
                $date_pivote_point1 = date('Y-m-d', strtotime($date_pivote_point0. ' + 20 days'));
                $date_pivote_point2 = date('Y-m-d', strtotime($date_pivote_point0. ' + 48 days'));
                //decide which month is
                if(strtotime('now')>=strtotime($date_pivote_point0) && strtotime('now') < strtotime($date_pivote_point1)){
                    $last_month_interval = -1;
				    $current_month_interval = 1;
                    $diff = abs(strtotime('now') - strtotime($date_pivote_point0));
                }else if(strtotime('now')>=strtotime($date_pivote_point1) && strtotime('now') < strtotime($date_pivote_point2)){
                    $last_month_interval = 1;
                    $current_month_interval = 2;
                    $diff = abs(strtotime('now') - strtotime($date_pivote_point1));
                }else if(strtotime('now')>=strtotime($date_pivote_point2)){
                    $last_month_interval = 2;
                    $current_month_interval = 3;
                    $diff = abs(strtotime('now') - strtotime($date_pivote_point2));
                }else{
                    $last_month_interval = 0;
                    $current_month_interval = 0;
                    $diff = 0;
                }
                $years = floor($diff / (365*60*60*24));
                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                $weeks = floor($days / 7);

                echo  "</td>";
                break;

            case ColumnTitle::CheckIfReturn:
                echo "<td>";
                $sql = "SELECT CheckDate FROM `CheckIfReturnCalendar` WHERE UserID = '". $UserID . "' ORDER BY id DESC LIMIT 1" ;
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo date("Y-m-d", strtotime($row["CheckDate"]));
                            $CheckDate = date("Y-m-d", strtotime($row["CheckDate"]));
                        }
                } else{
                    echo "--";
                }
                echo  "</td>";
                break;

            case ColumnTitle::ReturnDate:
                echo "<td>";
                $sql = "SELECT ReturnDate FROM `ReturnCalendar` WHERE UserID = '". $UserID . "' ORDER BY id DESC LIMIT 1" ;
                if ($mysqli->query($sql)->num_rows > 0){
                    foreach ( $mysqli->query($sql) as $row){
               			$date[] = $row["ReturnDate"];
    				}
                    if(count(max($date))>0){
                        echo date("Y-m-d", strtotime(max($date)));
                    }
                    unset($date);
                }else{
                    echo "--";
                }
        		echo "</td>"; 
    			break;

            case ColumnTitle::RevisitDate:
                echo "<td>";
                $sql = "SELECT RevisitDate FROM RevisitCalendar WHERE UserID = '". $UserID . "'" ;
                if ($mysqli->query($sql)->num_rows > 0){
                    foreach ( $mysqli->query($sql) as $row){
                        $date[] = $row["RevisitDate"];
                    }   
                    if(count(max($date))>0){
                        echo date("Y-m-d", strtotime(max($date)));
                    }
                    unset($date);
                }else{
                    echo "--";
                }
                echo "</td>"; 
                break;

            case ColumnTitle::WifiCheckDate:
                echo "<td>";
                $sql = "SELECT ConnectionCheckTime FROM `Offender` WHERE UserID = '".$UserID."'";
                foreach ( $mysqli->query($sql) as $row){
                    echo date("Y-m-d h:i:s \G\M\T", strtotime($row["ConnectionCheckTime"]));
                }
                echo "</td>";
                break;

            case ColumnTitle::SelfDriveLastMonth :
                $num  = 0;
                echo "<td style='width:4%' height='100'>";
                if($last_month_interval==-1){
                    echo "--";
                }else{
                    if($last_month_interval==1){
                        $sql = "SELECT *
                                FROM `VehicleUseTag` 
                                WHERE UserID = '". $UserID . "' and IsSelfDrive = 1 and VehicleUseDate BETWEEN '".$date_pivote_point0."' AND '".$date_pivote_point1."'" ;
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()) {
                                //echo $row["total"];
                                $num++;
                            }
                            echo $num;
                        }else{
                            echo "0";
                        }
                    }else if($last_month_interval==2){
                        $sql = "SELECT *
                                FROM `VehicleUseTag` 
                                WHERE UserID = '". $UserID . "' and IsSelfDrive = 1 and VehicleUseDate BETWEEN '".$date_pivote_point1."' AND '".$date_pivote_point2."'";
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()) {
                                //echo $row["total"];
                                $num++;
                            }
                            echo $num;
                        }else{
                            echo "0";
                        }
                    }else{
                        echo "--";
                    }
                }
                echo "</td>";
                break;

	  	    case ColumnTitle::UnknownDriveLastMonth :
        		echo "<td style='width:4%' height='100'>";
                if($last_month_interval==-1){
                    echo "--";
                }else{
                    if($last_month_interval==1){
                        $sql = "SELECT count(*) as `total` 
                                FROM `VehicleUseTag` 
                                WHERE UserID = '". $UserID . "' and VehicleUseTag.IsSelfDrive = -1 and VehicleUseDate BETWEEN '".$date_pivote_point0."' AND '".$date_pivote_point1."'" ;
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()) {
                                echo $row["total"];
                            }
                        }else{
                            echo "0";
                        }
                    }else if($last_month_interval==2){
                        $sql = "SELECT count(*) as `total` 
                                FROM `VehicleUseTag` 
                                WHERE UserID = '". $UserID . "' and VehicleUseTag.IsSelfDrive = -1 and VehicleUseDate BETWEEN '".$date_pivote_point1."' AND '".$date_pivote_point2."'";
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()) {
                                echo $row["total"];
                            }
                        }else{
                            echo "0";
                        }
                    }else{
                        echo "--";
                    }
                }
                echo "</td>";
                break;  

            case ColumnTitle::NotSelfDriveLastMonth:
                echo "<td style='width:4%' height='100'>";
                if($last_month_interval==-1){
				    echo "--";
                }else{ 
				    if($last_month_interval==1){
                        $sql = "SELECT count(*) as `total` 
                                FROM `VehicleUseTag` 
                                WHERE UserID = '". $UserID . "' and VehicleUseTag.IsSelfDrive = 0 and VehicleUseDate BETWEEN '".$date_pivote_point0."' AND '".$date_pivote_point1."'" ;
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()) {
                                echo $row["total"];
                            }
                        }else{
                           echo "0";
                        }
				    }else if($last_month_interval==2){
                        $sql = "SELECT count(*) as `total` 
                                FROM `VehicleUseTag` 
                                WHERE UserID = '". $UserID . "' and VehicleUseTag.IsSelfDrive = 0 and VehicleUseDate BETWEEN '".$date_pivote_point1."' AND '".$date_pivote_point2."'";
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()) {
                                echo $row["total"];
                            }
                        }else{
                           echo "0";
                        }
				    }else{
					   echo "--";
				    }
                }
                echo "</td>";
                break;

    		case ColumnTitle::SelfDriveThisMonth:
    			echo "<td style='width:4%' height='100'>";
                if($current_month_interval!=0){
                    if($current_month_interval==1){
                        $sql = "SELECT count(*) as `total`
                                FROM `VehicleUseTag`
                                WHERE UserID = '".$UserID."' and VehicleUseTag.IsSelfDrive = 1 and VehicleUseDate BETWEEN '".$date_pivote_point0."' AND NOW()";
                    }else if($current_month_interval==2){
                        $sql = "SELECT count(*) as `total`
                                FROM `VehicleUseTag`
                                WHERE UserID = '".$UserID."' and VehicleUseTag.IsSelfDrive = 1 and VehicleUseDate BETWEEN '".$date_pivote_point1."' AND NOW()";
                    }else if($current_month_interval==3){
                        $sql = "SELECT count(*) as `total`
                                FROM `VehicleUseTag`
                                WHERE UserID = '".$UserID."' and VehicleUseTag.IsSelfDrive = 1 and VehicleUseDate BETWEEN '".$date_pivote_point2."' AND NOW()";
                    }
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo $row["total"];
                        }
                    }else{
                        echo "0";
                    }
                }else{
                    echo "--";
                }
    			echo "</td>";
    			break;

    		case ColumnTitle::UnknownDriveThisMonth:
    			echo "<td style='width:4%' height='100'>";
                if($current_month_interval!=0){
                    if($current_month_interval==1){
                        $sql = "SELECT count(*) as `total`
                                FROM `VehicleUseTag`
                                WHERE UserID = '".$UserID."' and VehicleUseTag.IsSelfDrive = -1 and VehicleUseDate BETWEEN '".$date_pivote_point0."' AND NOW()";
                    }else if($current_month_interval==2){
                        $sql = "SELECT count(*) as `total`
                                FROM `VehicleUseTag`
                                WHERE UserID = '".$UserID."' and VehicleUseTag.IsSelfDrive = -1 and VehicleUseDate BETWEEN '".$date_pivote_point1."' AND NOW()";
                    }else if($current_month_interval==3){
                        $sql = "SELECT count(*) as `total`
                                FROM `VehicleUseTag`
                                WHERE UserID = '".$UserID."' and VehicleUseTag.IsSelfDrive = -1 and VehicleUseDate BETWEEN '".$date_pivote_point2."' AND NOW()";
                    }
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                            echo $row["total"];
                        }
                    }else{
                        echo "0";
                    }
                }else{
                    echo "--";
                }
                echo "</td>";
    			break;

    		case ColumnTitle::NotSelfDriveThisMonth:
    			echo "<td style='width:4%' height='100'>";
                if($current_month_interval!=0){
                    if($current_month_interval==1){
                        $sql = "SELECT count(*) as `total` 
                                FROM `VehicleUseTag` 
                                WHERE UserID = '".$UserID."' and VehicleUseTag.IsSelfDrive = 0 and VehicleUseDate BETWEEN '".$date_pivote_point0."' AND NOW()";         
                    }else if($current_month_interval==2){
                        $sql = "SELECT count(*) as `total` 
                                FROM `VehicleUseTag` 
                                WHERE UserID = '".$UserID."' and VehicleUseTag.IsSelfDrive = 0 and VehicleUseDate BETWEEN '".$date_pivote_point1."' AND NOW()";
                    }else if($current_month_interval==3){
                        $sql = "SELECT count(*) as `total` 
                                FROM `VehicleUseTag` 
                                WHERE UserID = '".$UserID."' and VehicleUseTag.IsSelfDrive = 0 and VehicleUseDate BETWEEN '".$date_pivote_point2."' AND NOW()";
                    }
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                            echo $row["total"];
                        }
                    }else{
                        echo "0";
                    }
                }else{
                    echo "--";
                }
                echo "</td>";
    			break;

    		case ColumnTitle::UnderestimateRatioLastMonth:
    			echo "<td width= '3%' height='100'>";
    			if($last_month_interval==-1){
                    echo "--";
                }else{
                    if($last_month_interval==1){
                        $drink = 0;
                        $num = 0;
                        $sql = "SELECT * FROM `AlcoholInfluenceAssessment` 
                                WHERE UserID = '". $UserID . "' and Timestamp BETWEEN '".$date_pivote_point0."' AND '".$date_pivote_point1."'" ;
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()) {
                                if ($row['Brac']>=0.15){
                                    $drink++;
                                    if ($row['IsSelfPredictCorrect'] == 0){
                                        $num++;
                                    }
                                }
                            }
                            if ($drink == 0){
                                echo "0.0%<br>";
                                echo "(".$num."/".$drink.")";
                            } else{
                                $result = $num/$drink;
                                echo number_format((float)($result*100), 1, '.', '')."";
                                echo "<br>";
                                echo "(".$num."/".$drink.")";
                            }
                        }else{
                            echo "0.0%";
                        }
                    }else if($last_month_interval==2){
    					$drink = 0;
                        $num = 0;
                        $sql = "SELECT * FROM `AlcoholInfluenceAssessment` 
                                WHERE UserID = '". $UserID . "' and Timestamp BETWEEN '".$date_pivote_point1."' AND '".$date_pivote_point2."'" ;
                        $result = $mysqli->query($sql);
                        if ($result->num_rows > 0){
                            while($row = $result->fetch_assoc()) {
                                if ($row['Brac']>=0.15){
                                    $drink++;
                                    if ($row['IsSelfPredictCorrect'] == 0){
                                        $num++;
                                    }
                                }
                            }
                            if ($drink == 0){
                                echo "0.0%<br>";
                                echo "(".$num."/".$drink.")";
                            } else{
                                $result = $num/$drink;
                                echo number_format((float)($result*100), 1, '.', '')."";
                                echo "<br>";
                                echo "(".$num."/".$drink.")";
                            }
                        }else{
                            echo "0.0%";
                        }
                    }else{
                        echo "--";
                    }
    			}
    			echo "</td>";
    			break;

    		case ColumnTitle::UnderestimateRatioThisMonth:
    			echo "<td width= '3%' height='100'>";
                if($current_month_interval!=0){
                    $drink = 0;
                    $num = 0;
                    if($current_month_interval==1){
                        $sql1 = "SELECT *
                                FROM `AlcoholInfluenceAssessment`
                                WHERE UserID = '". $UserID . "' and Timestamp BETWEEN '".$date_pivote_point0."' AND NOW()" ;
                    }else if($current_month_interval==2){
                        $sql1 = "SELECT *
                                FROM `AlcoholInfluenceAssessment`
                                WHERE UserID = '". $UserID . "' and Timestamp BETWEEN '".$date_pivote_point1."' AND NOW()" ;
                    }else if($current_month_interval==3){
                        $sql1 = "SELECT *
                                FROM `AlcoholInfluenceAssessment`
                                WHERE UserID = '". $UserID . "' and Timestamp BETWEEN '".$date_pivote_point2."' AND NOW()" ;
                    }
                    $result = $mysqli->query($sql1);
                    if ($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                            if ($row['Brac']>=0.15){
                                $drink++;
                                if ($row['IsSelfPredictCorrect'] == 0){
                                    $num++;
                                }
                            }
                        }
                        if ($drink == 0){
                            echo "0.0%<br>";
                            echo "(".$num."/".$drink.")";
                        } else{
                            $result = $num/$drink;
                            echo number_format((float)($result*100), 1, '.', '')."";
                            echo "<br>";
                            echo "(".$num."/".$drink.")";
                        }
                    }else{
                        echo "0.0%";
                    }
                } else{
                    echo "--";
                }
                echo "</td>";
    			break;

    		case ColumnTitle::SoberTestCompleteness_2_Ratio:
    			echo "<td width= '5%' height='100'>";
    			$Today = date("Y-m-d",time());
			$sql = "SELECT SUM(IsRegular) as `isRegular_count_per_day` 
				FROM AlcoholInfluenceAssessment 
                        	WHERE UserID = '" . $UserID . "' AND Date != '" . $Today . "' AND Date >= '" .$date_pivote_point0. "' group by Date";
    			$result = $mysqli->query($sql);
    			$count = 0;
    			while($row = $result->fetch_assoc()) {
    				if($row["isRegular_count_per_day"]>=2){
    					$count = $count + 1;
    				}                   
                	}
    			if ($count > 0){	
    				$now = time(); // or your date as wells
    				$start_date = strtotime($date_pivote_point0);
    				$datediff = time() - $start_date;
    				$result = $count/floor($datediff / (60 * 60 * 24)); 
				echo number_format((float)($result*100), 1, '.', '')."%";	
        			echo "(".$count."/".floor($datediff / (60 * 60 * 24)).")";
    			}else{
                    		echo "0.0%";
                	}			 	
    			echo "</td>";
    			break;

    		case ColumnTitle::SoberTestCompleteness_3_Ratio:
    			echo "<td width= '5%' height='100'>";
                	$Today = date("Y-m-d",time());
               		$sql = "SELECT SUM(IsRegular) as `isRegular_count_per_day` 
                        	FROM AlcoholInfluenceAssessment 
                        	WHERE UserID = '".$UserID."' and Date != '".$Today."' AND Date >= '" .$date_pivote_point0. "' group by Date";
    			$result = $mysqli->query($sql);
                	$count = 0;
                	while($row = $result->fetch_assoc()) {
                    	if($row["isRegular_count_per_day"]>=3){
                        	$count = $count + 1;
                    	}
                	}
                	if ($count > 0){
                    		$now = time(); // or your date as well
                    		$start_date = strtotime($date_pivote_point0);
                    		$datediff = $now - $start_date;
                    		$result = $count/floor($datediff / (60 * 60 * 24));
                   		echo number_format((float)($result*100), 1, '.', '')."%"; 
                    		echo "(".$count."/".floor($datediff / (60 * 60 * 24)).")";
    			}else{
                    		echo "0.0%";
                	}
                	echo "</td>";
    			break;

    		case ColumnTitle::FailFaceDetection:
    			echo "<td width= '5%' height='100'>";
    			$sql = "SELECT TimestampMillis FROM `AlcoholInfluenceAssessment` WHERE UserID = '".$UserID."'";
    			$result_sober_test_id = $mysqli->query($sql);
                $face_test_num = $result_sober_test_id->num_rows;
    			$count = 0;
    			if($result_sober_test_id->num_rows > 0){
    				while($row = $result_sober_test_id->fetch_assoc()) {
                        $sql = "SELECT FinalTarget 
                                FROM `FaceDetection` 
                                WHERE KeyInAlcoholInfluenceAssessment = '".$row["TimestampMillis"]."' and FinalTarget = '".$UserID."'";
    					$result = $mysqli->query($sql);
    					if($result->num_rows<6){
    						$count = $count + 1;
    					}
                    }
                    $per = $count/$face_test_num;
                    echo number_format((float)($per*100), 1, '.', '')."%"; 

                    //echo "<a href=face_failed.php?val=" .$UserID. ">" . $p . "</a>";
                    echo "<br>";
                    echo "<a href=face_failed.php?val=" .$UserID. ">"."(".$count."/".$face_test_num.")". "</a>";
    			}else{
    				echo "--";
    			}
    			echo "</td>";			
    			break;

    		case ColumnTitle::AchieveGainedProgress:
    			//echo "<td>";
    			$d250 = date('Y-m-d', strtotime($date_pivote_point0. ' - 1 days'));
                $total_credit = 0;
                $total_credit_sober = 0;
                $total_credit_report = 0;
                $total_credit_25 = 0;
                $print_td = 0;  //
                $total_credit_1 = 0;
                $total_credit_sober_1 = 0;
                $total_credit_report_1 = 0;
                $total_credit_25_1 = 0;
                $print_td_1 = 0;
                $total_credit_2 = 0;
                $total_credit_sober_2 = 0;
                $total_credit_report_2 = 0;
                $total_credit_25_2 = 0;
                $print_td_2 = 0;

                if($current_month_interval!=0){
                    if($current_month_interval==1){
                    	$first_month = date('Y-m-d', strtotime($CheckDate. ' - 49 days'));
                        $sql_sober = "SELECT SUM(CreditGained) as `sober_credit`
                                  FROM `UserGetCredit` 
                                  WHERE UserID = '".$UserID."' AND (Method = 1 OR Method = 2 or Method = 3 OR Method = 4) AND ObtainDate BETWEEN '".$first_month."' AND NOW() GROUP BY ObtainDate";       
                        $sql_report = "SELECT SUM(CreditGained) as `sober_report`
                                   FROM `UserGetCredit` 
                                   WHERE UserID = '".$UserID."' AND (Method = 5 OR Method = 6 or Method = 7 OR Method = 8) AND ObtainDate BETWEEN '".$first_month."' AND NOW() GROUP BY ObtainDate";
                        $sql_add_credit = "SELECT SUM(CreditGained) as `sober_25`
                                   FROM `UserGetCredit` 
                                   WHERE UserID = '".$UserID."' AND Method = 50 AND ObtainDate BETWEEN '".$d250."' AND NOW() GROUP BY ObtainDate";
                        $result_sober = $mysqli->query($sql_sober);
                        $result_report = $mysqli->query($sql_report);
                        $result_25 = $mysqli->query($sql_add_credit);
                        while($row = $result_25->fetch_assoc()) {
                            $total_credit_25 = $total_credit_25 + $row["sober_25"];
                            $print_td = 1;
                        }
                        while($row = $result_sober->fetch_assoc()) {
                            $total_credit_sober = $total_credit_sober + $row["sober_credit"];
                        }
                        while($row = $result_report->fetch_assoc()) {
                            $total_credit_report = $total_credit_report + $row["sober_report"];
                        }
                        if ($print_td == 1){
                            echo "<td bgcolor='#FFB6C1' width= '4%'>";
                        } else{
                            echo "<td width= '4%'>";
                        }
                        $total_credit = ($total_credit_sober + $total_credit_report + $total_credit_25)*10;
                        echo nl2br(($total_credit)."分\n");
                        echo nl2br(($total_credit_sober*10)."分酒測\n");
                        echo nl2br(($total_credit_report*10)."分回報\n");
                        if($total_credit>=1000){
                            echo nl2br("不需觀護");
                        }else{
                            echo nl2br("需觀護");
                        }
                        $sql_credit = "SELECT `TotalCredit` FROM `UserGetCredit` WHERE UserID = '".$UserID."' ORDER BY id DESC LIMIT 1";
                        $sql_credit_used = "SELECT `CreditUsed` FROM `CreditExchangeHistory` WHERE UserID = '".$UserID."'";
                        $result_credit = $mysqli->query($sql_credit);
                        $result_credit_used = $mysqli->query($sql_credit_used);
                        $credit = '';
                        if($result_credit->num_rows > 0){
                            while($row = $result_credit->fetch_assoc()) {
                                $credit = $row['TotalCredit'];
                            }
                        }
                        if($result_credit_used->num_rows > 0){
                            while($row = $result_credit->fetch_assoc()) {
                                $credit = $credit - $row['CreditUsed'];
                            }
                        }
                        echo "<br>".$credit."點可換".floor($credit/38)."張禮卷";
                        echo "</td>";
                        //
                        echo "<td width= '4%'>";
                        echo nl2br("0分<br>");
                        echo nl2br("0分酒測<br>");
                        echo nl2br("0分回報<br>");
                        echo nl2br("需觀護");
                        echo "</td>";
                        //
                        echo "<td width= '4%'>";
                        echo nl2br("0分<br>");
                        echo nl2br("0分酒測<br>");
                        echo nl2br("0分回報<br>");
                        echo nl2br("需觀護");
                        echo "</td>";

                    }else if($current_month_interval==2){
                        if ($CheckDate > $date_pivote_point1){
                        	$first_month = date('Y-m-d', strtotime($CheckDate. ' - 49 days'));
                            $first_month_last_day = date('Y-m-d', strtotime($first_month. ' + 20 days'));
                            $second_month = date('Y-m-d', strtotime($first_month. ' + 21 days'));
                        } else{
                            $first_month = date('Y-m-d', strtotime($CheckDate. ' - 21 days'));
                            $first_month_last_day = date('Y-m-d', strtotime($first_month. ' + 20 days'));
                            $second_month = date('Y-m-d', strtotime($first_month. ' + 21 days'));
                        }
                        $sql_sober = "SELECT SUM(CreditGained) as `sober_credit`
                                  FROM `UserGetCredit` 
                                  WHERE UserID = '".$UserID."' AND (Method = 1 OR Method = 2 or Method = 3 OR Method = 4) AND ObtainDate BETWEEN '".$first_month."' AND '".$first_month_last_day."' GROUP BY ObtainDate";       
                        $sql_report = "SELECT SUM(CreditGained) as `sober_report`
                                   FROM `UserGetCredit` 
                                   WHERE UserID = '".$UserID."' AND (Method = 5 OR Method = 6 or Method = 7 OR Method = 8) AND ObtainDate BETWEEN '".$first_month."' AND '".$first_month_last_day."' GROUP BY ObtainDate";
                        $sql_add_credit = "SELECT SUM(CreditGained) as `sober_25`
                                   FROM `UserGetCredit` 
                                   WHERE UserID = '".$UserID."' AND Method = 50 AND ObtainDate BETWEEN '".$d250."' AND '".$first_month_last_day."' GROUP BY ObtainDate";
                        $result_sober = $mysqli->query($sql_sober);
                        $result_report = $mysqli->query($sql_report);
                        $result_25 = $mysqli->query($sql_add_credit);
                        while($row = $result_25->fetch_assoc()) {
                            $total_credit_25 = $total_credit_25 + $row["sober_25"];
                            $print_td = 1;
                        }
                        while($row = $result_sober->fetch_assoc()) {
                            $total_credit_sober = $total_credit_sober + $row["sober_credit"];
                        }
                        while($row = $result_report->fetch_assoc()) {
                            $total_credit_report = $total_credit_report + $row["sober_report"];
                        }
                        if ($print_td == 1){
                            echo "<td bgcolor='#FFB6C1' width= '4%'>";
                        } else{
                            echo "<td width= '4%'>";
                        }
                        $total_credit = ($total_credit_sober + $total_credit_report + $total_credit_25)*10;
                        echo nl2br(($total_credit)."分\n");
                        echo nl2br(($total_credit_sober*10)."分酒測\n");
                        echo nl2br(($total_credit_report*10)."分回報\n");
                        if($total_credit>=1000){
                            echo nl2br("不需觀護");
                        }else{
                            echo nl2br("需觀護");
                        }
                        echo "</td>";
                        //2
                        $sql_sober = "SELECT SUM(CreditGained) as `sober_credit`
                              FROM `UserGetCredit` 
                              WHERE UserID = '".$UserID."' AND (Method = 1 OR Method = 2 or Method = 3 OR Method = 4) AND ObtainDate BETWEEN '".$second_month."' AND NOW() GROUP BY ObtainDate";       
                        $sql_report = "SELECT SUM(CreditGained) as `sober_report`
                               FROM `UserGetCredit` 
                               WHERE UserID = '".$UserID."' AND (Method = 5 OR Method = 6 or Method = 7 OR Method = 8) AND ObtainDate BETWEEN '".$second_month."' AND NOW() GROUP BY ObtainDate";
                        $sql_add_credit = "SELECT SUM(CreditGained) as `sober_25`
                                   FROM `UserGetCredit` 
                                   WHERE UserID = '".$UserID."' AND Method = 50 AND ObtainDate BETWEEN '".$second_month."' AND NOW() GROUP BY ObtainDate";
                        $result_sober = $mysqli->query($sql_sober);
                        $result_report = $mysqli->query($sql_report);
                        $result_25 = $mysqli->query($sql_add_credit);
                        while($row = $result_25->fetch_assoc()) {
                            $total_credit_25_1 = $total_credit_25_1 + $row["sober_25"];
                            $print_td_1 = 1;
                        }
                        while($row = $result_sober->fetch_assoc()) {
                            $total_credit_sober_1 = $total_credit_sober_1 + $row["sober_credit"];
                        }
                        while($row = $result_report->fetch_assoc()) {
                            $total_credit_report_1 = $total_credit_report_1 + $row["sober_report"];
                        }
                        if ($print_td_1 == 1){
                            echo "<td bgcolor='#FFB6C1' width= '4%'>";
                        } else{
                            echo "<td width= '4%'>";
                        }
                        $total_credit_1 = ($total_credit_sober_1 + $total_credit_report_1 + $total_credit_25_1)*10;
                        echo nl2br(($total_credit_1)."分\n");
                        echo nl2br(($total_credit_sober_1*10)."分酒測\n");
                        echo nl2br(($total_credit_report_1*10)."分回報\n");
                        if($total_credit_1>=1000){
                            echo nl2br("不需觀護");
                        }else{
                            echo nl2br("需觀護");
                        }
                        $sql_credit = "SELECT `TotalCredit` FROM `UserGetCredit` WHERE UserID = '".$UserID."' ORDER BY id DESC LIMIT 1";
                        $sql_credit_used = "SELECT `CreditUsed` FROM `CreditExchangeHistory` WHERE UserID = '".$UserID."'";
                        $result_credit = $mysqli->query($sql_credit);
                        $result_credit_used = $mysqli->query($sql_credit_used);
                        $credit = '';
                        if($result_credit->num_rows > 0){
                            while($row = $result_credit->fetch_assoc()) {
                                $credit = $row['TotalCredit'];
                            }
                        }
                        if($result_credit_used->num_rows > 0){
                            while($row = $result_credit->fetch_assoc()) {
                                $credit = $credit - $row['CreditUsed'];
                            }
                        }
                        echo "<br>".$credit."點可換".floor($credit/38)."張禮卷";
                        echo "</td>";
                        //3
                        echo "<td width= '4%'>";
                        echo nl2br("0分<br>");
                        echo nl2br("0分酒測<br>");
                        echo nl2br("0分回報<br>");
                        echo nl2br("需觀護");
                        echo "</td>";
                    }else if($current_month_interval==3){
                    	$first_month = date('Y-m-d', strtotime($CheckDate. ' - 49 days'));
                        $first_month_last_day = date('Y-m-d', strtotime($first_month. ' + 20 days'));
                        $second_month = date('Y-m-d', strtotime($first_month. ' + 21 days'));
                        $second_month_last_day = date('Y-m-d', strtotime($second_month. ' + 27 days'));
                        $third_month = date('Y-m-d', strtotime($second_month. ' + 28 days'));
                        
                        //1
                        $sql_sober = "SELECT SUM(CreditGained) as `sober_credit`
                                  FROM `UserGetCredit` 
                                  WHERE UserID = '".$UserID."' AND (Method = 1 OR Method = 2 or Method = 3 OR Method = 4) AND ObtainDate BETWEEN '".$first_month."' AND '".$first_month_last_day."' GROUP BY ObtainDate";       
                        $sql_report = "SELECT SUM(CreditGained) as `sober_report`
                                   FROM `UserGetCredit` 
                                   WHERE UserID = '".$UserID."' AND (Method = 5 OR Method = 6 or Method = 7 OR Method = 8) AND ObtainDate BETWEEN '".$first_month."' AND '".$first_month_last_day."' GROUP BY ObtainDate";
                        $sql_add_credit = "SELECT SUM(CreditGained) as `sober_25`
                                   FROM `UserGetCredit` 
                                   WHERE UserID = '".$UserID."' AND Method = 50 AND ObtainDate BETWEEN '".$d250."' AND '".$first_month_last_day."' GROUP BY ObtainDate";
                        $result_sober = $mysqli->query($sql_sober);
                        $result_report = $mysqli->query($sql_report);
                        $result_25 = $mysqli->query($sql_add_credit);
                        while($row = $result_25->fetch_assoc()) {
                            $total_credit_25 = $total_credit_25 + $row["sober_25"];
                            $print_td = 1;
                        }
                        while($row = $result_sober->fetch_assoc()) {
                            $total_credit_sober = $total_credit_sober + $row["sober_credit"];
                        }
                        while($row = $result_report->fetch_assoc()) {
                            $total_credit_report = $total_credit_report + $row["sober_report"];
                        }
                        if ($print_td == 1){
                            echo "<td bgcolor='#FFB6C1' width= '4%'>";
                        } else{
                            echo "<td width= '4%'>";
                        }
                        $total_credit = ($total_credit_sober + $total_credit_report + $total_credit_25)*10;
                        echo nl2br(($total_credit)."分\n");
                        echo nl2br(($total_credit_sober*10)."分酒測\n");
                        echo nl2br(($total_credit_report*10)."分回報\n");
                        if($total_credit>=1000){
                            echo nl2br("不需觀護");
                        }else{
                            echo nl2br("需觀護");
                        }
                        echo "</td>";
                        //2
                        $sql_sober = "SELECT SUM(CreditGained) as `sober_credit`
                                  FROM `UserGetCredit` 
                                  WHERE UserID = '".$UserID."' AND (Method = 1 OR Method = 2 or Method = 3 OR Method = 4) AND ObtainDate BETWEEN '".$second_month."' AND '".$second_month_last_day."' GROUP BY ObtainDate";       
                        $sql_report = "SELECT SUM(CreditGained) as `sober_report`
                                   FROM `UserGetCredit` 
                                   WHERE UserID = '".$UserID."' AND (Method = 5 OR Method = 6 or Method = 7 OR Method = 8) AND ObtainDate BETWEEN '".$second_month."' AND '".$second_month_last_day."' GROUP BY ObtainDate";
                        $sql_add_credit = "SELECT SUM(CreditGained) as `sober_25`
                                   FROM `UserGetCredit` 
                                   WHERE UserID = '".$UserID."' AND Method = 50 AND ObtainDate BETWEEN '".$d250."' AND '".$second_month_last_day."' GROUP BY ObtainDate";
                        $result_sober = $mysqli->query($sql_sober);
                        $result_report = $mysqli->query($sql_report);
                        $result_25 = $mysqli->query($sql_add_credit);
                        while($row = $result_25->fetch_assoc()) {
                            $total_credit_25_1 = $total_credit_25_1 + $row["sober_25"];
                            $print_td = 1;
                        }
                        while($row = $result_sober->fetch_assoc()) {
                            $total_credit_sober_1 = $total_credit_sober_1 + $row["sober_credit"];
                        }
                        while($row = $result_report->fetch_assoc()) {
                            $total_credit_report_1 = $total_credit_report_1 + $row["sober_report"];
                        }
                        if ($print_td_1 == 1){
                            echo "<td bgcolor='#FFB6C1' width= '4%'>";
                        } else{
                            echo "<td width= '4%'>";
                        }
                        $total_credit_1 = ($total_credit_sober_1 + $total_credit_report_1 + $total_credit_25_1)*10;
                        echo nl2br(($total_credit_1)."分\n");
                        echo nl2br(($total_credit_sober_1*10)."分酒測\n");
                        echo nl2br(($total_credit_report_1*10)."分回報\n");
                        if($total_credit_1>=1000){
                            echo nl2br("不需觀護");
                        }else{
                            echo nl2br("需觀護");
                        }
                        echo "</td>";
                        //3
                        $sql_sober = "SELECT SUM(CreditGained) `sober_credit`
                                  FROM `UserGetCredit` 
                                  WHERE UserID = '".$UserID."' AND (Method = 1 OR Method = 2 or Method = 3 OR Method = 4) AND ObtainDate BETWEEN '".$third_month."' AND NOW() GROUP BY ObtainDate";       
                        $sql_report = "SELECT SUM(CreditGained) `sober_report`
                                   FROM `UserGetCredit` 
                                   WHERE UserID = '".$UserID."' AND (Method = 5 OR Method = 6 or Method = 7 OR Method = 8) AND ObtainDate BETWEEN '".$third_month."' AND NOW() GROUP BY ObtainDate";
                        $sql_add_credit = "SELECT SUM(CreditGained) as `sober_25`
                                   FROM `UserGetCredit` 
                                   WHERE UserID = '".$UserID."' AND Method = 50 AND ObtainDate BETWEEN '".$third_month."' AND NOW() GROUP BY ObtainDate";
                        $result_sober = $mysqli->query($sql_sober);
                        $result_report = $mysqli->query($sql_report);
                        $result_25 = $mysqli->query($sql_add_credit);
                        while($row = $result_25->fetch_assoc()) {
                            $total_credit_25_2 = $total_credit_25_2 + $row["sober_25"];
                            $print_td_2 = 1;
                        }
                        while($row = $result_sober->fetch_assoc()) {
                            $total_credit_sober_2 = $total_credit_sober_2 + $row["sober_credit"];
                        }
                        while($row = $result_report->fetch_assoc()) {
                            $total_credit_report_2 = $total_credit_report_2 + $row["sober_report"];
                        }
                        if ($print_td_2 == 1){
                            echo "<td bgcolor='#FFB6C1' width= '4%'>";
                        } else{
                            echo "<td width= '4%'>";
                        }
                        $total_credit_2 = ($total_credit_sober_2 + $total_credit_report_2 + $total_credit_25_2)*10;
                        echo nl2br(($total_credit_2)."分\n");
                        echo nl2br(($total_credit_sober_2*10)."分酒測\n");
                        echo nl2br(($total_credit_report_2*10)."分回報\n");
                        if($total_credit_2>=1000){
                            echo nl2br("不需觀護");
                        }else{
                            echo nl2br("需觀護");
                        }
                        $sql_credit = "SELECT `TotalCredit` FROM `UserGetCredit` WHERE UserID = '".$UserID."' ORDER BY id DESC LIMIT 1";
                        $sql_credit_used = "SELECT `CreditUsed` FROM `CreditExchangeHistory` WHERE UserID = '".$UserID."'";
                        $result_credit = $mysqli->query($sql_credit);
                        $result_credit_used = $mysqli->query($sql_credit_used);
                        $credit = '';
                        if($result_credit->num_rows > 0){
                            while($row = $result_credit->fetch_assoc()) {
                                $credit = $row['TotalCredit'];
                            }
                        }
                        if($result_credit_used->num_rows > 0){
                            while($row = $result_credit->fetch_assoc()) {
                                $credit = $credit - $row['CreditUsed'];
                            }
                        }
                        echo "<br>".$credit."點可換".floor($credit/38)."張禮卷";
                        echo "</td>";
                    }
                }else{
                    echo "<td>";
                    echo "--";
                    echo "</td>";
                    echo "<td>";
                    echo "--";
                    echo "</td>";
                    echo "<td>";
                    echo "--";
                    echo "</td>";
                }
    			break;

    		case ColumnTitle::More:
    			echo "<td>";
                echo "<a href=details.html?val1=" .$UserID. "&val2=" .$current_month_interval. "&val3=" .$weeks. "&val4=" .$total_credit. ">細節</a>";
                echo "<br><br>";
		        echo "<a href=dropout.php?val1=" .$UserID. ">退出</a>";
                echo "</td>";
    			break;		

            case ColumnTitle::AppVersion:
                echo "<td>";
                $sql_appversion = "SELECT AppVersion FROM `Offender` WHERE UserID = '". $UserID . "'" ;
                foreach( $mysqli->query($sql_appversion) as $row){
                    echo $row["AppVersion"];
                }
                echo "</td>";
                break;
        }
	}
    echo   "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";
?>

</body>
</html>
