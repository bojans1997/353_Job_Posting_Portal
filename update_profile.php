<?php

session_start();

require("php_scripts/connect.php");

$result = "";

// if user is logged in, get their data
if(isset($_SESSION['email'])) {
	$email = $_SESSION['email'];
	$getUserData = $conn->prepare("SELECT * FROM user_profile WHERE user_id = ?");
	$getUserData->execute([$_SESSION['user_id']]);
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
	<h1>Update Profile</h1>
</div>

<div class="center">
		<?php
			// Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
				echo '
					<div id="left-form">
						<form method="POST" action="/353_Main_Project/php_scripts/update_user.php">
							<input type="text" name="address" id="address" placeholder="Address" value="'.$result["address"].'" required>
							<br>
							<input type="text" name="postal" id="postal" placeholder="Postal Code" value="'.$result["postal_code"].'" required>
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
							<textarea name="description" rows="4" cols="50" placeholder="Describe yourself" maxlength="50">'.$result['description'].'</textarea>
							<br>
							<textarea name="experience" rows="4" cols="50" placeholder="Experience" maxlength="200">'.$result['experience'].'</textarea>
							<br><br>
							<input type="submit" value="Update">
						</form>
					</div>
					<br>
					<div id="deleteButton">
						<button onclick="confirmDelete()">Delete Account</button>
					</div>';
			} else {
				echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
			}

		?>
</div>


<script>
	function confirmDelete() {
		var confirm = window.confirm("Are you sure you want to delete your account?")
		if(confirm) {
			window.location.href = "/353_Main_Project/php_scripts/delete_account.php";
		}
	}
</script>

</body>
</html>