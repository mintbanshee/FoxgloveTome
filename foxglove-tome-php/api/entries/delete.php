<?php
declare(strict_types=1);

// *~*~*~*~*~*~* DELETE ENTRY ENDPOINT *~*~*~*~*~*~*

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
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

// check if the entry ID is provided
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "No entry ID provided"
    ]);
    exit;
}

// get the entry id and user id 
$entryId = $_GET['id'];
$userId = $_SESSION['user']['user_id'];

// delete the entry from the database
try {
    $query = "
        DELETE FROM journalEntries
        WHERE entry_id = :entry_id
        AND user_id = :user_id
    ";

    $statement = $pdo->prepare($query);
    $statement->execute([
        'entry_id' => $entryId,
        'user_id' => $userId
    ]);

    // successfully deleted the entry
    echo json_encode([
        "status" => "success",
        "message" => "Entry deleted"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}