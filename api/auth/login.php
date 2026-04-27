<?php
declare(strict_types=1);

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../config/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $input = json_decode(file_get_contents("php://input"), true);

    $email = strtolower(trim($input['email'] ?? ''));
    $password = $input['password'] ?? '';

    if ($email === '' || $password === '') {
        echo json_encode([
            "status" => "error",
            "message" => "Email and password are required."
        ]);
        exit;
    }

    // SAME QUERY AS YOUR CONTROLLER
    $stmt = $pdo->prepare("
        SELECT user_id, email, password_hash, role, first_name, last_name, username
        FROM users
        WHERE email = :email
        LIMIT 1
    ");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password_hash'])) {
        echo json_encode([
            "status" => "error",
            "message" => "We could not match that email and password. Please try again."
        ]);
        exit;
    }

    session_regenerate_id(true);

    $name = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));

    $_SESSION['user'] = [
        'user_id' => (int)$user['user_id'],
        'email'   => $user['email'],
        'username'=> $user['username'] ?? '',
        'role'    => $user['role'] ?? 'user',
        'name'    => $name !== '' ? $name : ($user['username'] ?? ''),
    ];

    echo json_encode([
        "status" => "success",
        "message" => "Login successful.",
        "data" => [
            "user" => $_SESSION['user']
        ]
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}