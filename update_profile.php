<?php

session_start();

require("php_scripts/connect.php");

$result = "";

// if user is logged in, get their data
if(isset($_SESSION['email'])) {
	$email = $_SESSION['email'];
	$getUserData = $conn->prepare("SELECT * FROM user WHERE email = ?");
	$getUserData->execute([$email]);
	$result = $getUserData->fetch();
}

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
		<?php

			// Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
				echo '
					<div id="left-form">
						<form method="POST" action="/353_Main_Project/php_scripts/update_user.php">
							<input type="text" name="fname" id="fname" placeholder="First Name" value="'.$result["fname"].'" required>
							<br>
							<input type="text" name="lname" id="lname" placeholder="Last Name" value="'.$result["lname"].'" required>
							<br>
							<input type="text" name="address" id="address" placeholder="Address" value="'.$result["address"].'" required>
							<br>
							<input type="text" name="postal" id="postal" placeholder="Postal Code" value="'.$result["postalcode"].'" required>
							<br>
							<select name="province" required>
								<option value="AB" '.(($result["province"]=="AB")?"selected":"").'>Alberta</option>
								<option value="BC" '.(($result["province"]=="BC")?"selected":"").'>British Columbia</option>
								<option value="MB" '.(($result["province"]=="MB")?"selected":"").'>Manitoba</option>
								<option value="NB" '.(($result["province"]=="NB")?"selected":"").'>New Brunswick</option>
								<option value="NL" '.(($result["province"]=="NL")?"selected":"").'>Newfoundland and Labrador</option>
								<option value="NS" '.(($result["province"]=="NS")?"selected":"").'>Nova Scotia</option>
								<option value="ON" '.(($result["province"]=="ON")?"selected":"").'>Ontario</option>
								<option value="PE" '.(($result["province"]=="PE")?"selected":"").'>Prince Edward Island</option>
								<option value="QC" '.(($result["province"]=="QC")?"selected":"").'>Quebec</option>
								<option value="SK" '.(($result["province"]=="SK")?"selected":"").'>Saskatchewan</option>
								<option value="NT" '.(($result["province"]=="NT")?"selected":"").'>Northwest Territories</option>
								<option value="NU" '.(($result["province"]=="NU")?"selected":"").'>Nunavut</option>
								<option value="YT" '.(($result["province"]=="YT")?"selected":"").'>Yukon</option>
							</select>
							<br>
							<input type="password" name="password" id="password" placeholder="Password" required>
							<br><br>
							<input type="submit" value="Update">
					</div>

					<div id="right-form">
						<p>
							Change Category
						</p>
							<input type="radio" name="category" id="basic" value="basic" '.(($result["category"]=="basic")?"checked":"").'>
							<label for="basic">Basic (Free)</label>
							<br>
							<input type="radio" name="category" value="prime" '.(($result["category"]=="prime")?"checked":"").'>
							<label for="prime">Prime ($10/Month)</label>
							<br>
							<input type="radio" name="category" value="gold" '.(($result["category"]=="gold")?"checked":"").'>
							<label for="gold">Gold ($20/Month)</label>
						</form>
					</div>';
			} else {
				echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
			}

		?>
</div>

</body>
</html>