<?php
/* Main page with two forms: sign up and log in */
require 'db.php' ;
include('session.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>臉部辨識結果</title>
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
        <a href="index.php" class="w3-bar-item w3-button"><b>NTUIOX</b>  UbiCompLab</a>
    <!-- Float links to the right. Hide them on small screens -->
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
            <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
	   </div>
    </div>
</div>
<div>
<div>
    <div id="projects" style="background-color: #112F5F; height: 105px; width: 97.5%; margin-left:1.3%;">
        <h2><FONT COLOR=white>SoberMotion</FONT></h2>
        <h3><FONT COLOR=white>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SoberMotion</FONT></h3>
<!-- Data  Section -->
<?php

$val = $_GET["val"];

abstract class ColumnTitle //enum column
{   
    const   DateTime = 1;
    const   Pics = 2;
}
/*
$sql = "SELECT distinct Offender.UserID 
        FROM AlcoholInfluenceAssessment, Offender 
        WHERE AlcoholInfluenceAssessment.UserID = Offender.UserID and IsRegular = '1' and Dropout = '0'";
*/
$sql = "SELECT TimestampMillis FROM AlcoholInfluenceAssessment WHERE UserID='$val' ORDER BY id";

foreach( $mysqli->query($sql) as $row){
    $Alcohols[] = $row["TimestampMillis"];
}

echo "<table class = 'GeneratedTable' >";
//first row
echo "<thead>";
echo "  <tr> 
        <th rowspan='4' width='20%'>酒測時間</th>
	    <th colspan='6'>臉部照片</th>
        </tr>";
echo "  <tr>
	    <th>1</th>
        <th>2</th>
        <th>3</th>
        <th>4</th>       
        <th>5</th>
        <th>6</th>
        </tr>";
echo "</thead>";

//data row
echo "<tbody>";
foreach($Alcohols as $Alcohol){
    echo "<tr>";
    $SetTime = 1;
    $sql = "SELECT * FROM FaceDetection WHERE KeyInAlcoholInfluenceAssessment='$Alcohol' and UserID='$val' ORDER BY id";
    foreach ( $mysqli->query($sql) as $row){
        if ($row["FinalTarget"] == "unknown"){
            if ($SetTime == 1){
                echo "<td>";
                echo $row["Timestamp"];
                echo "</td>";
                $SetTime = 0;
            }
            echo "<td>";
            $imgpath = "upload/offender/" . $val . "/" . $Alcohol . "/" . $row["PhotoName"] . ".jpg"; 
            echo '<img src="' . $imgpath .'" align="middle" width="50%">';
            echo "</td>";
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
