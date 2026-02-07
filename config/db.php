<?php
$dsn = 'mysql:host=localhost;dbname=foxglove_tome;charset=utf8mb4'; // connect to the database
$username = 'root'; // will change next week 
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit;
}
