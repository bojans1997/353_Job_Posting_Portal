<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$deleteApplications = $conn->prepare("DELETE FROM job_application where job_id = ?");
$deleteApplications->execute([$_GET["jobID"]]);

$deleteJob = $conn->prepare("DELETE FROM job where id = ?");
$deleteJob->execute([$_GET["jobID"]]);

header("Location:/353_Main_Project/update_jobs.php");