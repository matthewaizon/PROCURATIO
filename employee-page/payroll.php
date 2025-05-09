<?php
session_start(); // Start the session

$name = $_SESSION['name'];
$serverName = "DESKTOP-FQOOPV8\SQLEXPRESS";
$connectionOptions = [
    "Database" => "procuratio",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

$sqlTransactionHistory = "SELECT * FROM [transaction] WHERE EM_NAME = ?";
$param = [$name];
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
            window.location.href="../login.php";
        }
        function manageempFunction(){
            window.location.href="manage_emp.php";
        }
        function applicationpageFunction(){
            window.location.href="application.php";
        }
        function homepageFunction(){
            window.location.href="dashboard.php";
        }  
        function ListingFunction(){
            window.location.href="joblistings.php";
        }  
        function attenrollFunction(){
            window.location.href="attenroll.php";
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
                <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
            </div>
        </div>

        <div class="application-table">
            <h2>Transaction History</h2>

            <table>
                <tr>
                    <th>Employee Name</th>
                    <th>Payment Type</th>
                    <th>Salary</th>
                    <th>Deductions</th>
                    <th>Net Salary</th>
                    <th>Pay Date</th>
                    <th>Receipt Number</th>
                </tr>

                <?php
                    if ($transactionHistoryResult !== false && sqlsrv_has_rows($transactionHistoryResult)) {  // Check if there are rows
                        while ($transaction = sqlsrv_fetch_array($transactionHistoryResult)) {
                            $payDate = $transaction["PAY_DATE"] ? $transaction["PAY_DATE"]->format('Y-m-d') : "N/A";
                            echo "<tr>
                                    <td>" . htmlspecialchars($transaction["EM_NAME"]) . "</td>
                                    <td>" . htmlspecialchars($transaction["PAY_TYPE"]) . "</td>
                                    <td>" . htmlspecialchars($transaction["SALARY"]) . "</td>
                                    <td>" . htmlspecialchars($transaction["DEDUCTIONS"]) . "</td>
                                    <td>" . htmlspecialchars($transaction["NET_SAL"]) . "</td>
                                    <td>" . $payDate . "</td>
                                    <td>" . htmlspecialchars($transaction["receipt"]) . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No transaction history found</td></tr>";  // Display message if no records
                    }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
