<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
requireRole('Admin');
session_start();

// Fetch job applications
$sql = "SELECT a.application_id, u.name AS applicant_name, a.position_applied, a.status, a.date_applied
        FROM applications a
        INNER JOIN users u ON a.user_id = u.user_id
        ORDER BY a.date_applied DESC";

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
    <title>Procuratio - Applications</title>
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
            <img class="logo" src="img/logo.png" alt="Procuratio Logo">
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
        <h2>Job Applications</h2>
        <table>
            <thead>
                <tr>
                    <th>Application ID</th>
                    <th>Applicant Name</th>
                    <th>Position Applied</th>
                    <th>Status</th>
                    <th>Date Applied</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (sqlsrv_has_rows($result)) {
                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        $appliedDate = $row['date_applied'] ? $row['date_applied']->format('Y-m-d') : 'N/A';
                        echo "<tr>
                                <td>" . htmlspecialchars($row['application_id']) . "</td>
                                <td>" . htmlspecialchars($row['applicant_name']) . "</td>
                                <td>" . htmlspecialchars($row['position_applied']) . "</td>
                                <td>" . htmlspecialchars($row['status']) . "</td>
                                <td>" . $appliedDate . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No applications found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
