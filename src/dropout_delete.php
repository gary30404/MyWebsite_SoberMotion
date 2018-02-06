<?php
/* Main page with two forms: sign up and log in */
require 'db.php' ;
include('session.php');
$alcoholtest = array();
$UserID = $_POST['id'];
$now = new DateTime();
$time = $now->format('Y-m-d H:i:s'); 
$sql3 = "UPDATE `Offender` SET Dropout='1', DropoutDate='$time' WHERE UserID='$UserID'";   
$r = $conn->query($sql3) or die("Could not update examples");;
echo json_encode($alcoholtest);
?>

