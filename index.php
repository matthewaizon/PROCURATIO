<?php
require_once 'includes/db.php';
session_start();

// Optional redirect based on session:
if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] === 'Admin') {
        header('Location: dashboard.php');
        exit;
    } elseif ($_SESSION['user_type'] === 'Employee') {
        header('Location: employee/dashboard.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio - Welcome</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/hero.css">
</head>
<body>
    <div class="container">
        <div class="nav">
            <div class="nav-left">
                <img class="logo" src="img/logo.png" alt="Procuratio Logo">
            </div>
            <div class="nav-right">
                <h2 onClick="window.location.href='login.php'">Login</h2>
            </div>
        </div>

        <div class="hero">
            <h1>Welcome to Procuratio</h1>
            <p>Manage your employees, applications, and payroll all in one place.</p>
            <button onClick="window.location.href='login.php'">Get Started</button>
        </div>
    </div>
</body>
</html>
