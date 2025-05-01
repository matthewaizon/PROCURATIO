<!DOCTYPE html>
<html lang = "en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio</title>
    <link rel="stylesheet" href="css\style.css">
    <link rel="stylesheet" href="css\navbar.css">
    <link rel="stylesheet" href="css\font.css">
    <link rel="stylesheet" href="css\em.css">
</head>

<script>
    function dashboardpageFunction(){
            window.location.href="dashboard.php";
        }
    function em_dashboardpageFunction(){
            window.location.href="employee page/em_dashboard.php";
        }
</script>

<body>
    
    <div class="container">
        <div class="nav">
                <img class="logo" src="img\logo.png" alt="">
                <h2 class="border" onClick="em_dashboardpageFunction()">Procuratio</h2>
        </div>

        <div class="content">
            <form action="dashboard.php">
                <h1>Login</h1>
                <input type="text" name="" id="" placeholder="Username">
                <br>
                <input type="password" name="" id="" placeholder="Password">
                <br>
                <button>Login</button>
            </form>
        </div>
    </div>
</body>

