<?php
session_start(); // Start the session


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
                <h2 onClick="homepageFunction()">Home</h2>
                <h2 onClick="manageempFunction()">Manage Employee</h2>
                <h2 onClick="applicationpageFunction()">Application</h2>
                <h2 onClick="ListingFunction()">Job Listings</h2>
                <h2 onClick="attenrollFunction()">Attendance</h2>
                <h2 onClick="payrollFunction()">Pay Roll</h2>
                <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
            </div>
        </div>


        <div class="hero">
            <h3>EMPOWERING HR: Streamline Applications, Perfect Interviews. Accelerate Onboarding.</h3>
            <button>Click Me</button>
        </div>
    </div>
</body>

</html>
