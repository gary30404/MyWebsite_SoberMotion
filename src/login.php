<?php
include('login_verifier.php'); // Includes Login Script
if(isset($_SESSION['login_user'])){
header("location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>登入</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">

</head>
<body>
	<div class="container">
		<form id="login_form" name="login" action="" method="post" class="form-signin">
			<div id=form-header>
				<img src="img/icon.png" class="icon" height="17%" width="17%"/>
				<h2>行車安全確認</h2>
			</div>
			<input type="text" class="input-block-level" placeholder="Account" name="account" size="12" maxlength="12"><br>
			<input type="password" class="input-block-level" placeholder="Password" name="pwd" size="12" maxlength="12"><br>
			<input type="hidden" name="target" value="<?echo $TARGET;?>">
            <?php echo $error; ?>
			<input type="submit" name="login" value="登入" class="btn btn-primary chinese-font">
		</form>
	</div>
</body>
</html>
