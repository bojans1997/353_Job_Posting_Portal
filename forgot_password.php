<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>

<style>
.center {
	margin: 0 auto;
	margin-left: 42%;
}

.inline-block {
	display: inline-block;
}

#left-form {
	float: left;
}

#right-form {
	float: left;
	clear: right;
}

#deleteButton {
	clear: both;
	margin: 0 auto;
	padding-top: 2%;
}

.dashboard-link {
	margin-left: 20%;
}

table, th, td {
	border: 1px solid black;;
  	border-collapse: collapse;
}
</style>
</style>
</head>
<body>
<div class="dashboard-link">
	<a href="login.php">Return to Login</a>
</div>
<div class="center">
	<h1>Forgot Password</h1>
</div>
<div class="center">
	<p>Enter your email address and your new password.</p>
	<form method="POST" action="/353_Main_Project/php_scripts/update_password.php">
		<input type="email" name="email" id="email" placeholder="Email address">
		<br>
		<input type="password" name="password" id="password" placeholder="New Password">
		<br><br>
		<input type="submit" value="Reset Password">
	</form>
</div>

</body>
</html>