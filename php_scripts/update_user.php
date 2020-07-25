<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


// store POST data
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$address = $_POST["address"];
$postal = $_POST["postal"];
$province = $_POST["province"];
$password = $_POST["password"];
$category = $_POST["category"];
$email = $_SESSION["email"];

$password = password_hash($password,PASSWORD_BCRYPT);
$updateUser = $conn->prepare("UPDATE user SET fname = ?, lname = ?, address = ?, postalcode = ?, province = ?, password = ?, category=  ? WHERE email = ?");
$updateUser->execute([$fname, $lname, $address, $postal, $province, $password, $category, $email]);

header("Location:/353_Main_Project/update_profile.php");