<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


// store POST data
$userID = $_GET['userID'];
$jobID = $_GET['jobID'];

$applyJob = $conn->prepare("INSERT INTO job_application	(application_date,user_id,job_id)
VALUES (?,?,?);");
$applyJob->execute([date("Y-m-d"), $userID, $jobID]);

header("Location:/353_Main_Project/job_search.php");
