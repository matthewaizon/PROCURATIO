<?php
$serverName = "DESKTOP-FQOOPV8\\SQLEXPRESS";
$connectionOptions = [
    "Database" => "procuratio",
    "Uid" => "",       
    "PWD" => ""        
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($name) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE [name] = ? AND password_hash = ?";
        $params = [$name, $password];
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($user) {
            if ($name == $user['name'] && $password == $user['password_hash']){
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['name'] = $user['name'];

                if ($user['user_type'] === 'Employee') {
                    header('Location: employee-page/payroll.php');
                } elseif ($user['user_type'] === 'Admin') {
                    header('Location: dashboard.php');
                } else {
                    $error = 'Unsupported role type.';
                }
                exit();
            } else {
                $error = 'Invalid name or password!';
            }
        } else {
            $error = 'Invalid name or password!';
        }
    } else {
        $error = 'Please fill in both fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/font.css">
    <link rel="stylesheet" href="assets/css/em.css">
</head>
<body>
    <div class="container">
        <div class="nav">
            <div class="nav-left">
                <img class="logo" src="assets/img/logo.png" alt="Procuratio Logo">
            </div>
            <div class="nav-right">
                <h2 class="border">Procuratio</h2>
            </div>
        </div>

        <div class="content">
            <form id="loginForm" method="POST" action="login.php">
                <h1>Login</h1>
                <input type="text" name="name" id="user" placeholder="Username (Name)" required><br>
                <input type="password" name="password" id="pass" placeholder="Password" required><br>
                <button type="submit" name="submit">Login</button>
            </form>
            <?php if (!empty($error)): ?>
                <p id="error" style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
