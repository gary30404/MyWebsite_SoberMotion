<?php
function check_session(){
	session_start();

	if (!isset($_SESSION['logged_in']) && $_SESSION['logged_in'] != true){
		header('Location:index.php');
		die("session error 1");
	}
}
function check_session_with_target($target){
	session_start();
	$CUR_USER = $_SESSION['userID'];
	if (!$CUR_USER){
		header('Location:login.php?target='.$target);
		die("session error 2");
	}
}
?>
