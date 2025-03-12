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

        <div class="application-table">
            <h2>Job Listings</h2>
            <table>
                <tr>
                    <th>Job Title</th>
                    <th>Description</th>
                    <th>Department</th>
                    <th>Salary</th>
                    <th>Status</th>
                    <th>Time Created</th>
                </tr>
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
                                job_title AS 'Job Title',
                                job_description AS 'Description',
                                department,
                                salary_range AS 'Salary',
                                status,
                                created_at AS 'Time Created'
                            FROM job_listings";

                    $result = sqlsrv_query($conn, $sql);
                    
                    if ($result != false) {
                        while ($rows = sqlsrv_fetch_array($result)) {
                            $timeCreated = $rows["Time Created"]->format('Y-m-d H:i:s');
                            echo "<tr>
                                    <td>" . htmlspecialchars($rows["Job Title"]) . "</td>
                                    <td>" . htmlspecialchars($rows["Description"]) . "</td>
                                    <td>" . htmlspecialchars($rows["department"]) . "</td>
                                    <td>" . htmlspecialchars($rows["Salary"]) . "</td>
                                    <td>" . htmlspecialchars($rows["status"]) . "</td>
                                    <td>" . $timeCreated . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No records found</td></tr>";
                    }
                ?>
            </table>


        </div>
    </div>
</body>

</html>