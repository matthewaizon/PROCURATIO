<?php
$receiptId = $_GET['receipt'] ?? null;
if (!$receiptId) {
    die("Missing receipt number.");
}

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

$sql = "SELECT * FROM [transaction] WHERE receipt = ?";
$stmt = sqlsrv_query($conn, $sql, [$receiptId]);

$data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if (!$data) {
    die("Receipt not found.");
}

$payDate = $data["PAY_DATE"] ? $data["PAY_DATE"]->format('F d, Y') : "N/A";
$period = date("F 1–15, Y", strtotime($payDate)); // Optional logic
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Payroll Receipt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/receipt.css">
</head>
<body>

<div class="receipt">
    <header>
        <h1>Procuratio Payroll</h1>
        <p>Procuratio Group of Companies</p>
        <p>Dasmariñas City, Cavite, Philippines</p>
    </header>

    <div class="section-title">Employee Details</div>
    <div class="details">
        <div><span>Name</span><span><?= htmlspecialchars($data["EM_NAME"]) ?></span></div>
        <div><span>Receipt #</span><span><?= htmlspecialchars($data["receipt"]) ?></span></div>
        <div><span>Pay Type</span><span><?= htmlspecialchars($data["PAY_TYPE"]) ?></span></div>
        <div><span>Period</span><span><?= $period ?></span></div>
        <div><span>Pay Date</span><span><?= $payDate ?></span></div>
    </div>

    <div class="section-title">Earnings &amp; Deductions</div>
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount (₱)</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Basic Salary</td><td><?= number_format($data["SALARY"], 2) ?></td></tr>
            <tr><td>Deductions</td><td>-<?= number_format($data["DEDUCTIONS"], 2) ?></td></tr>
        </tbody>
    </table>

    <div class="totals">
        <div><span>Gross Pay</span><span><?= number_format($data["SALARY"], 2) ?></span></div>
        <div><span>Total Deductions</span><span><?= number_format($data["DEDUCTIONS"], 2) ?></span></div>
    </div>
    <div class="net-pay">
        <span>Net Pay</span>
        <span>₱<?= number_format($data["NET_SAL"], 2) ?></span>
    </div>

    <div class="signature">
        <p>Authorized Signature</p>
        <span>_________________________</span>
    </div>
</div>

<script>
    if (new URLSearchParams(window.location.search).has("download")) {
        window.print();
    }
</script>
</body>
</html>
