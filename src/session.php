<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "barrylam7f";
$dbname = "SoberMotion";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

$user_check=$_SESSION['login_user'];
if ($user_check == ''){
	header('Location: login.php');
}

$sql = "SELECT UserID FROM WebUser WHERE UserID='$user_check' LIMIT 1";
$result = $conn->query($sql) or die("Could not select examples");;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $login_session = $row['UserID'];
        if(!isset($login_session)){
            $conn->close();
            header('Location: login.php'); // Redirecting To Home Page
        }
    }
} 

?>
