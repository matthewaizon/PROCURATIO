<?php
$serverName        = "DESKTOP-FQOOPV8\\SQLEXPRESS";
$connectionOptions = [
    "Database" => "procuratio",
    "Uid"      => "",
    "PWD"      => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

$sql = "
    SELECT
        A.first_name + ' ' + A.last_name       AS full_name,
        A.resume_link                          AS resume_link,
        A.application_date                     AS application_date,
        A.status                               AS status
    FROM applicant AS A
    ORDER BY A.application_date DESC
";

$result = sqlsrv_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio • Applications</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/hero.css">

    <script>
      function logoutpageFunction(){ window.location.href="login.php"; }
      function manageempFunction(){ window.location.href="manage_emp.php"; }
      function applicationpageFunction(){ window.location.href="em_application.php"; }
      function homepageFunction(){ window.location.href="dashboard.php"; }
      function ListingFunction(){ window.location.href="joblistings.php"; }
      function attenrollFunction(){ window.location.href="attenroll.php"; }
      function payrollFunction(){ window.location.href="payroll.php"; }
    </script>
</head>
<body>
  <div class="container">
    <div class="nav">
      <div class="nav-left">
        <img class="logo" src="img/logo.png" alt="Procuratio">
      </div>
      <div class="nav-right">
        <h2 onclick="homepageFunction()">Home</h2>
        <h2 onclick="manageempFunction()">Manage Employee</h2>
        <h2 onclick="applicationpageFunction()">Application</h2>
        <h2 onclick="ListingFunction()">Job Listings</h2>
        <h2 onclick="attenrollFunction()">Attendance</h2>
        <h2 onclick="payrollFunction()">Pay Roll</h2>
        <h2 class="border" onclick="logoutpageFunction()">Logout</h2>
      </div>
    </div>

    <div class="application-table">
      <h2>Applications</h2>
      <table>
        <tr>
          <th>Name</th>
          <th>Resume</th>
          <th>Application Date</th>
          <th>Status</th>
        </tr>

        <?php
        if ($result !== false) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $rawLink   = $row['resume_link'];
                $filename  = basename($rawLink);
                $resumeUrl = 'employee-page/uploads/' . rawurlencode($filename); // Use the correct folder structure
                $diskPath  = __DIR__ . '/employee-page/uploads/' . $filename; // Corrected path for XAMPP server

                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['full_name']) . '</td>';

                if (file_exists($diskPath)) {
                    echo '<td><a href="' . htmlspecialchars($resumeUrl) . '" target="_blank">View Resume</a></td>';
                } else {
                    echo '<td style="color:red;">File not found: ' . htmlspecialchars($diskPath) . '</td>';
                }

                $dt = $row['application_date'];
                if ($dt instanceof DateTime) {
                    $dateString = $dt->format('Y-m-d H:i:s');
                } else {
                    $dateString = '—';
                }
                echo '<td>' . $dateString . '</td>';

                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4">No records found.</td></tr>';
        }

        sqlsrv_close($conn);
        ?>
      </table>
    </div>
  </div>
</body>
</html>
