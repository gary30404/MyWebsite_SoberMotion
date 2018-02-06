<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "barrylam7f";
$dbname = "SoberMotion";

session_start();

$error=''; // Variable To Store Error Message


if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Username or Password is invalid";
    } else{
        // Define $username and $password
        $username=$_POST['username'];
        $password=$_POST['password'];
        $pwd = md5($password);

        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM WebUser WHERE UserID='$username' AND Password='$pwd' LIMIT 1";
        $result = $conn->query($sql) or die("Could not select examples");;

        if ($result->num_rows == 1) {
            $_SESSION['login_user']=$username; // Initializing Session
            header("location: index.php"); // Redirecting To Other Page
        } else {
            $error = "Username or Password is invalid";
        }
        $conn->close();
    }
    
}

?>
