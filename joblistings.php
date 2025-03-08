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
                $conn = mysqli_connect("localhost", "root", "root", "softeng_db");
                if ($conn->connect_error) {
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
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["Job Title"]) . "</td>
                                <td>" . htmlspecialchars($row["Description"]) . "</td>
                                <td>" . htmlspecialchars($row["department"]) . "</td>
                                <td>" . htmlspecialchars($row["Salary"]) . "</td>
                                <td>" . htmlspecialchars($row["status"]) . "</td>
                                <td>" . htmlspecialchars($row["Time Created"]) . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No job listings found</td></tr>";
                }
                $conn->close();
                ?>
            </table>


        </div>
    </div>
</body>

</html>