<?php

session_start();

require("php_scripts/connect.php");

if(isset($_GET['jobID']) && isset($_GET['userID']) && isset($_GET['op'])) {
	if($_GET['op'] == 1) {
		$getPositionsOpen = $conn->prepare("SELECT positions_available FROM job WHERE id = ?");
		$getPositionsOpen->execute([$_GET['jobID']]);
		$positionsAvailable = $getPositionsOpen->fetch();
		$newPositions = $positionsAvailable['positions_available'] - 1;

		$updatePositionsOpen = $conn->prepare("UPDATE job SET positions_available = ? WHERE id = ?");
		$updatePositionsOpen->execute([$newPositions, $_GET['jobID']]);

		// if there are no more positions available, reject all other applications for this job
		if($newPositions == 0) {
			$rejectApplications = $conn->prepare("UPDATE job_application SET accepted = 0 WHERE job_id = ?");
			$rejectApplications->execute([$_GET['jobID']]);
		}
	}

	$acceptCandidate = $conn->prepare("UPDATE job_application SET accepted = ? WHERE user_id = ? AND job_id = ?");
	$acceptCandidate->execute([$_GET['op'], $_GET['userID'], $_GET['jobID']]);
}


$getJobs = $conn->prepare("SELECT DISTINCT job_id FROM job_application JOIN job ON job_application.job_id = job.id WHERE job.created_by = ? AND (job_application.accepted IS NULL AND job.positions_available > 0)");
$getJobs->execute([$_SESSION['user_id']]);
$jobs = $getJobs->fetchAll();

$jobString = "";
foreach ($jobs as $job) {
	$getJobInfo = $conn->prepare("SELECT * FROM job WHERE id = ?");
	$getJobInfo->execute([$job['job_id']]);
	$jobInfo = $getJobInfo->fetch();

	$getCategory = $conn->prepare("SELECT name FROM category WHERE id = ?");
	$getCategory->execute([$jobInfo["category_id"]]);
	$category = $getCategory->fetch();

	$getApplications = $conn->prepare("SELECT * FROM job_application WHERE job_id = ? AND accepted IS NULL;");
	$getApplications->execute([$job['job_id']]);
	$applications = $getApplications->fetchAll();

	$applicationString = "";
	foreach ($applications as $application) {
		$getUserInfo = $conn->prepare("SELECT * FROM users JOIN user_profile ON users.id = user_profile.user_id WHERE users.id = ?;");
		$getUserInfo->execute([$application['user_id']]);
		$user = $getUserInfo->fetch();

		$applicationString .= 
			'<tr>
				<td>'.$user['first_name'].' '.$user['last_name'].'</td>
				<td>'.$application['application_date'].'</td>
				<td>'.$user['description'].'</td>
				<td>'.$user['experience'].'</td>
				<td>'.$user['email'].'</td>
				<td><a href="view_applications.php?jobID='.$jobInfo["id"].'&userID='.$user['id'].'&op=1">Accept</a></td>
				<td><a href="view_applications.php?jobID='.$jobInfo["id"].'&userID='.$user['id'].'&op=0">Reject</a></td>
			</tr>';
	}

	$jobString .= '<table><tr>
                    <th>Job Title</th>
                    <th>Salary</th>
					<th>Job Description</th>
					<th>Positions Available</th>
					<th>Category</th>
					</tr>';

	$jobString .= '<tr>
		<td>'.$jobInfo["title"].'</td>
		<td>'.$jobInfo["salary"].'</td>
		<td>'.$jobInfo["description"].'</td>
		<td>'.$jobInfo["positions_available"].'</td>
		<td>'.$category["name"].'</td>
		</tr>
		<tr><th>Applicant Name</th><th>Date Applied</th><th>Description</th><th>Experience</th><th>Email</th></tr>
		'.$applicationString.'</table><br>';
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>View Applications</title>

<style>
.center {
	margin: 0 auto;
	margin-left: 42%;
}

.inline-block {
	display: inline-block;
}

#left-form {
	margin: 0 auto;
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
	<h1>View Applications</h1>
</div>

<div class="center">
		<?php
			// Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
				if(count($jobs) == 0) {
					echo '<p>There are no applications for your jobs.</p>';
				} else {
					echo '
						<div id="left-form">
							'.$jobString.'
						</div>';
				}
			} else {
				echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
			}

		?>
</div>
</body>
</html>