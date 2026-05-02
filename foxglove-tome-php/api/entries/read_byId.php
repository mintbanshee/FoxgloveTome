<?php
declare(strict_types=1);

// *~*~*~*~*~*~* VIEW SPECIFIC ENTRY ENDPOINT *~*~*~*~*~*~*

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

// make sure the id is provided
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "No entry ID provided"
    ]);
    exit;
}

// get the entry ID and user ID from the session
$entryId = $_GET['id'];
$userId = $_SESSION['user']['user_id'];

// fetch the entry from the database by the entry id and user id
try {
    $query = "
        SELECT *
        FROM journalEntries
        WHERE entry_id = :entry_id
        AND user_id = :user_id
        LIMIT 1
    ";

    $statement = $pdo->prepare($query);

    $statement->execute([
        'entry_id' => $entryId,
        'user_id' => $userId
    ]);

    $entry = $statement->fetch(PDO::FETCH_ASSOC);

    // if no entry is found, return an error
    if (!$entry) {
        http_response_code(404);
        echo json_encode([
            "status" => "error",
            "message" => "Entry not found"
        ]);
        exit;
    }

    // return the entry 
    echo json_encode([
        "status" => "success",
        "data" => $entry
    ], JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}