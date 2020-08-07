<?php

session_start();

require("php_scripts/connect.php");

$query = "SELECT * FROM job_application 
            INNER JOIN users user
	            on user.id = user_id
            INNER JOIN job j
                on j.id = job_id
                order by application_date DESC" ;

$getApplications = $conn->prepare($query);
$getApplications->execute();
$applications = $getApplications->fetchAll();
$applicationstring = "";
foreach ($applications as $row) {

    $userType = intval($row["user_type"]) < 3 ? (intval($row["user_type"]) < 2 ? "User" : "Employee") : 'Admin';
    $accepted = intval($row["accepted"]) > 0 ? "Yes" : 'No';
    $applicationstring .= '<tr>
    <td>' . $userType . '</td>
    <td>' . $row["first_name"] . '</td>
    <td>' . $row["last_name"] . '</td>
    <td>' . $row["email"] . '</td>
    <td>' . $row["company"] . '</td>
    <td>' . $row["title"] . '</td>
    <td>' . $row["salary"] . '</td>
    <td>' .  $accepted . '</td>
    <td>' . $row["application_date"] . '</td>';
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

        /* table,
        th,
        td {
            border: 1px solid black;
            ;
            border-collapse: collapse;
        } */

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>

    <div class="dashboard-link">
        <a href="dashboard.php">Return to Dashboard</a>
    </div>

    <div class="center">
        <h1>View activities</h1>
    </div>
    <div class="center">
        <?php
        // Show forms if user is logged in
        if (isset($_SESSION['userType'])) {

            echo '
            <div id="left-form">
                <table>
                    <tr>
                        <th>Type</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Title</th>
                        <th>Salary</th>
                        <th>Accepted</th>
                        <th>Application Date</th>

                    </tr>' . $applicationstring . '
                </table>
            </div>';
        } else {
            echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
        }

        ?>
    </div>

</body>

</html>