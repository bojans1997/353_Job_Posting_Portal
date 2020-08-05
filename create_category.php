<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$catID = "";
$name = "";

if(isset($_GET["catID"])) {
	$getCategory = $conn->prepare("SELECT * FROM category WHERE id = ?");
	$getCategory->execute([$_GET["catID"]]);
	$category = $getCategory->fetch();
	$catID = $category["id"];
	$name = $category["name"];
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Create a Category</title>

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
	<h1>Create a Category</h1>
</div>
<div class="center">
		<?php
			// Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
				echo '
					<div id="left-form">
						<form method="POST" action="/353_Main_Project/php_scripts/create_category.php">
							<input type="hidden" name="catID" value="'.$catID.'">
							<input type="text" name="name" placeholder="Category Name" maxlength="20" value="'.$name.'" required>
							<br><br>
							<input type="submit" value="Create Category">
						</form>
					</div>';
			} else {
				echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
			}

		?>
</div>