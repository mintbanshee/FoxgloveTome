<?php
declare(strict_types=1);

ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

require_once __DIR__ . '/../../config/app.php';

try {
    $query = "SELECT * FROM journalEntries ORDER BY date_created DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

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