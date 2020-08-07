<?php

session_start();

require("php_scripts/connect.php");

$query = "SELECT * FROM users";
$getUsers = $conn->prepare("SELECT * FROM users");
$getUsers->execute();
$users = $getUsers->fetchAll();
$userString = "";
foreach ($users as $row) {

    $active = intval($row["activated"]) > 0 ? ' checked' : '';
    $userType = intval($row["user_type"]) <3 ? (intval($row["user_type"]) <2 ? "User": "Employee") : 'Admin';

    $userString .= '<tr>
    <td>' . $userType . '</td>
    <td>' . $row["first_name"] . '</td>
    <td>' . $row["last_name"] . '</td>
    <td>' . $row["email"] . '</td>
    <td>  <input type="checkbox" name="userSelection[]" value=' . $row["id"] . $active . ' > </td>';
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
        <h1>Manage Users</h1>
    </div>
    <div class="center">
        <?php
        // Show forms if user is logged in
        if (isset($_SESSION['userType'])) {

            echo '


            <div>
            <form id="userManagementForm" method="POST" action="/353_Main_Project/php_scripts/manage_user.php">
            <div id="left-form">
                <table>
                    <tr>
                        <th>Type</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Active</th>

                    </tr>' . $userString . '
                </table>
            </div>
            </form>
            <div style="text-align:center;">
                <button type="submit" form="userManagementForm" value="Submit">Submit</button>
            </div>
            </div>';
        } else {
            echo '<p>You must <a href="login.php">log in</a> to view this page</p>';
        }

        ?>
    </div>

</body>

</html>