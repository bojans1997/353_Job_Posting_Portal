<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$email = $_SESSION["email"];

$deleteUser = $conn->prepare("DELETE FROM user WHERE email = ?");
$deleteUser->execute([$email]);

session_unset();

header("Location:/353_Main_Project/register.php");