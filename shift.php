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
                <h2 onClick="homepageFunction()">Home</h2>
                <h2 onClick="applicationpageFunction()">Application</h2>
                <h2 onClick="shiftpageFunction()">Shift</h2>
                <h2 onClick="requestpageFunction()">Request</h2>
            </div>
            
            <div class="nav-right">
                <h2 onClick="logoutpageFunction()">Logout</h2>
            </div>
        </div>

        <div class="application">
        </div>
    </div>
</body>

</html>