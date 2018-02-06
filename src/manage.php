<!DOCTYPE html>
<html>
   <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="record.css">
      <meta charset="UTF-8"/>
      <title>管理 - SoberMotion</title>
      <script src="record.js"></script>
   </head>
   <body>
      <nav class="navbar navbar-inverse navbar-fixed-top">
         <div class="container">
            <div class="navbar-header">
               <a class="navbar-brand" href="#">SoberMotion</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
               <ul class="nav navbar-nav navbar-right">
                  <li><a href="record.php">紀錄</a></li>
                  <li class="active"><a href="manage.php">管理</a></li>
               </ul>
            </div>
         </div>
      </nav>
      <div class="jumbotron">
        <div class="container">
        </div>
      </div>
      <div class="container">
<?php
    include_once('db_config.php');
    abstract class ColumnTitle //enum column
    {
        const	JoinDate = 1;
        const   ReturnDate = 2;
        const   RevisitDate =3;
	const 	SelfDrive =4;
	const 	UnknownDrive =5;
        const   IsSelfPredictCorrectLastMonth =6;
	const   IsSelfPredictCorrectThisMonth =7;
	const 	BracTestRatio = 8;
	const 	FailFaceDetection = 9;
	const 	AchieveGained = 10;
	const 	More =11;
    }
    $isRegular_array = array(
        "0" => "NO",
        "1" => "YES",
    );
    $date_row = array();
    $names = array();
  
    $sql = "SELECT distinct AlcoholInfluenceAssessment.UserID FROM AlcoholInfluenceAssessment, Offender where AlcoholInfluenceAssessment.UserID = Offender.UserID and `IsRegular` = '1' and `Dropout` = '0' ";
    foreach( $conn->query($sql) as $row){
	$UserIDs[] = $row["UserID"];
    }
    $start_day = new DateTime((string)$today);
    echo "<table class='main-table'>"; //main table
	echo "<thead>";
    echo "<tr>"; // date-row
    $cur_day = $start_day ;
        //column name
	echo "<th>個案</th>";
	echo "<th>研究開始日期</th>";
	echo "<th>下次觀護日期</th>";
	echo "<th>下次回診日期</th>";
	echo "<th colspan='2'><table><tr><th>潛在酒駕次數</th></tr><tr><th>自駕</th><th>沒確認</th></tr></table></th>";
	echo "<th colspan='2'><table><tr><th>低估比率</th></tr><tr><th>上個月</th><th>本月</th></tr></table></th>";	
	echo "<th>酒測完成度</th>";
	echo "<th>臉部識別失敗次數</th>";
	echo "<th>現在達到進度</th>";
	echo "<th>細節</th>";
	echo "</tr>"; //end of date-row
	echo "</thead></tbody>";
    foreach($UserIDs as $UserID){	 //retrieve data
echo "<tr class='height-control'>"; //data-row
	echo "<td class='user'><a href='KoolPHPSuite/Examples/KoolGrid/Appearance/Styles/index.php?UID=$UID'>"; //link to offender
	echo htmlentities($UserID);
	echo "</a></td>";

     $today = date("Y-m-d H:i:s") ;
    $start_day = new DateTime((string)$today);
    echo "today=" . $today;
    //total column
    for ($i = 1 ; $i < 12 ; $i++ ){
        echo "<td><table class='datatable'>";  //timeslot table
        echo "<tr class='timeslot height-control'><td>";
	//select column sql
	switch ($i){	
		case ColumnTitle::JoinDate :
			$sql = "SELECT JoinDate FROM `Offender` WHERE UserID = '". $UserID . "'" ;
			break;	
		case ColumnTitle::ReturnDate :
			$sql = "SELECT ReturnDate FROM `ReturnCalendar` WHERE UserID = '". $UserID . "'" ;
			break;
		case ColumnTitle::RevisitDate :
			$sql = "SELECT RevisitDate FROM `RevisitCalendar` WHERE UserID = '". $UserID . "'" ;
			break;	
		case ColumnTitle::SelfDrive :
			$sql = "SELECT count(*) FROM `AlcoholInfluenceAssessment` , `VehicleUseTag` WHERE AlcoholInfluenceAssessment.UserID = '". $UserID . "' and VehicleUseTag.AlcoholScreeningID = AlcoholInfluenceAssessment.TimestampMillis and VehicleUseTag.IsSelfDrive = 1" ;
					
			break;
		case ColumnTitle::UnknownDrive :
			$sql = "SELECT count(*) FROM `AlcoholInfluenceAssessment` , `VehicleUseTag` WHERE AlcoholInfluenceAssessment.UserID = '". $UserID . "' and VehicleUseTag.AlcoholScreeningID = AlcoholInfluenceAssessment.TimestampMillis and  VehicleUseTag.IsSelfDrive = -1" ;
					
			break;
		case ColumnTitle::IsSelfPredictCorrectLastMonth :
			$sql = "SELECT sum(IsSelfPredictCorrect=0)/sum(IsSelfPredictCorrect) FROM `AlcoholInfluenceAssessment` WHERE UserID = '". $UserID . "' and Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 56 DAY) AND DATE_SUB(NOW(), INTERVAL 28 DAY)" ;
				
			break;
		case ColumnTitle::IsSelfPredictCorrectThisMonth :
			$sql = "SELECT sum(IsSelfPredictCorrect=0)/sum(IsSelfPredictCorrect) FROM `AlcoholInfluenceAssessment` WHERE UserID = '". $UserID . "' and Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 28 DAY) AND NOW()" ;
			
		break;
		case ColumnTitle::BracTestRatio :
			$sql = "SELECT count(Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 28 DAY) AND NOW())/ (4*count(Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 28 DAY) AND NOW())) FROM `AlcoholInfluenceAssessment` WHERE UserID = '". $UserID . "' and Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 28 DAY) AND NOW()" ;	//echo $sql;
			break;
		case ColumnTitle::FailFaceDetection :
			break;
		case ColumnTitle::AchieveGained :
			$sql = "  SELECT (SELECT CheckScore From `CheckIfReturnCalendar` where CheckDate BETWEEN DATE_SUB( NOW(), INTERVAL 28 DAY) AND NOW() Order By CheckDate DESC LIMIT 1 ) * (SELECT CASE when CheckDate BETWEEN DATE_SUB( NOW(), INTERVAL 7 DAY) AND NOW() then 10 else 8 end  FROM `CheckIfReturnCalendar` )" ;
			break;		
		case ColumnTitle::More :
			echo "<p><a href=''>細節</a></p>";
			echo "<p><a href=''>退出</a></p>";
			break;					
	}
	if($i !=  ColumnTitle::FailFaceDetection && $i !=  ColumnTitle::More )
		printData($conn,$sql);

	echo "</td></tr>";
	
        echo "</table></td>";
}
        $cur_day -> modify('+1 day');
    }
    echo "</tr></table>";
?>

<?php
//print data
function printData($conn,$sql){
	foreach ( $conn->query($sql) as $row) {
		echo  $row[0] ;			
	}
}

?>
</tbody>
</table>
      </div>
   </body>
</html>
