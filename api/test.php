<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

header('Content-Type: application/json');

echo json_encode([
    "status" => "success",
    "message" => "Foxglove API is alive 🌿"
], JSON_PRETTY_PRINT);