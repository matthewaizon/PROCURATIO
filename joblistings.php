<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
requireRole('Admin');
session_start();

// Fetch job listings from the database
$sql = "SELECT job_id, title, department, description, date_posted FROM job_listings ORDER BY date_posted DESC";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio - Job Listings</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/em.css">
    <script>
        function homepageFunction() { window.location.href = "dashboard.php"; }
        function logoutpageFunction() { window.location.href = "logout.php"; }
        function manageempFunction() { window.location.href = "manage_emp.php"; }
        function applicationpageFunction() { window.location.href = "application.php"; }
        function ListingFunction() { window.location.href = "joblistings.php"; }
        function attenrollFunction() { window.location.href = "attenroll.php"; }
        function payrollFunction() { window.location.href = "payroll.php"; }
    </script>
</head>
<body>
<div class="container">
    <div class="nav">
        <div class="nav-left">
            <img class="logo" src="img/logo.png" alt="">
        </div>
        <div class="nav-right">
            <h2 onClick="homepageFunction()">Home</h2>
            <h2 onClick="manageempFunction()">Manage Employee</h2>
            <h2 onClick="applicationpageFunction()">Application</h2>
            <h2 onClick="ListingFunction()">Job Listings</h2>
            <h2 onClick="attenrollFunction()">Attendance</h2>
            <h2 onClick="payrollFunction()">Pay Roll</h2>
            <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
        </div>
    </div>

    <div class="application-table">
        <h2>Job Listings</h2>
        <table>
            <thead>
                <tr>
                    <th>Job ID</th>
                    <th>Title</th>
                    <th>Department</th>
                    <th>Description</th>
                    <th>Date Posted</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (sqlsrv_has_rows($result)) {
                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        $datePosted = $row['date_posted'] ? $row['date_posted']->format('Y-m-d') : 'N/A';
                        echo "<tr>
                                <td>" . htmlspecialchars($row['job_id']) . "</td>
                                <td>" . htmlspecialchars($row['title']) . "</td>
                                <td>" . htmlspecialchars($row['department']) . "</td>
                                <td>" . htmlspecialchars($row['description']) . "</td>
                                <td>" . $datePosted . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No job listings found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
