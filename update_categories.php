<?php

session_start();

require("php_scripts/connect.php");


$getCategories = $conn->prepare("SELECT * FROM category WHERE created_by = ?");
$getCategories->execute([$_SESSION["user_id"]]);
$categories = $getCategories->fetchAll();

$categoryString = "";

foreach ($categories as $row) {

	$categoryString .= '<tr>
		<td>'.$row["name"].'</td>
		<td><a href="create_category.php?catID='.$row["id"].'">Edit</a></td>
		</tr>';
}

?>

<!DOCTYPE html>
<html>
<head>
<title>View Categories</title>

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
	<h1>View Categories</h1>
</div>

<div class="center">
		<?php
			// Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
				if(count($categories) == 0) {
					echo '<p>You have not created any categories yet.</p>';
				} else {
					echo '
						<div id="left-form">
							<table>
								<tr>
									<th>Name</th>
								</tr>'.$categoryString.'
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