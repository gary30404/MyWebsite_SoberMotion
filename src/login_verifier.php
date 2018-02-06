<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "barrylam7f";
$dbname = "SoberMotion";

session_start();
if($_POST['login']=="登入"){
    $account = substr($_POST['account'],0,12);
    $password = substr($_POST['pwd'],0,12);
    //$target = $_POST['target'];
    $error = '';

    $pwd_md5 = md5($password);

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM WebUser WHERE UserID='$account' AND Password='$pwd_md5' LIMIT 1";

    $result = $conn->query($sql) or die("Could not select examples");;

    if ($result->num_rows == 1) {
        $_SESSION['login_user']=$account; // Initializing Session
        header("location: index.php"); // Redirecting To Other Page
    } else {
        $error = '<div class="alert alert-error">Login Failed!</div>';
    }

    $conn->close();
}

?>
