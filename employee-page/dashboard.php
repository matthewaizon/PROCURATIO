<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Procuratio – Employee Dashboard</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/font.css">
  <link rel="stylesheet" href="../assets/css/em.css">
  <link rel="stylesheet" href="../assets/css/hero.css">

  <script>
    function attendanceFunction(){
        window.location.href = "attendance.php";
    }
    function homepageFunction(){
        window.location.href="dashboard.php";
    }  
    function payrollFunction(){
        window.location.href = "payroll.php";
    }
    function logoutpageFunction(){
        window.location.href="../applicant-page/em_dashboard.php";
    }
  </script>
</head>

<body>
  <div class="container">
    <div class="nav">
      <div class="nav-left">
        <img class="logo" src="../assets/img/logo.png" alt="">
      </div>
      <div class="nav-right">
        <h2 onClick="homepageFunction()">Dashboard</h2>
        <h2 onClick="attendanceFunction()">Attendance</h2>
        <h2 onClick="payrollFunction()">Pay Roll</h2>
        <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
      </div>
    </div>

    <div class="hero">
      <h3>Welcome, <?= htmlspecialchars($_SESSION['name'] ?? 'Employee') ?>!</h3>
      <p>Use the tabs above to record your attendance or view your payroll.</p>
    </div>
    <!-- You can drop in dashboard widgets here -->
  </div>
</body>
</html>