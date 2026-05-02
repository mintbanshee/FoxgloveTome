<?php
declare(strict_types=1);

// *~*~*~*~*~*~* VIEW ALL ENTRIES ENDPOINT *~*~*~*~*~*~*

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../auth/require_login.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// get the user ID from the session
$userId = $_SESSION['user']['user_id'];

// fetch all entries from the database for the user
try {
    $query = "SELECT * FROM journalEntries 
    WHERE user_id = :user_id
    ORDER BY date_created DESC";

    $statement = $pdo->prepare($query);
    $statement->execute([
        'user_id' => $userId 
    ]);

    $entries = $statement->fetchAll(PDO::FETCH_ASSOC);

    // return the entries
    echo json_encode([
        "status" => "success",
        "data" => $entries
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}