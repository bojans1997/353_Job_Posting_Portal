<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


$deletePaymentMethod = $conn->prepare("DELETE FROM subscription where payment_id = ?");
$deletePaymentMethod->execute([$_GET["paymentID"]]);

$deletePaymentMethod = $conn->prepare("DELETE FROM payment_method where id = ?");
$deletePaymentMethod->execute([$_GET["paymentID"]]);

header("Location:/353_Main_Project/manage_payments.php");