<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");


// store GET data
$userID = $_GET['userID'];
$jobID = $_GET['jobID'];
$manage = $_GET['manage'];
    
echo $userID;
echo $jobID;

$applyJob = $conn->prepare("delete from job_application
where user_id = ? and job_id = ? ;");
$applyJob->execute([$userID, $jobID]);

if ($manage){
    header("Location:/353_Main_Project/manage_applications.php");
}
else{
    header("Location:/353_Main_Project/job_search.php");
}