<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted</title>
    <link rel="stylesheet" href="..\css\style.css">
    <link rel="stylesheet" href="..\css\navbar.css">
    <link rel="stylesheet" href="..\css\font.css">
    <link rel="stylesheet" href="..\css\hero.css">
    <link rel="stylesheet" href="..\css\em.css">
</head>

<body>
    <div class="container">
        <div class="nav">
            <div class="nav-left">
                <img class="logo" src="..\img\logo.png" alt="">
            </div>
            <div class="nav-right">
                <h2 onclick="window.location.href='em_dashboard.php'">Home</h2>
                <h2 onclick="window.location.href='em_application.php'">Application</h2>
                <h2 onclick="window.location.href='em_contact.php'">Contact Us</h2>
                <h2 class="border" onclick="window.location.href='../login.php'">Logout</h2>
            </div>
        </div>

        <div class="success-message">
            <h1>Thank You!</h1>
            <p>Your application has been submitted successfully.</p>
            <a href="em_application.php">Apply Again</a>
        </div>
    </div>
</body>
</html>
