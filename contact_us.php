<?php

session_start();

require("php_scripts/connect.php");

?>

<!DOCTYPE html>
<html>
<head>
<title>Contact Us</title>

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
</style>
</head>
<body>

<div class="dashboard-link">
	<a href="dashboard.php">Return to Dashboard</a>
</div>

<div class="center">
	<h1>Contact Us</h1>
</div>

<div class="center">
	<p>Phone: 1-800-353-9001</p>
	<p>Email: <a href="mailto:help@353mainproject.com">help@353mainproject.com</a></p>
</div>
<br>

</body>
</html>