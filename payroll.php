<?php
session_start(); // Start the session

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

// ✅ Fix: Check if query executes properly
$sql = "SELECT
            u.name AS 'Employee Name',
            a.date,
            p.basic_salary,
            p.deductions,
            p.net_salary,
            p.pay_date
        FROM attendance a
        INNER JOIN payroll p ON a.employee_id = p.employee_id
        INNER JOIN users u ON a.employee_id = u.user_id
        WHERE u.user_type = 'Employee'";

$result = sqlsrv_query($conn, $sql);
if ($result === false) {
    die("Query failed: " . print_r(sqlsrv_errors(), true));
}

// Fetch transaction history
$sqlTransactionHistory = "SELECT
                                t.EM_NAME AS 'Employee Name',
                                t.PAY_TYPE AS 'Payment Type',
                                t.SALARY AS 'Salary',
                                t.DEDUCTIONS AS 'Deductions',
                                t.NET_SAL AS 'Net Salary',
                                t.PAY_DATE AS 'Pay Date',
                                t.receipt AS 'Receipt Number'
                            FROM [transaction] t
                            ORDER BY t.PAY_DATE DESC";
$transactionHistoryResult = sqlsrv_query($conn, $sqlTransactionHistory);

if ($transactionHistoryResult === false) {
    die("Query failed: " . print_r(sqlsrv_errors(), true));
}

// ✅ Payment Processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $salary = floatval($_POST["payment_amount"]);  // Convert salary to float
    $paymentType = $_POST["payment_type"];

    // Ensure salary is valid
    if ($salary <= 0) {
        echo "<script>alert('Invalid salary amount.');</script>";
    } else {
        $deductions = $salary * 0.10; // 10% deduction
        $netSalary = $salary - $deductions; // Compute net salary

        // Generate a 12-digit random number for receipt
        $receiptNumber = mt_rand(100000000000, 999999999999);

        // Insert query with receipt number
        $sqlInsert = "INSERT INTO [transaction] (EM_NAME, PAY_TYPE, SALARY, DEDUCTIONS, NET_SAL, PAY_DATE, receipt)
                      VALUES (?, ?, ?, ?, ?, GETDATE(), ?)";

        $params = [$user, $paymentType, $salary, $deductions, $netSalary, $receiptNumber];

        $stmt = sqlsrv_query($conn, $sqlInsert, $params);

        if ($stmt) {
            // Store the receipt number in the session
            $_SESSION['receipt_number'] = $receiptNumber;

            // Redirect to avoid resubmitting the form on page refresh
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "<script>alert('Error processing payment: " . print_r(sqlsrv_errors(), true) . "');</script>";
        }
    }
}

if (isset($_SESSION['receipt_number'])) {
    $receiptNumber = $_SESSION['receipt_number'];
    echo "<script>alert('Payment successfully recorded! Receipt Number: $receiptNumber');</script>";

    // Clear the session variable after displaying the alert
    unset($_SESSION['receipt_number']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio</title>
    <link rel="stylesheet" href="css\style.css">
    <link rel="stylesheet" href="css\navbar.css">
    <link rel="stylesheet" href="css\font.css">
    <link rel="stylesheet" href="css\hero.css">
    <link rel="stylesheet" href="css\em.css">

    <script>
        function logoutpageFunction(){
            window.location.href="login.php";
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
                <img class="logo" src="img\logo.png" alt="">
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

        <div class="application-table">
            <h2>Pay Employee</h2>
            <table>
                <tr>
                    <th>Employee Name</th>
                    <th>Date</th>
                    <th>Basic Salary</th>
                    <th>Deductions</th>
                    <th>Net Salary</th>
                    <th>Pay Date</th>
                </tr>
                <?php
                if ($result !== false) {
                    while ($rows = sqlsrv_fetch_array($result)) {
                        $date = $rows["date"] ? $rows["date"]->format('Y-m-d') : "N/A";
                        $pay_date = $rows["pay_date"] ? $rows["pay_date"]->format('Y-m-d') : "N/A";
                        echo "<tr>
                                <td>" . htmlspecialchars($rows["Employee Name"]) . "</td>
                                <td>" . $date . "</td>
                                <td>" . htmlspecialchars($rows["basic_salary"]) . "</td>
                                <td>" . htmlspecialchars($rows["deductions"]) . "</td>
                                <td>" . htmlspecialchars($rows["net_salary"]) . "</td>
                                <td>" . $pay_date . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>
            </table>
        </div>

        <div class="content">
            <form action="" method="post">
                <input type="text" name="user" id="user" placeholder="Employee Name" required>
                <br>
                <input type="number" name="payment_amount" id="payment_amount" placeholder="Salary Amount" required>
                <br>
                <select name="payment_type" id="payment_type" required>
                    <option value="" disabled selected>Select Payment Type</option>
                    <option value="Cash">Cash</option>
                    <option value="Online">Online Banking</option>
                </select>
                <br>
                <button class="post" type="submit">Pay Employee</button>
            </form>
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
                    $payDate = $transaction["Pay Date"] ? $transaction["Pay Date"]->format('Y-m-d') : "N/A";
                    echo "<tr>
                            <td>" . htmlspecialchars($transaction["Employee Name"]) . "</td>
                            <td>" . htmlspecialchars($transaction["Payment Type"]) . "</td>
                            <td>" . htmlspecialchars($transaction["Salary"]) . "</td>
                            <td>" . htmlspecialchars($transaction["Deductions"]) . "</td>
                            <td>" . htmlspecialchars($transaction["Net Salary"]) . "</td>
                            <td>" . $payDate . "</td>
                            <td>" . htmlspecialchars($transaction["Receipt Number"]) . "</td>
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
