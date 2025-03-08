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


        <div class="hero">
            <h3>EMPOWERING HR: Streamline Applications, Perfect Interviews. Accelerate Onboarding.</h3>
            <button>Click Me</button>
        </div>
    </div>
</body>

</html>