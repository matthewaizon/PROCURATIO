<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/font.css">
    <link rel="stylesheet" href="assets/css/em.css">
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
            <h2>Employees</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date Hired</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php
                $serverName = "DESKTOP-FQOOPV8\\SQLEXPRESS";
                $connectionOptions = [
                    "Database" => "procuratio",
                    "Uid"      => "",
                    "PWD"      => ""
                ];
                $conn = sqlsrv_connect($serverName, $connectionOptions);
                if ($conn === false) {
                    die("Connection failed: " . print_r(sqlsrv_errors(), true));
                }

                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_status"])) {
                    $employee_id = $_POST["employee_id"];
                    $new_status = $_POST["status"];

                    $updateSql = "UPDATE employees SET status = ? WHERE employee_id = ?";
                    $params = [$new_status, $employee_id];
                    $stmt = sqlsrv_query($conn, $updateSql, $params);

                    if ($stmt === false) {
                        die("Update failed: " . print_r(sqlsrv_errors(), true));
                    } else {
                        echo "<script>window.location.href=window.location.href;</script>";
                    }
                }

                $sql = "SELECT
                            U.user_id,
                            U.name AS Name,
                            U.email AS Email,
                            E.date_hired AS DateHired,
                            E.status AS STATUS
                        FROM employees AS E
                        INNER JOIN users AS U ON E.employee_id = U.user_id";
                $result = sqlsrv_query($conn, $sql);

                if ($result !== false) {
                    while ($rows = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        $dateHired = $rows["DateHired"] instanceof DateTime
                            ? $rows["DateHired"]->format('Y-m-d H:i:s')
                            : '—';

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($rows["Name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($rows["Email"]) . "</td>";
                        echo "<td>" . $dateHired . "</td>";
                        echo "<td>" . htmlspecialchars($rows["STATUS"]) . "</td>";

                        // Form for updating status
                        echo "<td>
                            <form method='POST'>
                                <input type='hidden' name='employee_id' value='" . $rows["user_id"] . "'>
                                <select name='status'>
                                    <option value='Active'" . ($rows["STATUS"] == "Active" ? " selected" : "") . ">Active</option>
                                    <option value='Inactive'" . ($rows["STATUS"] == "Inactive" ? " selected" : "") . ">Inactive</option>
                                    <option value='Terminated'" . ($rows["STATUS"] == "Terminated" ? " selected" : "") . ">Terminated</option>
                                </select>
                                <button class=\"up\" type='submit' name='update_status'>Update</button>
                            </form>
                        </td>";                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found</td></tr>";
                }

                sqlsrv_close($conn);
                ?>
            </table>
        </div>
    </div>
</body>
</html>
