<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$getPaymentMethods = $conn->prepare("SELECT * FROM payment_method WHERE user_id = ?");
$getPaymentMethods->execute([$_SESSION["user_id"]]);
$result = $getPaymentMethods->fetchAll();

$newSubscription = $_POST['subscription'];
$currentSubscription = $_POST['currentSubscription'];

$paymentOptions = "";

foreach ($result as $row) {
	$paymentOptions .= '<option value="'.$row['id'].'">'.$row['card_number'].'</option>';
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Choose Your Payment Method</title>

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
	<h1>Choose Your Payment Method</h1>
</div>
<div class="center">
		<?php
			// Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
				if(count($result) == 0) {
					echo '<p>You have not added any payment methods yet.</p>';
				} else {
					echo '
					<div id="left-form">
						<form method="POST" action="/353_Main_Project/php_scripts/change_category.php">
							<input type="hidden" name="newSubscription" value="'.$newSubscription.'">
							<input type="hidden" name="currentSubscription" value="'.$currentSubscription.'">
							<select name="paymentOption">
							'.$paymentOptions.'
							</select>
							<br><br>
							<input type="submit" value="Continue">
						</form>
					</div>';
				}
			} else {
				echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
			}

		?>
</div>