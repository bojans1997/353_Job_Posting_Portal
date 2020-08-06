<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


// store POST data
$cardType = $_POST["cardType"];
$cardholder=$_POST["cardholder"];
$number=$_POST["number"];
$cvc = NULL;
if(isset($_POST["cvc"])) {$cvc = $_POST["cvc"];}
$expire=$_POST["expire"];
$existingID = "";
if(isset($_POST["existingID"])) {$existingID = $_POST["existingID"];}

// if job id is defined, then do an update instead of an insert
if(!empty($existingID)) {
	$updatePayment = $conn->prepare("UPDATE payment_method set card_type=?, cardholder_name=?, card_number=?, cvc=?, expiration_date=? where id=?");
	$updatePayment->execute([$cardType, $cardholder, $number, $cvc, $expire, $existingID]);

	header("Location:/353_Main_Project/manage_payments.php");
} else {
	$insertPayment = $conn->prepare("INSERT INTO payment_method (card_type, user_id, cardholder_name, card_number, cvc, expiration_date) VALUES(?, ?, ?, ?, ?, ?)");
	$insertPayment->execute([$cardType, $_SESSION["user_id"], $cardholder, $number, $cvc, $expire]);

	header("Location:/353_Main_Project/manage_payments.php");
}