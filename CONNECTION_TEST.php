<?php

require "php_srcipts/connect.php";

$query = $conn->prepare('SELECT * FROM customer;');
$query->execute();

while($rows = $query->fetch(PDO::FETCH_ASSOC)){
     echo $rows['first_name']."<br>";
}

?>