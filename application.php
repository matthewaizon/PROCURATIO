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
            window.location.href = "logout.php";
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
            <h2>Applications</h2>
                <table>
            <tr>
                    <th>Name</th>
                    <th>Resume</th>
                    <th>Application Date</th>
                    <th>Status</th>
                </tr>
                    <?php
                    $serverName = "BELEH\SQLEXPRESS"; 
                    $connectionOptions = [
                        "Database" => "procuratio",
                        "Uid" => "",
                        "PWD" => ""
                    ];

                    $conn=sqlsrv_connect($serverName, $connectionOptions);

                    if ($conn == false) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT 
                                U.name AS 'Name',
                                A.resume_link AS 'Resume',
                                A.applied_at AS 'Application Date',
                                A.status AS 'Status'
                            FROM applicants AS A
                            INNER JOIN users AS U ON A.applicant_id = U.user_id;";

                    $result = sqlsrv_query($conn, $sql);

                    if ($result != false) {
                        while ($rows = sqlsrv_fetch_array($result)) {
                            $applicationDate = $rows["Application Date"]->format('Y-m-d H:i:s');
                            echo "<tr>
                                    <td>" . $rows["Name"] . "</td>
                                    <td>" . $rows["Resume"] . "</td>
                                    <td>" . $applicationDate . "</td>
                                    <td>" . $rows["Status"] . "</td>
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
