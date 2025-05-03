<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
requireRole('Employee');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Procuratio</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/em.css">
    <script>
        function logoutpageFunction() {
            window.location.href = "../logout.php";
        }
        function dashboardFunction() {
            window.location.href = "dashboard.php";
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
            <h2 onClick="dashboardFunction()">Dashboard</h2>
            <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
        </div>
    </div>

    <div class="hero">
        <h1>Contact Us</h1>
        <p>If you need assistance, please reach out to the HR department or system administrator.</p>
        <ul>
            <li><strong>Email:</strong> support@procuratio.com</li>
            <li><strong>Phone:</strong> (02) 123-4567</li>
            <li><strong>Office Hours:</strong> Mon–Fri, 8:00 AM – 5:00 PM</li>
        </ul>
    </div>
</div>
</body>
</html>
