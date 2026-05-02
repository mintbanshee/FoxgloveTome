<?php
declare(strict_types=1);


// *~*~*~*~*~*~* LOGOUT ENDPOINT *~*~*~*~*~*~*

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// clear the session data and destroy the session
try {
    $_SESSION = [];
    // delete the session cookie if it exists
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        // set the cookie to expire in the past to delete it
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // destroy the session
    session_destroy();

    // successfully logged out
    echo json_encode([
        "status" => "success",
        "message" => "Logged out successfully."
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}