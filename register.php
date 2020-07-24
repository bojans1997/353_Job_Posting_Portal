<?php

session_start();

?>

<!DOCTYPE html>
<html>
<head>
<title>User Sign Up</title>

<style>
.center {
	text-align: center;
}
</style>
</head>
<body>

<div class="center">
	<h1>User sign up</h1>
</div>
<div class="center">
	<?php
		if(ISSET($_SESSION['errorEmail'])) {
			echo '<p style="color: red">Error: That email is already in use.</p>';
		}
	?>
	<form method="POST" action="/353_Main_Project/php_scripts/add_user.php">
			<input type="text" name="fname" id="fname" placeholder="First Name" required>
			<br>
			<input type="text" name="lname" id="lname" placeholder="Last Name" required>
			<br>
			<input type="text" name="address" id="address" placeholder="Address" required>
			<br>
			<input type="text" name="postal" id="postal" placeholder="Postal Code" required>
			<br>
			<select name="province" required>
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
			<input type="email" name="email" id="email" placeholder="Email address" required>
			<br>
			<input type="password" name="password" id="password" placeholder="Password" required>
			<br><br>
			<input type="submit" value="Register">
		</form>

		<p>Already have an account? <a href="login.php">Click here</a> to log in.</p>
</div>

</body>
</html>