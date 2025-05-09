<?php
session_start(); // Start the session

$name = $_SESSION['name'];
$serverName = "BELEH\SQLEXPRESS";
$connectionOptions = [
    "Database" => "procuratio",
    "Uid" => "",
    "PWD" => ""
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/font.css">
    <link rel="stylesheet" href="../assets/css/em.css">
    <link rel="stylesheet" href="../assets/css/hero.css">


    <script>
        function logoutpageFunction(){
            window.location.href="../login.php";
        }
        function attendanceFunction(){
            window.location.href="attendance.php";
        }  
        function payrollFunction(){
            window.location.href="payroll.php";
        }  
    </script>
</head>

<body>
    <div class="container">
        <div class="nav">
            <div class="nav-left">
                <img class="logo" src="assets/img/logo.png" alt="">
            </div>
            
            <div class="nav-right">
                <h2 class="border" onClick="attendanceFunction()">Attendance</h2>
                <h2 class="border" onClick="payrollFunction()">Payroll</h2>
                <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
            </div>
        </div>
        <h1>Hello World</h1>
    </div>
</body>

</html>
