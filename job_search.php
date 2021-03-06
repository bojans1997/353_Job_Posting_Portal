<?php

session_start();

require("php_scripts/connect.php");

// check if user is allowed to apply for jobs
$getSubscriptionModel= $conn->prepare("SELECT * FROM subscription WHERE user_id = ? AND active = 1");
$getSubscriptionModel->execute([$_SESSION["user_id"]]);
$subscription = $getSubscriptionModel->fetch();

// get number of jobs already applied to from this user
$getNumJobs= $conn->prepare("SELECT * FROM job_application WHERE user_id = ? AND accepted IS NULL");
$getNumJobs->execute([$_SESSION["user_id"]]);
$numJobs = $getNumJobs->fetchAll();

$getApply = $conn->prepare("SELECT * FROM job_application WHERE user_id = ?");
$getApply->execute([$_SESSION['user_id']]);
$applyResult = $getApply->fetchAll();

$categoryID = '';
if(isset($_POST["category"])){
    $categoryID = $_POST["category"];
}

if (empty($categoryID)|| $categoryID == 0) {
    $getJobs = $conn->prepare("SELECT * FROM job  WHERE positions_available != 0 ORDER BY company");
    $getJobs->execute();
    $jobs = $getJobs->fetchAll();

    $jobString = "";
    foreach ($jobs as $row) {
        
        $acceptNull = $conn->prepare("SELECT accepted FROM job_application WHERE user_id = ? AND job_id = ?");
        $acceptNull->execute([$_SESSION['user_id'], $row["id"]]);
        $checkAcceptNull = $acceptNull->fetch();
        
        if (is_null($checkAcceptNull["accepted"])){
            $getCategory = $conn->prepare("SELECT name FROM category WHERE id = ?");
            $getCategory->execute([$row["category_id"]]);
            $category = $getCategory->fetch();

            $jobString .= '<tr>
                <td>'.$row["company"].'</td>
                <td>'.$row["title"].'</td>
                <td>'.$row["salary"].'</td>
                <td>'.$row["description"].'</td>
                <td>'.$row["positions_available"].'</td>
                <td>'.$category["name"].'</td>';
            $apply= false;

            foreach ($applyResult as $applyRow) {
                if ($applyRow["job_id"]==$row["id"]){
                      $apply= true;
                }            
            }

            if($apply){
                $jobString .= '
                <td><a href="php_scripts/job_withdraw.php?jobID='.$row["id"].'&userID='.$_SESSION['user_id'].'">Withdraw</a></td>';
            }else{
                if($subscription['subscription_model_id'] == 3 || ($subscription['subscription_model_id'] == 2 && count($numJobs) < 5)) { 
                    $jobString .= '
                    <td><a href="php_scripts/job_apply.php?jobID='.$row["id"].'&userID='.$_SESSION['user_id'].'">Apply</a></td>';
                }
            }


            $jobString .= '</tr>';
        }
    }

    $getCategories = $conn->prepare("SELECT id, name FROM  category");
    $getCategories->execute();
    $result = $getCategories->fetchAll();

    $categories = "";

    foreach ($result as $row) {
        $categories .= '<option value="'.$row["id"].'"">'.$row["name"].'</option>';
    }
}
else{
    $getJobs = $conn->prepare("SELECT * FROM job WHERE category_id = ? AND positions_available != 0");
    $getJobs->execute([$categoryID]);
    $jobs = $getJobs->fetchAll();

    $jobString = "";

    foreach ($jobs as $row) {
         
        $acceptNull = $conn->prepare("SELECT accepted FROM job_application WHERE user_id = ? AND job_id = ?");
        $acceptNull->execute([$_SESSION['user_id'], $row["id"]]);
        $checkAcceptNull = $acceptNull->fetch();
        
        if (is_null($checkAcceptNull["accepted"])){
            $getCategory = $conn->prepare("SELECT name FROM category WHERE id = ?");
            $getCategory->execute([$row["category_id"]]);
            $category = $getCategory->fetch();

            $jobString .= '<tr>
                <td>'.$row["company"].'</td>
                <td>'.$row["title"].'</td>
                <td>'.$row["salary"].'</td>
                <td>'.$row["description"].'</td>
                <td>'.$row["positions_available"].'</td>
                <td>'.$category["name"].'</td>';
            $apply= false;
            foreach ($applyResult as $applyRow) {
                if ($applyRow["job_id"]==$row["id"]){
                      $apply= true;
                }            
            }
             if($apply){
                 $jobString .= '
                <td><a href="php_scripts/job_withdraw.php?jobID='.$row["id"].'&userID='.$_SESSION['user_id'].'">Withdraw</a></td>';
             }else{
                if($subscription['subscription_model_id'] == 3 || ($subscription['subscription_model_id'] == 2 && count($numJobs) < 5)) {
                    $jobString .= '
                    <td><a href="php_scripts/job_apply.php?jobID='.$row["id"].'&userID='.$_SESSION['user_id'].'">Apply</a></td>';
                }
             }


            $jobString .= '</tr>';
        }
    }

    $getCategories = $conn->prepare("SELECT id, name FROM  category");
    $getCategories->execute();
    $result = $getCategories->fetchAll();

    $categories = "";

    foreach ($result as $row) {
        $categories .= '<option value="'.$row["id"].'"" '.(($categoryID==$row["id"])?"selected":"").' >'.$row["name"].'</option>';
    }
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
	<h1>Search Jobs</h1>
</div>
    
<div class="center">
    <?php 
        // Show forms if user is logged in
			if(isset($_SESSION['userType'])) {
                if($subscription['subscription_model_id'] == 1) {
                    echo '<p>You cannot apply for jobs with your current subscription.</p>';
                } else {
                    if($subscription['subscription_model_id'] == 2 && count($numJobs) >= 5) {
                        echo '<p>You have reached your limit of 5 job applications</p>';
                    }
    				echo '
                        <p>Search by category:</p>
    					<div id="left-form">
    						<form method="POST" action="">
    							<select name="category">
                                <option value=0> Default (Company Name)</option>
    							'.$categories.'
    							</select>
    							<input type="submit" value="Search">
    						</form>
    					</div>
                        <br>';
                }
			} else {
				echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
			}
    ?>
</div>    
<br>
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