<?php

require("connect.php");

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

		// if user is an employee, display these options
		echo'
			<a href="job_search.php">Search for Jobs</a>&nbsp;&nbsp;&nbsp;
			<a href="manage_applications.php">Manage Job Applications</a>&nbsp;&nbsp;&nbsp;
			<a href="update_profile.php">Update Profile</a>&nbsp;&nbsp;&nbsp;
			<a href="logout.php">Log Out</a>
		';

		// else display these

		/* echo'
			<a href="job_search.php">Search for Jobs</a>&nbsp;&nbsp;&nbsp;
			<a href="manage_applications.php">Manage Job Applications</a>&nbsp;&nbsp;&nbsp;
			<a href="update_profile.php">Update Profile</a>&nbsp;&nbsp;&nbsp;
			<a href="logout.php">Log Out</a>
		';*/

		?>
	</nav>
</div>
<br>

</body>
</html>