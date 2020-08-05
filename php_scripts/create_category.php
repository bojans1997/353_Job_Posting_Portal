<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


// store POST data
$name = $_POST["name"];
$catID = $_POST["catID"];

if(!empty($catID)) {
	$updateCategory = $conn->prepare("UPDATE category set name=? where id=?");
	$updateCategory->execute([$name, $catID]);

	header("Location:/353_Main_Project/update_categories.php");
} else {

	$insertCategory = $conn->prepare("INSERT INTO category (created_by, name) VALUES(?, ?)");
	$insertCategory->execute([$_SESSION["user_id"], $name]);
	header("Location:/353_Main_Project/dashboard.php");
}