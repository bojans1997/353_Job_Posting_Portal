<?php


session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$email = $_POST['email'];
$password = $_POST['password'];

// validate email and password combination


// first check user table
$validateCreds = $conn->prepare("SELECT * FROM user WHERE email=?");
$validateCreds->bindParam(1, $email, PDO::PARAM_STR);
$validateCreds->execute();
$result = $validateCreds->fetch();
$hashPassword = $result['password'];

// if email exists in the db, proceed with password validation
if(count($result) > 0) {
	if(password_verify($password,$hashPassword)) {
		$_SESSION["userType"] = 'employee';
		$_SESSION["email"] = $email;
		if(isset($_SESSION["error"])) {
			unset($_SESSION["loginError"]);
		}
		header("Location:/353_Main_Project/dashboard.php");
	} else {
		$error="Wrong email / password combination";
		$_SESSION["loginError"] = $error;
		header("Location:/353_Main_Project/login.php");
	}
} else {
	// TODO if the email is not found in user table, check employer table

	// TODO if the email is not found in the employer table, check admin table


	// if email is not found anywhere, return to login page with error message
	$error = "Wrong email / password combination";
	$_SESSION['loginError'] = $error;
	header("Location:/353_Main_Project/login.php");
}