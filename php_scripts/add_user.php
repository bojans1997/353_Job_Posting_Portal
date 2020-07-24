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
$checkEmailTaken->bindParam(1, $email, PDO::PARAM_STR);
$checkEmailTaken->execute();

$result = $checkEmailTaken->fetchAll();

if(count($result) > 0)
{
	$_SESSION["errorEmail"] = true;
	header("Location:/353_Main_Project/register.php");
} else {
	$password = password_hash($password,PASSWORD_BCRYPT);
	$insertUser = $conn->prepare("INSERT INTO user (fname, lname, address, postalcode, province, email, password) VALUES(?, ?, ?, ?, ?, ?, ?)");
	$insertUser->bindParam(1, $fname, PDO::PARAM_STR);
	$insertUser->bindParam(2, $lname, PDO::PARAM_STR);
	$insertUser->bindParam(3, $address, PDO::PARAM_STR);
	$insertUser->bindParam(4, $postalcode, PDO::PARAM_STR);
	$insertUser->bindParam(5, $province, PDO::PARAM_STR);
	$insertUser->bindParam(6, $email, PDO::PARAM_STR);
	$insertUser->bindParam(7, $password, PDO::PARAM_STR);
	$insertUser->execute();

	$_SESSION['email'] = $email;
	$_SESSION['userType'] = "employee";

	if(isset($_SESSION["errorEmail"])) {
		unset($_SESSION["errorEmail"]);
	}

	header("Location:/353_Main_Project/dashboard.php");
}