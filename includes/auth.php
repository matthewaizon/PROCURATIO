<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: /login.php');
        exit();
    }

    // Optional: block access to certain roles
    function requireRole($role) {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== $role) {
            header('Location: /login.php');
            exit();
        }
    }
    ?>