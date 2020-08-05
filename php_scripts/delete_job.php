<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$deleteJob = $conn->prepare("DELETE FROM job where id = ?");
$deleteJob->execute([$_GET["jobID"]]);

header("Location:/353_Main_Project/update_jobs.php");