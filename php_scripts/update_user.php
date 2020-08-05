<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


// store POST data
$address = $_POST["address"];
$postal = $_POST["postal"];
$province = $_POST["province"];
$description = $_POST["description"];
$experience = $_POST["experience"];

$password = password_hash($password,PASSWORD_BCRYPT);
$updateUser = $conn->prepare("UPDATE user_profile SET description = ?, experience = ?, address = ?, postal_code = ?, province = ? WHERE user_id = ?");
$updateUser->execute([$description, $experience, $address, $postal, $province, $_SESSION["user_id"]]);

header("Location:/353_Main_Project/update_profile.php");