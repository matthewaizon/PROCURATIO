<!DOCTYPE html>
<html lang = "en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio</title>
    <link rel="stylesheet" href="css\style.css">
    <link rel="stylesheet" href="css\navbar.css">
    <link rel="stylesheet" href="css\font.css">
    <link rel="stylesheet" href="css\hero.css">

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
                <h2 onClick="attenrollFunction()">Attendance & Payroll</h2>
                <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
            </div>
        </div>

        <?php
            $conn = mysqli_connect("localhost", "root", "root", "softeng_db");
            if ($conn->connect_error) {
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
            $result = $conn->query($sql);
            ?>

            <div class="application-table">
                <h2>Employee Attendance & Payroll</h2>
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
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["Employee Name"]) . "</td>
                                    <td>" . htmlspecialchars($row["date"]) . "</td>
                                    <td>" . htmlspecialchars($row["time_in"]) . "</td>
                                    <td>" . htmlspecialchars($row["time_out"]) . "</td>
                                    <td>" . htmlspecialchars($row["basic_salary"]) . "</td>
                                    <td>" . htmlspecialchars($row["deductions"]) . "</td>
                                    <td>" . htmlspecialchars($row["net_salary"]) . "</td>
                                    <td>" . htmlspecialchars($row["pay_date"]) . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No records found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </table>
            </div>
    </div>
</body>

</html>
