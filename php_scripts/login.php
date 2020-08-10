<?php


session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$email = $_POST['email'];
$password = $_POST['password'];

// validate email and password combination
$validateCreds = $conn->prepare("SELECT * FROM users WHERE email=?");
$validateCreds->execute([$email]);
$result = $validateCreds->fetch();
$hashPassword = $result['password'];

// if email exists in the db, proceed with password validation
if(!empty($result)) {
	if(password_verify($password,$hashPassword)) {

		if($result['activated'] == 0) {
			$_SESSION['loginError'] = "This account has been deactivated";
			header("Location:/353_Main_Project/login.php");
		} else {
			$_SESSION["userType"] = $result['user_type'];
			$_SESSION["email"] = $email;
			$_SESSION['user_id'] = $result['id'];
			if(isset($_SESSION["loginError"])) {
				unset($_SESSION["loginError"]);
			}
			header("Location:/353_Main_Project/dashboard.php");
		}
	} else {
		$error="Wrong email / password combination";
		$_SESSION["loginError"] = $error;
		header("Location:/353_Main_Project/login.php");
	}
} else {
	// if email is not found, return to login page with error message
	$error = "Wrong email / password combination";
	$_SESSION['loginError'] = $error;
	header("Location:/353_Main_Project/login.php");
}
