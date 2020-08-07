<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"] . "/353_Main_Project/php_scripts/connect.php");


// set every user active value to 0 

$updateUser = $conn->prepare("UPDATE users SET activated = 0");
$updateUser->execute();

if (!empty($_POST['userSelection'])) {
    foreach ($_POST['userSelection'] as $userid) {

        //activate only users left selected
        $updateUser = $conn->prepare("UPDATE users SET activated = '1' WHERE id = $userid");
        $updateUser->execute();
    }
}

header("Location:/353_Main_Project/manage_users.php");
