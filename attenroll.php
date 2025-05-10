<!DOCTYPE html>
<html lang = "en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/font.css">
    <link rel="stylesheet" href="assets/css/hero.css">


    <script>
        function logoutpageFunction(){
            window.location.href="applicant-page/em_dashboard.php";
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
                <h2 onClick="homepageFunction()">Home</h2>
                <h2 onClick="manageempFunction()">Manage Employee</h2>
                <h2 onClick="applicationpageFunction()">Application</h2>
                <h2 onClick="ListingFunction()">Job Listings</h2>
                <h2 onClick="attenrollFunction()">Attendance</h2>
                <h2 onClick="payrollFunction()">Pay Roll</h2>
                <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
            </div>
        </div>

        <?php
            $serverName="DESKTOP-FQOOPV8\SQLEXPRESS";
            $connectionOptions=[
                "Database"=>"procuratio",
                "Uid"=>"",
                "PWD"=>""
            ];

            $conn=sqlsrv_connect($serverName, $connectionOptions);

            if ($conn == false) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT 
                        u.name AS 'Employee Name',
                        a.date, 
                        a.time_in, 
                        a.time_out, 
                        p.basic_salary, 
                        p.deductions, 
                        p.net_salary, 
                        p.pay_date
                    FROM attendance a
                    INNER JOIN payroll p ON a.employee_id = p.employee_id
                    INNER JOIN users u ON a.employee_id = u.user_id
                    WHERE u.user_type = 'Employee'";
            $result = sqlsrv_query($conn, $sql);
            ?>

            <div class="application-table">
                <h2>Employee Attendance</h2>
                <table>
                    <tr>
                        <th>Employee Name</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Basic Salary</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                        <th>Pay Date</th>
                    </tr>
                    <?php
                    if ($result != false) {
                        while ($rows = sqlsrv_fetch_array($result)) {
                            $date = $rows["date"]->format('Y-m-d');
                            $pay_date = $rows["pay_date"]->format('Y-m-d');
                            $time_in = $rows["time_in"]->format('H:i:s');
                            $time_out = $rows["time_out"]->format('H:i:s');
                            echo "<tr>
                                    <td>" . htmlspecialchars($rows["Employee Name"]) . "</td>
                                    <td>" . $date . "</td>
                                    <td>" . $time_in . "</td>
                                    <td>" . $time_out . "</td>
                                    <td>" . htmlspecialchars($rows["basic_salary"]) . "</td>
                                    <td>" . htmlspecialchars($rows["deductions"]) . "</td>
                                    <td>" . htmlspecialchars($rows["net_salary"]) . "</td>
                                    <td>" . $pay_date . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No records found</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <button class="post" onClick="payrollFunction()">Pay Employee</button>
    </div>
</body>

</html>
