<?php
$host = 'localhost';
$db = 'softeng_db';
$user = 'root';
$pass = ''; // or your password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
