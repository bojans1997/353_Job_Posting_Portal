<?php

session_start();

require("php_scripts/connect.php");

?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>
.center {
	text-align: center;
}

.dashboard-link {
	padding-bottom: 10%;
}
</style>
</head>
<body>

<div class="center">
	<h1>Dashboard</h1>
</div>

<div class="center">
	<nav>
		<?php 

		// display different options based on the type of user logged in
		if(ISSET($_SESSION['userType'])) {
			if($_SESSION['userType'] == 1) {
				echo'
					<a href="job_search.php">Search for Jobs</a>&nbsp;&nbsp;&nbsp;
					<a href="manage_applications.php">Manage Job Applications</a>&nbsp;&nbsp;&nbsp;
					<a href="update_profile.php">Update Profile</a>&nbsp;&nbsp;&nbsp;
					<a href="add_payment.php">Add Payment Method</a>&nbsp;&nbsp;&nbsp;
					<a href="manage_payments.php">Manage Payment Methods</a>&nbsp;&nbsp;&nbsp;
					<a href="/353_Main_Project/php_scripts/logout.php">Log Out</a>
				';
			} else if($_SESSION['userType'] == 2) {
				echo'
					<a href="post_job.php">Post a Job</a>&nbsp;&nbsp;&nbsp;
					<a href="create_category.php">Create a Category</a>&nbsp;&nbsp;&nbsp;
					<a href="update_jobs.php">View Your Jobs</a>&nbsp;&nbsp;&nbsp;
					<a href="update_categories.php">View Your Categories</a>&nbsp;&nbsp;&nbsp;
					<a href="view_applications.php">View Job Applications</a>&nbsp;&nbsp;&nbsp;
					<a href="add_payment.php">Add Payment Method</a>&nbsp;&nbsp;&nbsp;
					<a href="manage_payments.php">Manage Payment Methods</a>&nbsp;&nbsp;&nbsp;
					<a href="contact_us.php">Contact Us</a>&nbsp;&nbsp;&nbsp;
					<a href="/353_Main_Project/php_scripts/logout.php">Log Out</a>
				';
			} else if($_SESSION['userType'] == 3) {
				echo'
					<a href="manage_users.php">Manage Users</a>&nbsp;&nbsp;&nbsp;
					<a href="view_activities.php">View Activities</a>&nbsp;&nbsp;&nbsp;
					<a href="/353_Main_Project/php_scripts/logout.php">Log Out</a>
				';
			}
		} else {
			echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
		}

		?>
	</nav>
</div>
<br>

</body>
</html>