<?php
$servername = "zxc353.encs.concordia.ca";
$username = "zxc353_1";
$password = "53cur3d7";

try {
  $conn = new PDO("mysql:host=$servername;dbname=zxc353_1", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}



