<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireRole('Employee');
session_start();

// Optional: fetch employee-specific data (e.g., name, stats, etc.)
$userId = $_SESSION['user_id'];
$sql = "SELECT name FROM users WHERE user_id = ?";
$params = [$userId];
$stmt = sqlsrv_query($conn, $sql, $params);
$user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Procuratio</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/em.css">
    <script>
        function logoutpageFunction() {
            window.location.href = "../logout.php";
        }
    </script>
</head>
<body>
<div class="container">
    <div class="nav">
        <div class="nav-left">
            <img class="logo" src="../img/logo.png" alt="Procuratio Logo">
        </div>
        <div class="nav-right">
            <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
        </div>
    </div>

    <div class="hero">
        <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <p>This is your employee dashboard.</p>
        <ul>
            <li>✅ View your attendance</li>
            <li>💰 Check your payroll</li>
            <li>📄 Track job applications</li>
        </ul>
    </div>
</div>
</body>
</html>
