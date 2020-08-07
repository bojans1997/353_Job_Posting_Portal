<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$deletePaymentMethod = $conn->prepare("UPDATE payment_method SET active = 0 where id = ?");
$deletePaymentMethod->execute([$_GET["paymentID"]]);

header("Location:/353_Main_Project/manage_payments.php");