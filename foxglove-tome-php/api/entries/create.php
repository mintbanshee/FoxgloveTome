<?php
declare(strict_types=1);

// *~*~*~*~*~*~* CREATE ENTRY ENDPOINT *~*~*~*~*~*~*

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

// get the input data from the new entry form
$data = json_decode(file_get_contents("php://input"), true);

// check if the input data was received
if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "No data received"
    ]);
    exit;
}

// get the user ID from the session
$userId = $_SESSION['user']['user_id'];

// trim and validate the input fields
$title = trim($data['title'] ?? '');
$content = trim($data['content'] ?? '');
$mood = trim($data['mood'] ?? '');
$moodCategory = trim($data['mood_category'] ?? '');
$dateCreated = date('Y-m-d H:i:s');
$dateUpdated = date('Y-m-d H:i:s');

// check if any required fields are missing
if (!$title || !$content || !$moodCategory || !$mood) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "It looks like something is missing. Please fill in all fields before saving."
    ]);
    exit;
}

// insert the new entry into the database
try {
    $query = "
        INSERT INTO journalEntries (user_id, title, content, mood, mood_category, date_created, date_updated)
        VALUES (:user_id, :title, :content, :mood, :mood_category, :date_created, :date_updated)
    ";

    $statement = $pdo->prepare($query);

    $statement->execute([
        'user_id' => $userId,
        'title' => $title,
        'content' => $content,
        'mood' => $mood,
        'mood_category' => $moodCategory,
        'date_created' => $dateCreated,
        'date_updated' => $dateUpdated
    ]);


    // successfully created the entry
    echo json_encode([
        "status" => "success",
        "message" => "Entry created"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}