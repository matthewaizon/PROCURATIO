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
        function applicationpageFunction(){
            window.location.href="application.php";
        }
        function homepageFunction(){
            window.location.href="dashboard.php";
        }  
        function shiftpageFunction(){
            window.location.href="shift.php";
        }  
        function requestpageFunction(){
            window.location.href="request.php";
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
                <h2 onClick="applicationpageFunction()">Application</h2>
                <h2 onClick="shiftpageFunction()">Shift</h2>
                <h2 onClick="requestpageFunction()">Request</h2>
                <h2 class="border" onClick="logoutpageFunction()">Logout</h2>
            </div>
        </div>

        <div class="application-table">
                <table>
            <tr>
                    <th>Name</th>
                    <th>Resume</th>
                    <th>Application Date</th>
                    <th>STATUS</th>
                </tr>
                    <?php
                    $conn = mysqli_connect("localhost", "root", "root", "softeng_db");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT
                                U.NAME AS 'Name',
                                A.resume_link AS 'Resume',
                                A.applied_at AS 'Application date',
                                A.STATUS AS 'STATUS'
                            FROM
                                applicants AS A
                                INNER JOIN users AS U ON A.applicant_id = U.user_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["Name"] . "</td>
                                    <td>" . $row["Resume"] . "</td>
                                    <td>" . $row["Application date"] . "</td>
                                    <td>" . $row["STATUS"] . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No results found</td></tr>";
                    }
                    $conn->close();
                ?>

            </table>


        </div>
    </div>
</body>

</html>
