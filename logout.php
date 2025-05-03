<?php
session_start();

// Clear all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Redirect the user back to the login page
header("Location: login.php");
exit();
?>
