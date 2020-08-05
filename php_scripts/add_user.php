<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


// store POST data
$fname=$_POST["fname"];
$lname=$_POST["lname"];
$address=$_POST["address"];
$postal=$_POST["postal"];
$province=$_POST["province"];
$email=$_POST["email"];
$password=$_POST["password"];


// check whether email is already taken
// if not taken, add it to user table
$checkEmailTaken = $conn->prepare("SELECT * FROM users WHERE email=?");
$checkEmailTaken->execute([$email]);

$result = $checkEmailTaken->fetchAll();

if(count($result) > 0)
{
	$_SESSION["errorEmail"] = true;
	header("Location:/353_Main_Project/register.php");
} else {
	$password = password_hash($password,PASSWORD_BCRYPT);
	$insertUser = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, user_type) VALUES(?, ?, ?, ?, 1)");
	$insertUser->execute([$fname, $lname, $email, $password]);

	$userInfo = $conn->prepare("SELECT * FROM users WHERE email=?");
	$userInfo->execute([$email]);
	$result = $userInfo->fetch();

	$_SESSION['user_id'] = $result['id'];
	$_SESSION['email'] = $email;
	$_SESSION['userType'] = "employee";

	$insertProfile = $conn->prepare("INSERT INTO user_profile (user_id, address, postal_code, province) VALUES(?, ?, ?, ?)");
	$insertProfile->execute([$_SESSION['user_id'], $address, $postal, $province]);

	if(isset($_SESSION["errorEmail"])) {
		unset($_SESSION["errorEmail"]);
	}

	header("Location:/353_Main_Project/dashboard.php");
}