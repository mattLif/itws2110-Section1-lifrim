<?php
    $host = "localhost";
    $dbname = "ITWS2110-Fall2025-lifrim-Quiz2";
    $user = "root";
    $pass = "";

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        die("Database connection failed.");
    }
