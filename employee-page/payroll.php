<?php
session_start();

$name = $_SESSION['name'];
$serverName = "DESKTOP-FQOOPV8\\SQLEXPRESS";
$connectionOptions = [
    "Database" => "procuratio",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

// Handle dropdown filter
$selectedMonth = isset($_GET['month']) ? intval($_GET['month']) : null;

if ($selectedMonth) {
    $sqlTransactionHistory = "SELECT * FROM [transaction] WHERE EM_NAME = ? AND MONTH(PAY_DATE) = ? ORDER BY PAY_DATE DESC";
    $param = [$name, $selectedMonth];
} else {
    $sqlTransactionHistory = "SELECT * FROM [transaction] WHERE EM_NAME = ? ORDER BY PAY_DATE DESC";
    $param = [$name];
}

$transactionHistoryResult = sqlsrv_query($conn, $sqlTransactionHistory, $param);
if ($transactionHistoryResult === false) {
    die("Query failed: " . print_r(sqlsrv_errors(), true));
}
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
            window.location.href="../applicant-page/em_dashboard.php";
        }
        function attendanceFunction(){
            window.location.href = "attendance.php";
        }
        function homepageFunction(){
        window.location.href="dashboard.php";
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
                <img class="logo" src="assets/img/logo.png" alt="Logo">
            </div>
            <div class="nav-right">
                <h2 onClick="homepageFunction()">Dashboard</h2>
                <h2 onClick="attendanceFunction()">Attendance</h2>
                <h2 onClick="payrollFunction()">Pay Roll</h2>
                <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
            </div>
        </div>

        <div class="application-table">
            <h2>Transaction History</h2>

            <!-- Month Dropdown Filter -->
            <form method="GET" style="margin-bottom: 20px;">
                <label for="month"><h2>Filter by Month:</h2></label>
                <select name="month" id="month" onchange="this.form.submit()">
                    <option value="">All Months</option>
                    <?php
                        $monthQuery = "SELECT DISTINCT MONTH(PAY_DATE) AS month FROM [transaction] WHERE EM_NAME = ?";
                        $monthResult = sqlsrv_query($conn, $monthQuery, [$name]);

                        while ($row = sqlsrv_fetch_array($monthResult, SQLSRV_FETCH_ASSOC)) {
                            $monthNum = $row['month'];
                            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
                            $selected = ($selectedMonth == $monthNum) ? "selected" : "";
                            echo "<option value='$monthNum' $selected>$monthName</option>";
                        }
                    ?>
                </select>
            </form>

            <table>
                <tr>
                    <th>Employee Name</th>
                    <th>Payment Type</th>
                    <th>Salary</th>
                    <th>Deductions</th>
                    <th>Net Salary</th>
                    <th>Pay Date</th>
                    <th>Receipt Number</th>
                    <th>Actions</th>
                </tr>

                <?php
                while ($transaction = sqlsrv_fetch_array($transactionHistoryResult, SQLSRV_FETCH_ASSOC)) {
                    $payDate = $transaction["PAY_DATE"] ? $transaction["PAY_DATE"]->format('Y-m-d') : 'N/A';

                    echo "<tr>
                        <td>" . htmlspecialchars($transaction["EM_NAME"]) . "</td>
                        <td>" . htmlspecialchars($transaction["PAY_TYPE"]) . "</td>
                        <td>" . htmlspecialchars($transaction["SALARY"]) . "</td>
                        <td>" . htmlspecialchars($transaction["DEDUCTIONS"]) . "</td>
                        <td>" . htmlspecialchars($transaction["NET_SAL"]) . "</td>
                        <td>" . $payDate . "</td>
                        <td>" . htmlspecialchars($transaction["receipt"]) . "</td>
                        <td>
                            <a href='payroll-receipt.php?receipt=" . urlencode($transaction["receipt"]) . "' target='_blank'>View</a> |
                            <a href='payroll-receipt.php?receipt=" . urlencode($transaction["receipt"]) . "&download=1' target='_blank'>Download</a>
                        </td>
                    </tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
