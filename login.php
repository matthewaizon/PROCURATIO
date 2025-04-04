<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/em.css">
</head>

<body>
    <div class="container">
        <div class="nav">
            <img class="logo" src="img/logo.png" alt="">
        </div>

        <div class="content">
            <form id="loginForm">
                <h1>Login</h1>
                <input type="text" name="user" id="user" placeholder="Username" required>
                <br>
                <input type="password" name="pass" id="pass" placeholder="Password" required>
                <br>
                <button type="submit" name="submit">Login</button>
            </form>

            <p id="error" style="color:red;"></p>
        </div>
    </div>

    <script>
        function em_dashboardpageFunction(){
            window.location.href="employee page/em_dashboard.php";
        }

        // Simple front-end login validation (for demo purposes only)
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent form from submitting normally

            let usernameInput = document.getElementById("user").value;
            let passwordInput = document.getElementById("pass").value;

            // Predefined login credentials
            const username = "David Miller";
            const password = "hashed_password6";

            const username1 = "Sophia Black";
            const password1 = "hashed_password9";

            if (usernameInput === username && passwordInput === password) {
                window.location.href = "employee page/em_dashboard.php";
            }else if(usernameInput === username1 && passwordInput === password1){
                window.location.href = "dashboard.php";
            }else {
                document.getElementById("error").innerText = "Invalid username or password!";
            }
        });
    </script>
</body>

</html>
