<?php

declare(strict_types=1); 

// Development database credentials (local only)
// Production credentials will be stored securely

$dsn = 'mysql:host=localhost;dbname=foxglove_tome;charset=utf8mb4';
$username = 'root';
$password = ''; 

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed.');
    exit;
}