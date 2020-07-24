<?php

session_start();

?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
.center {
	text-align: center;
}
</style>
</head>
<body>

<div class="center">
	<h1>Login</h1>
</div>
<div class="center">
	<?php
		if(ISSET($_SESSION['loginError'])) {
			echo '<p style="color: red">'.$_SESSION["loginError"].'</p>';
		}
	?>
	<form method="POST" action="/353_Main_Project/php_scripts/login.php">
		<input type="email" name="email" id="email" placeholder="Email address">
		<br>
		<input type="password" name="password" id="password" placeholder="Password">
		<br><br>
		<input type="submit" value="Login">
	</form>
</div>
<br>

<div class="center">
	<p><a href="forgot_password.php">Forgot password? Click here</a></p>
	<p>Don't have an account? <a href="register.php">Click here</a> to register</p>
</div>

</body>
</html>