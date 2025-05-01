<!DOCTYPE html>
<html lang = "en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio</title>
    <link rel="stylesheet" href="..\css\style.css">
    <link rel="stylesheet" href="..\css\navbar.css">
    <link rel="stylesheet" href="..\css\font.css">
    <link rel="stylesheet" href="..\css\hero.css">
    <link rel="stylesheet" href="..\css\em.css">

    <script>
        function loginpageFunction(){
            window.location.href="../login.php";
        }
        function applicationpageFunction(){
            window.location.href="em_application.php";
        }
        function homepageFunction(){
            window.location.href="em_dashboard.php";
        }  
        function contactpageFunction(){
            window.location.href="em_contact.php";
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="nav">
            <div class="nav-left">
                <img class="logo" src="..\img\logo.png" alt="">

            </div>
            
            <div class="nav-right">
                <h2 onClick="homepageFunction()">Home</h2>
                <h2 onClick="applicationpageFunction()">Application</h2>
                <h2 onClick="contactpageFunction()">Contact Us</h2>
                <h2 class="border" onClick="loginpageFunction()">Login</h2>
            </div>
        </div>

        <div class="content">
            <form action="">
                <h1>Apply Now!</h1>
                <input type="text" placeholder="First Name">
                <input type="text" placeholder="Last Name">
                <input type="email" placeholder="Email">
                <input type="text" placeholder="Phone Number">
                <button class="post">Upload Resume</button>
                <button class="post">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>