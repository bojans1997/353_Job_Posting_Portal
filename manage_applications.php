<?php

session_start();

require("php_scripts/connect.php");

$getJobs = $conn->prepare("SELECT * 
FROM job_application
JOIN job ON job_application.job_id = job.id
WHERE job_application.user_id = ?;");
$getJobs->execute([$_SESSION['user_id']]);
$jobs = $getJobs->fetchAll();

$jobString = "";
foreach ($jobs as $row) {
        
$getCategory = $conn->prepare("SELECT name FROM category WHERE id = ?");
$getCategory->execute([$row["category_id"]]);
$category = $getCategory->fetch();

$jobString .= '<tr>
    <td>'.$row["application_date"].'</td>
    <td>'.$row["company"].'</td>
    <td>'.$row["title"].'</td>
    <td>'.$row["salary"].'</td>
    <td>'.$row["description"].'</td>
    <td>'.$row["positions_available"].'</td>
    <td>'.$category["name"].'</td></tr>';
}
?>

<!DOCTYPE html>
<html>
<head>
<title>View Jobs</title>

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
	<h1>Manage Applied Jobs</h1>
</div>

<div class="center">
		<?php
			// Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
				if(count($jobs) == 0) {
					echo '<p>There is no jobs available yet.</p>';
				} else {
					echo '
						<div id="left-form">
							<table>
								<tr>
                                    <th>Date Applied</th>
                                    <th>Company Name</th>
									<th>Title</th>
									<th>Salary</th>
									<th>Description</th>
									<th>Positions Available</th>
									<th>Category</th>
								</tr>'.$jobString.'
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