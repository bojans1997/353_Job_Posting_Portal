<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$cardholder = "";
$number = "";
$cvc = "";
$date = "";
$existingID = "";
$cardType = "";

if(isset($_GET["paymentID"])) {
	$getMethod = $conn->prepare("SELECT * FROM payment_method WHERE id = ?");
	$getMethod->execute([$_GET["paymentID"]]);
	$method = $getMethod->fetch();
	$cardType = $method["card_type"];
	$cardholder = $method["cardholder_name"];
	$number = $method["card_number"];
	$cvc = $method["cvc"];
	$date = $method["expiration_date"];
	$existingID = $_GET["paymentID"];
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Add Payment Method</title>

<style>
.center {
	margin: 0 auto;
	margin-left: 42%;
}

.inline-block {
	display: inline-block;
}

#left-form {
	float: left;
}

#right-form {
	float: left;
	clear: right;
}

#deleteButton {
	clear: both;
	margin: 0 auto;
	padding-top: 2%;
}

.dashboard-link {
	margin-left: 20%;
}
</style>
</head>
<body>

<div class="dashboard-link">
	<a href="dashboard.php">Return to Dashboard</a>
</div>

<div class="center">
	<h1>Add Payment Method</h1>
</div>
<div class="center">
		<?php
			// Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
				echo '
					<div id="left-form">
						<p>Credit Card</p>
						<form method="POST" action="/353_Main_Project/php_scripts/add_payment.php">
							<input type="hidden" name="cardType" value="credit">
							<input type="hidden" name="existingID" value="'.$existingID.'"">
							<input type="text" name="cardholder" placeholder="Cardholder Name" value="'.(($cardType!=="debit")?$cardholder:"").'" maxlength="30" required>
							<br>
							<input type="text" name="number" placeholder="Card Number" value="'.(($cardType!=="debit")?$number:"").'" maxlenth="30" required>
							<br>
							<input type="text" name="cvc" placeholder="CVC" value="'.(($cardType!=="debit")?$cvc:"").'" maxlength="3" required>
							<br>
							<input type="date" name="expire" placeholder="Expiration Date" value="'.(($cardType!=="debit")?$date:"").'" required>
							<br>
							<br><br>
							<input type="submit" value="Add Credit Card">
						</form>
					</div>
					<div id="right-form">
						<p>Debit Card</p>
						<form method="POST" action="/353_Main_Project/php_scripts/add_payment.php">
							<input type="hidden" name="cardType" value="debit">
							<input type="hidden" name="existingID" value="'.$existingID.'"">
							<input type="text" name="cardholder" placeholder="Cardholder Name" value="'.(($cardType!=="credit")?$cardholder:"").'" maxlength="30" required>
							<br>
							<input type="text" name="number" placeholder="Card Number" value="'.(($cardType!=="credit")?$number:"").'" maxlength="30" required>
							<br>
							<input type="date" name="expire" placeholder="Expiration Date" value="'.(($cardType!=="credit")?$date:"").'" maxlength="3" required>
							<br>
							<br><br>
							<input type="submit" value="Add Debit Card">
						</form>
					</div>';
			} else {
				echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
			}

		?>
</div>