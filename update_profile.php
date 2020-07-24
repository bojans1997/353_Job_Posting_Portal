<?php

require("php_scripts/connect.php");

?>

<!DOCTYPE html>
<html>
<head>
<title>Update Profile</title>

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
	<h1>Update Profile</h1>
</div>

<div class="center">
	<div id="left-form">
		<form method="POST">
			<input type="text" name="fname" id="fname" placeholder="First Name">
			<br>
			<input type="text" name="lname" id="lname" placeholder="Last Name">
			<br>
			<input type="text" name="address" id="address" placeholder="Address">
			<br>
			<input type="text" name="postal" id="postal" placeholder="Postal Code">
			<br>
			<select name="province">
				<option value="AB">Alberta</option>
				<option value="BC">British Columbia</option>
				<option value="MB">Manitoba</option>
				<option value="NB">New Brunswick</option>
				<option value="NL">Newfoundland and Labrador</option>
				<option value="NS">Nova Scotia</option>
				<option value="ON">Ontario</option>
				<option value="PE">Prince Edward Island</option>
				<option value="QC">Quebec</option>
				<option value="SK">Saskatchewan</option>
				<option value="NT">Northwest Territories</option>
				<option value="NU">Nunavut</option>
				<option value="YT">Yukon</option>
			</select>
			<br>
			<input type="email" name="email" id="email" placeholder="Email address">
			<br>
			<input type="password" name="password" id="password" placeholder="Password">
			<br><br>
			<input type="submit" value="Update">
		</form>
	</div>
	<div id="right-form">
		<p>
			Change Category
		</p>
		<?php

			// Change which categories appear based on the type of user logged in (employer or employee)

		?>
		<form method="POST">
			<input type="radio" name="category" id="basic" value="basic">
			<label for="basic">Basic (Free)</label>
			<br>
			<input type="radio" name="category" value="prime">
			<label for="prime">Prime ($10/Month)</label>
			<br>
			<input type="radio" name="category" value="gold">
			<label for="gold">Gold ($20/Month)</label>
			<br>
			<input type="submit" value="Update">
		</form>
	</div>
</div>

</body>
</html>