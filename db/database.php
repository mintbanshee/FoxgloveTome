<?php

declare(strict_types=1); 

$dsn = 'mysql:host=localhost;dbname=foxglove_tome;charset=utf8mb4';
$username = 'root';
$password = ''; 

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
    exit;
}