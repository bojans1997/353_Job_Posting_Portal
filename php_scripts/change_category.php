<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


if(isset($_GET["basic"])) {
	// update old subscription termination date
	$updateSubscription = $conn->prepare("UPDATE subscription SET termination_date = ?, active = 0 WHERE user_id = ? AND subscription_model_id = ? AND active = 1");
	$updateSubscription->execute([date('Y-m-d'), $_SESSION["user_id"], $_GET["old"]]);

	// insert new subscription
	$insertSubscription = $conn->prepare("INSERT INTO subscription (subscription_model_id, user_id, start_date, active) VALUES (?, ?, ?, ?)");
	$insertSubscription->execute([1, $_SESSION["user_id"], date("Y-m-d"), 1]);

	// insert new transaction
	$insertTransaction= $conn->prepare("INSERT INTO transaction (subscription_id, user_id, amount, paid, date) VALUES (?, ?, ?, ?, ?)");
	$insertTransaction->execute([1, $_SESSION["user_id"], 0.00, 1, date("Y-m-d")]);

	 mail($_SESSION["email"], "Subscription change", "Your subscription has been changed to BASIC and you have been charged $0.00");
} else {
	// store POST data
	$newCategory = $_POST["newSubscription"];
	$oldCategory = $_POST["currentSubscription"];
	$paymentID = $_POST["paymentOption"];

	// get new subscription price
	$getPrice= $conn->prepare("SELECT price FROM subscription_model WHERE id = ?");
	$getPrice->execute([$newCategory]);
	$price = $getPrice->fetch();

	// update old subscription termination date
	$updateSubscription = $conn->prepare("UPDATE subscription SET termination_date = ?, active = 0 WHERE user_id = ? AND subscription_model_id = ? AND active = 1");
	$updateSubscription->execute([date('Y-m-d'), $_SESSION["user_id"], $oldCategory]);

	// insert new subscription
	$insertSubscription = $conn->prepare("INSERT INTO subscription (subscription_model_id, user_id, start_date, end_date, payment_id, active) VALUES (?, ?, ?, ?, ?, ?)");
	$insertSubscription->execute([$newCategory, $_SESSION["user_id"], date("Y-m-d"), date("Y-m-d",strtotime("+1 month")), $paymentID, 1]);

	// insert new transaction
	$insertTransaction= $conn->prepare("INSERT INTO transaction (subscription_id, user_id, amount, paid, date) VALUES (?, ?, ?, ?, ?)");
	$insertTransaction->execute([$newCategory, $_SESSION["user_id"], $price['price'], 1, date("Y-m-d")]);

	$getInfo = $conn->prepare("SELECT * FROM subscription_model WHERE id = ?");
	$getInfo->execute([$newCategory]);
	$info = $getInfo->fetch();

	mail($_SESSION["email"], "Subscription change", "Your subscription has been changed to ".$info["name"]." and you have been charged $".$price["price"]);

}

header("Location:/353_Main_Project/change_subscription.php");
