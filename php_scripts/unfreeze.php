<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


// store POST data
$subscription = $_POST["currentSubscription"];
$paymentID = $_POST["paymentOption"];

// get new subscription price
$getPrice= $conn->prepare("SELECT price FROM subscription_model WHERE id = ?");
$getPrice->execute([$subscription]);
$price = $getPrice->fetch();

// update subscription
$updateSubscription = $conn->prepare("UPDATE subscription SET end_date = ? where user_id = ? AND subscription_model_id = ? AND active = 1");
$updateSubscription->execute([date("Y-m-d",strtotime("+1 month")), $_SESSION["user_id"], $subscription]);

// insert new transaction
$insertTransaction= $conn->prepare("INSERT INTO transaction (subscription_id, user_id, amount, paid, date) VALUES (?, ?, ?, ?, ?)");
$insertTransaction->execute([$subscription, $_SESSION["user_id"], $price['price'], 1, date("Y-m-d")]);

// unfreeze user
$updateUser = $conn->prepare("UPDATE users SET frozen = 0 where id = ?");
$updateUser->execute([$_SESSION["user_id"]]);

header("Location:/353_Main_Project/dashboard.php");