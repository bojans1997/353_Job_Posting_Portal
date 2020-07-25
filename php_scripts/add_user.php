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
$checkEmailTaken = $conn->prepare("SELECT * FROM user WHERE email=?");
$checkEmailTaken->execute([$email]);

$result = $checkEmailTaken->fetchAll();

if(count($result) > 0)
{
	$_SESSION["errorEmail"] = true;
	header("Location:/353_Main_Project/register.php");
} else {
	$password = password_hash($password,PASSWORD_BCRYPT);
	$insertUser = $conn->prepare("INSERT INTO user (fname, lname, address, postalcode, province, email, password, category, role) VALUES(?, ?, ?, ?, ?, ?, ?, 'basic', 'employee')");
	$insertUser->execute([$fname, $lname, $address, $postal, $province, $email, $password]);

	$_SESSION['email'] = $email;
	$_SESSION['userType'] = "employee";

	if(isset($_SESSION["errorEmail"])) {
		unset($_SESSION["errorEmail"]);
	}

	header("Location:/353_Main_Project/dashboard.php");
}