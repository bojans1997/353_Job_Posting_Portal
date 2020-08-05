<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


// store POST data
$title=$_POST["title"];
$salary=$_POST["salary"];
$category=$_POST["category"];
$description=$_POST["description"];
$positions=$_POST["positions"];
$company_name = "";
$jobID = $_POST["jobID"];

// if job id is defined, then do an update instead of an insert
if(!empty($jobID)) {
	$updateJob = $conn->prepare("UPDATE job set title=?, salary=?, description=?, positions_available=?, category_id=? where id=?");
	$updateJob->execute([$title, $salary, $description, $positions, $category, $jobID]);

	header("Location:/353_Main_Project/update_jobs.php");
} else {
	$getCompanyName = $conn->prepare("SELECT company_name FROM user_profile WHERE user_id=?");
	$getCompanyName->execute([$_SESSION["user_id"]]);

	$result = $getCompanyName->fetch();
	$company_name = $result["company_name"];


	$insertJob = $conn->prepare("INSERT INTO job (company, title, salary, description, positions_available, category_id, created_by) VALUES(?, ?, ?, ?, ?, ?, ?)");
	$insertJob->execute([$company_name, $title, $salary, $description, $positions, $category, $_SESSION["user_id"]]);

	header("Location:/353_Main_Project/dashboard.php");
}