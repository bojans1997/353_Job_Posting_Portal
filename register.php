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

</body>
</html>