<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$jobID = "";
$title = "";
$salary = "";
$category = "";
$description = "";
$positions = "";

if(isset($_GET["jobID"])) {
	$getJob = $conn->prepare("SELECT * FROM job WHERE id = ?");
	$getJob->execute([$_GET["jobID"]]);
	$job = $getJob->fetch();
	$jobID = $job["id"];
	$title = $job["title"];
	$salary = $job["salary"];
	$description = $job["description"];
	$positions = $job["positions_available"];
}

$getCategories = $conn->prepare("SELECT id, name FROM  category WHERE created_by = ?");
$getCategories->execute([$_SESSION["user_id"]]);
$result = $getCategories->fetchAll();

$categories = "";

foreach ($result as $row) {
	$categories .= '<option value="'.$row["id"].'"">'.$row["name"].'</option>';
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Post a Job</title>

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
	<h1>Post a Job</h1>
</div>
<div class="center">
		<?php
			// Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
				echo '
					<div id="left-form">
						<form method="POST" action="/353_Main_Project/php_scripts/post_job.php">
							<input type="hidden" name="jobID" value="'.$jobID.'">
							<input type="text" name="title" placeholder="Job Title" value="'.$title.'" required>
							<br>
							<input type="text" name="salary" placeholder="Salary" value="'.$salary.'"  required>
							<br>
							<select name="category" required>
							'.$categories.'
							</select>
							<br>
							<textarea name="description" rows="4" cols="50" placeholder="Description" maxlength="50"  required>'.$description.'</textarea>
							<br>
							<input type="text" name="positions" placeholder="Positions Available" value="'.$positions.'"  required>
							<br><br>
							<input type="submit" value="Post Job">
						</form>
					</div>';
			} else {
				echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
			}

		?>
</div>