<?php
declare(strict_types=1);

// *~*~*~*~*~*~* EDIT ENTRY ENDPOINT *~*~*~*~*~*~*

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

// Check if entry ID is provided
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "No entry ID provided"
    ]);
    exit;
}

// Get the JSON data from the edit entry form
$data = json_decode(file_get_contents("php://input"), true);

// Make sure the data was received
if (!$data) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "No data received"
    ]);
    exit;
}

// Get the entry ID and user ID
$entryId = $_GET['id'];
$userId = $_SESSION['user']['user_id'];

// Validate the input data
$title = trim($data['title'] ?? '');
$content = trim($data['content'] ?? '');
$mood = trim($data['mood'] ?? '');
$moodCategory = trim($data['mood_category'] ?? '');

// Check if any required fields are missing
if (!$title || !$content || !$mood || !$moodCategory) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "It looks like something is missing. Please fill in all fields before saving."
    ]);
    exit;
}

// Update the entry in the database
try {
    $query = "
        UPDATE journalEntries
        SET title = :title,
            content = :content,
            mood = :mood,
            mood_category = :mood_category,
            date_updated = NOW()
        WHERE entry_id = :entry_id
        AND user_id = :user_id
    ";

    $statement = $pdo->prepare($query);

    $statement->execute([
        'title' => $title,
        'content' => $content,
        'mood' => $mood,
        'mood_category' => $moodCategory,
        'entry_id' => $entryId,
        'user_id' => $userId
    ]);

    // Successfully updated the entry 
    echo json_encode([
        "status" => "success",
        "message" => "Entry updated"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}