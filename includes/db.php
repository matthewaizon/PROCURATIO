<?php
    $host = 'DESKTOP-FQOOPV8\SQLEXPRESS';     // or your host
    $dbname = 'procuratio';
    $username = '';      // update if your MySQL user is different
    $password = '';          // update if you have a password

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
?>