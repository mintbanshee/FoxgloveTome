<?php

declare(strict_types=1); 

// *~*~*~*~*~*~* DATABASE CONNECTION *~*~*~*~*~*~*

// database connection parameters
$dsn = 'mysql:host=localhost;dbname=foxglove_tome;charset=utf8mb4';
$username = 'root';
$password = ''; 

// create a PDO instance for database connection
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed.');
}