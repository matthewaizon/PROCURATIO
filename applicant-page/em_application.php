<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serverName = "DESKTOP-FQOOPV8\\SQLEXPRESS";
    $connectionOptions = [
        "Database" => "procuratio",
        "Uid" => "",
        "PWD" => ""
    ];

    $errors = [];

    if (empty($_POST['first_name'])) $errors[] = "First name is required.";
    if (empty($_POST['last_name'])) $errors[] = "Last name is required.";
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($_POST['phone_number']) || !ctype_digit($_POST['phone_number'])) {
        $errors[] = "Phone number must be digits only.";
    }
    if (!isset($_FILES['resume_file']) || $_FILES['resume_file']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "A valid resume file is required.";
    }

    if (empty($errors)) {
        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if (!$conn) {
            die("<p style='color:red;'>Connection failed: " . print_r(sqlsrv_errors(), true) . "</p>");
        }

        $first_name = htmlspecialchars($_POST['first_name']);
        $last_name = htmlspecialchars($_POST['last_name']);
        $email = htmlspecialchars($_POST['email']);
        $phone_number = intval($_POST['phone_number']);
        $status = "Pending";
        $application_date = date('Y-m-d H:i:s');

        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $resume_name = basename($_FILES["resume_file"]["name"]);
        $resume_path = $upload_dir . time() . "_" . $resume_name;

        if (!move_uploaded_file($_FILES["resume_file"]["tmp_name"], $resume_path)) {
            die("<p style='color:red;'>Failed to upload resume.</p>");
        }

        $sql = "INSERT INTO applicant (first_name, last_name, email, phone_number, resume_link, status, application_date)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$first_name, $last_name, $email, $phone_number, $resume_path, $status, $application_date];

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            echo "<p style='color:red;'>Database error: " . print_r(sqlsrv_errors(), true) . "</p>";
            exit;
        }

        sqlsrv_close($conn);

        header("Location: sucess.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang = "en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procuratio</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/font.css">
    <link rel="stylesheet" href="../assets/css/em.css">
    <link rel="stylesheet" href="../assets/css/hero.css">


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
                <img class="logo" src="../assets/img/logo.png" alt="">

            </div>
            
            <div class="nav-right">
                <h2 onClick="homepageFunction()">Home</h2>
                <h2 onClick="applicationpageFunction()">Application</h2>
                <h2 onClick="contactpageFunction()">Contact Us</h2>
                <h2 class="border" onClick="loginpageFunction()">Logout</h2>
            </div>
        </div>

        <div class="content">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <h1>Apply Now!</h1>
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
                <input type="file" name="resume_file" accept=".pdf,.doc,.docx" required>
                <button type="submit" class="post">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>