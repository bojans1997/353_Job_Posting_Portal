<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


// store POST data
$email = $_POST["email"];
$password = $_POST["password"];

$password = password_hash($password,PASSWORD_BCRYPT);
$updateUser = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$updateUser->execute([$password, $email]);

header("Location:/353_Main_Project/login.php");