<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$email = $_SESSION["email"];

$deleteUser = $conn->prepare("UPDATE users SET activated = 0 WHERE id = ?");
$deleteUser->execute([$_SESSION["user_id"]]);

session_unset();

header("Location:/353_Main_Project/register.php");