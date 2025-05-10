<?php
session_start();
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

$employeeId = $_SESSION['employee_id'];        // ← adjust if your session key differs
$today      = date('Y-m-d');

// ── Clock-In / Clock-Out handlers ───────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['clock_in'])) {
    $sql  = "
      INSERT INTO attendance (employee_id, work_date, time_in)
      SELECT ?, ?, GETDATE()
      WHERE NOT EXISTS (
        SELECT 1 FROM attendance
        WHERE employee_id = ? AND work_date = ?
      )";
    sqlsrv_query($conn, $sql, [$employeeId, $today, $employeeId, $today]);
  }

  if (isset($_POST['clock_out'])) {
    $sql  = "
      UPDATE attendance
      SET time_out = GETDATE()
      WHERE employee_id = ? AND work_date = ? AND time_out IS NULL";
    sqlsrv_query($conn, $sql, [$employeeId, $today]);
  }

  header("Location: attendance.php"); // prevent resubmission
  exit;
}

// ── Fetch today’s record ─────────────────────────────
$row = sqlsrv_fetch_array(
  sqlsrv_query(
    $conn,
    "SELECT time_in, time_out
     FROM attendance
     WHERE employee_id = ? AND work_date = ?",
    [$employeeId, $today]
  ),
  SQLSRV_FETCH_ASSOC
);
$hasIn  = !empty($row['time_in']);
$hasOut = !empty($row['time_out']);

// ── Fetch full history ──────────────────────────────
$history = sqlsrv_query(
  $conn,
  "SELECT work_date, time_in, time_out
   FROM attendance
   WHERE employee_id = ?
   ORDER BY work_date DESC",
  [$employeeId]
);
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Procuratio – Attendance</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/navbar.css">
  <link rel="stylesheet" href="../assets/css/font.css">
  <link rel="stylesheet" href="../assets/css/em.css">

  <script>
    function attendanceFunction(){
      window.location.href = "attendance.php";
    }
    function payrollFunction(){
      window.location.href = "payroll.php";
    }
    function logoutpageFunction(){
      window.location.href = "../login.php";
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
        <h2 onClick="attendanceFunction()">Attendance</h2>
        <h2 onClick="payrollFunction()">Pay Roll</h2>
        <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
      </div>
    </div>

    <div class="hero">
      <h3>Attendance for <?= $today ?></h3>
    </div>

    <form method="post" class="attendance-form">
      <button type="submit" name="clock_in" <?= $hasIn  ? 'disabled' : '' ?>>Clock In</button>
      <button type="submit" name="clock_out"<?= (!$hasIn || $hasOut) ? ' disabled' : '' ?>>Clock Out</button>
    </form>

    <table class="attendance-table">
      <thead>
        <tr>
          <th>Date</th><th>Time In</th><th>Time Out</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($r = sqlsrv_fetch_array($history, SQLSRV_FETCH_ASSOC)): ?>
          <tr>
            <td><?= $r['work_date']->format('Y-m-d') ?></td>
            <td><?= $r['time_in']  ? $r['time_in']->format('H:i:s')  : '-' ?></td>
            <td><?= $r['time_out'] ? $r['time_out']->format('H:i:s') : '-' ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
