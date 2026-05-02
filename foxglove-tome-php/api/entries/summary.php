<?php
declare(strict_types=1);

// *~*~*~*~*~*~* WEEKLY MOOD SUMMARY ENDPOINT *~*~*~*~*~*~*

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../auth/require_login.php';
require_once __DIR__ . '/../../models/JournalEntry.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
  // Get the logged-in user's ID from the session
    $userId = $_SESSION['user']['user_id'];

    // fetch the weekly mood summary for the user
    $journalEntry = new JournalEntry();
    $summary = $journalEntry->getWeeklyMoodSummary($userId);

    // Return the summary as JSON
    echo json_encode([
        "status" => "success",
        "data" => $summary
    ], JSON_PRETTY_PRINT);

    // use throwable for extra safety since this endpoint
} catch (Throwable $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}