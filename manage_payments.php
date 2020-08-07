<?php

session_start();

require("php_scripts/connect.php");


$getMethods = $conn->prepare("SELECT * FROM payment_method WHERE user_id = ? AND (active = 1 OR active IS NULL)");
$getMethods->execute([$_SESSION["user_id"]]);
$methods = $getMethods->fetchAll();

$methodString = "";

foreach ($methods as $row) {
	$methodString .= '<tr>
		<td>'.$row["card_type"].'</td>
		<td>'.$row["cardholder_name"].'</td>
		<td>'.$row["card_number"].'</td>
		<td>'.$row["cvc"].'</td>
		<td>'.$row["expiration_date"].'</td>
		<td><a href="add_payment.php?paymentID='.$row["id"].'">Edit</a></td>
		<td><a href="/353_Main_Project/php_scripts/delete_payment.php?paymentID='.$row["id"].'">Delete</a></td>
		</tr>';
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Payment Methods</title>

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

table, th, td {
	border: 1px solid black;;
  	border-collapse: collapse;
}
</style>
</head>
<body>

<div class="dashboard-link">
	<a href="dashboard.php">Return to Dashboard</a>
</div>

<div class="center">
	<h1>Manage Payment Methods</h1>
</div>

<div class="center">
		<?php
			// Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
				if(count($methods) == 0) {
					echo '<p>You have not added any payment methods yet.</p>';
				} else {
					echo '
						<div id="left-form">
							<table>
								<tr>
									<th>Card Type</th>
									<th>Cardholder Name</th>
									<th>Card Number</th>
									<th>CVC</th>
									<th>Expiration Date</th>
								</tr>'.$methodString.'
							</table>
						</div>';
				}
			} else {
				echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
			}

		?>
</div>
</body>
</html>