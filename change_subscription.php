<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"]."/353_Main_Project/php_scripts/connect.php");

$getSubscription = $conn->prepare("SELECT * FROM subscription WHERE user_id = ? AND active = 1");
$getSubscription->execute([$_SESSION["user_id"]]);
$result = $getSubscription->fetch();

$getSubscriptionDetails = $conn->prepare("SELECT * FROM subscription_model");
$getSubscriptionDetails->execute();
$subscriptionDetails = $getSubscriptionDetails->fetchAll();

$allowString = "";
$subscriptionOptions = "";
$currentSubscription = $result['subscription_model_id'];

if($_SESSION['userType'] == 1) {
	$allowString = "apply to ";
	$subscriptionOptions = 
	$subscriptionDetails[0]['name'].' ($'.$subscriptionDetails[0]['price'].', '.$subscriptionDetails[0]['job_limit'].' jobs)<input type="radio" name="subscription" '.(($currentSubscription==1)?"checked":"").' value="1">
	<br>'.
	$subscriptionDetails[1]['name'].' ($'.$subscriptionDetails[1]['price'].', '.$subscriptionDetails[1]['job_limit'].' jobs)<input type="radio" name="subscription" '.(($currentSubscription==2)?"checked":"").' value="2">
	<br>'.
	$subscriptionDetails[2]['name'].' ($'.$subscriptionDetails[2]['price'].', no limit)<input type="radio" name="subscription" '.(($currentSubscription==3)?"checked":"").' value="3">';
} else {
	$allowString = "post ";
	$subscriptionOptions = 
	$subscriptionDetails[3]['name'].' ($'.$subscriptionDetails[3]['price'].', '.$subscriptionDetails[3]['job_limit'].' jobs)<input type="radio" name="subscription" '.(($currentSubscription==4)?"checked":"").' value="4">
	<br>'.
	$subscriptionDetails[4]['name'].' ($'.$subscriptionDetails[4]['price'].', no limit)<input type="radio" name="subscription" '.(($currentSubscription==5)?"checked":"").' value="5">';
}

$jobLimit = 0;
$jobLimit = $subscriptionDetails[$result['subscription_model_id']-1]['job_limit'].' jobs.';
if($jobLimit == -1) {
	$jobLimit = "as many jobs as you like.";
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Change Your Subscription</title>

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
	<h1>Change Your Subscription</h1>
</div>
<div class="center">
		<?php
			// Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
				echo '
					<div id="left-form">
						<p>Your current subscription is: '.$subscriptionDetails[$result['subscription_model_id']-1]['name'].' ($'.$subscriptionDetails[$result['subscription_model_id']-1]['price'].')</p>
						<p>This lets you '.$allowString.$jobLimit.'</p>
						<form method="POST" action="/353_Main_Project/choose_payment.php">
							<input type="hidden" name="currentSubscription" value="'.$result['subscription_model_id'].'">
							'.$subscriptionOptions.'
							<br><br>
							<input type="submit" value="Continue">
						</form>
					</div>';
			} else {
				echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
			}

		?>
</div>