<!DOCTYPE html>
<html>
   <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="record.css">
      <meta charset="UTF-8"/>
      <title>紀錄 - SoberMotion</title>
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
                  <li class="active"><a href="record.php">紀錄</a></li>
                  <li><a href="#">管理</a></li>
               </ul>
            </div>
         </div>
      </nav>
      <div class="jumbotron">
        <div class="container">
        <div class="month-div">
          <p class="month">月份</p>
        </div>
        </div>
      </div>
      <div class="container">
<?php
    include_once('db_config.php');
    abstract class DaysOfWeek
    {
        const Morning = 1;
        const Afternoon = 2;
        const Night = 3;
        const Midnight = 4;
    }
    $isRegular_array = array(
        "0" => "NO",
        "1" => "YES",
    );
    $date_row = array();
    $names = array();
  /*
    $sql = "SELECT * FROM  AlcoholInfluenceAssessment where `IsRegular` = '1' ";
    foreach( $conn->query($sql) as $row){
      $names[] = $row["UserId"];
    }
    */
    // $today = date("Y-m-d H:i:s") ;
	$UID = $_GET['UID'];
	$today = $_GET['date'];
    $start_day = new DateTime((string)$today);
    $start_day -> modify('-6 day');
    echo "<table class='main-table'>"; //main table
	echo "<thead>";
    echo "<tr>"; // date-row
    $cur_day = $start_day ;
	echo "<td colspan='2' class='timecontrol right'>
		<a onclick='changeDate(-7)'><</a>
		</td>"; //dummy td
    for ($i = 1 ; $i < 8 ; $i++ ){
        echo"<td class='date'>" . substr((string)$cur_day->format('Y-m-d  H:i:s'), 0,10) . "</td>";
        $cur_day -> modify('+1 day');
    }
	echo "<td class='timecontrol left'>
		<a href='javascript:changeDate(7)'>></a>
		</td>"; //dummy td
	echo "</tr>"; //end of date-row
	echo "</thead></tbody>";
    echo "<tr class='height-control'>"; //data-row
	echo "<td class='user'><a href='KoolPHPSuite/Examples/KoolGrid/Appearance/Styles/index.php?UID=$UID'>";
		
	echo htmlentities($UID);
	echo "</a></td>";
    echo "<td class='timeregion'><table class='timeregiontable'>";  //timeslot table
	for($i = 1 ; $i < 5 ; $i++){
		echo "<tr class='timeslot height-control'><td>";
            if( $i == DaysOfWeek::Morning) echo "早上";
            if( $i == DaysOfWeek::Afternoon) echo "下午";
            if( $i == DaysOfWeek::Night) echo "晚上";
			if( $i == DaysOfWeek::Midnight) echo "半夜";
		echo "</td></tr>";
    }
    echo "</table></td>" ;
    // $today = date("Y-m-d H:i:s") ;
    $start_day = new DateTime((string)$today);
    $start_day -> modify('-6 day');
    $cur_day = $start_day ;
    for ($i = 1 ; $i < 8 ; $i++ ){
        echo "<td><table class='datatable'>";  //timeslot table
        for($j = 1 ; $j < 5 ; $j++){
            $stamp_date = substr((string)$cur_day->format('Y-m-d  H:i:s'), 0,10) ;
			//var_dump($stamp_date);
            $sql = "SELECT * FROM AlcoholInfluenceAssessment where `IsRegular` = '1' and `UserID` = '$UID' and Timestamp like '$stamp_date%' and TimeSlot = '$j'  ";
            //echo "<td>". $sql . "</td>";
            echo "<tr class='timeslot height-control'><td>";
            printDataTable($conn,$sql);
            echo "</td></tr>";
        }
        echo "</table></td>";
        $cur_day -> modify('+1 day');
    }
    echo "</tr></table>";
?>

<?php
function printDataTable($conn,$sql){
    $self_predict_array = array(
    "0" => "適合",
    "1" => "不適合",
    );
    foreach ( $conn->query($sql) as $row) {
        echo "<table class='hasdata'>";
        $time = substr($row["Timestamp"] , 10) ;
        $self_predict = $self_predict_array[ $row["SelfPredict"] ];
        echo "<tr><td>時間</td><td>" . $time. "</td></tr>";
        echo "<tr><td>值</td><td>"  . (string)$row["Brac"] . "</td></tr>";
        echo "<tr><td>級距</td><td>"  . (string)$row["BracLevel"] . "</td></tr>";
        echo "<tr><td>自我評估</td><td>"  . $self_predict . "</td></tr>";
        echo "<tr><td>理由</td><td>" . $row["Reason"]  . "</td></tr>";
        echo "</table>";
    }
}
?>
</tbody>
</table>
      </div>
   </body>
</html>
