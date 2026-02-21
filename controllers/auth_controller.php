<?php
declare(strict_types=1); 

require_once '/../db/database.php';
require_once '/../config/app.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action')
    ?? 'dashboard'; // default action for if not specified

    switch ($action) {
// signup 
      case 'signup': 
        $errors = [];
        $email = '';
        $first = '';
        $last = '';
        $role = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $email = strtolower(trim($_POST['email'] ?? ''));
          $username = trim($_POST['username'] ?? '');
          $password = $_POST['password'] ?? '';
          $confirm = $_POST['confirm_password'] ?? '';
          $role = $_POST['role'] ?? '';
          $first = trim($_POST['first_name'] ?? '');
          $last = trim($_POST['last_name'] ?? '');
          $joined = date('Y-m-d H:i:s');

          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format. Maybe check the @ symbol?';
          if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters to keep your thoughts safe.';
          if ($password !== $confirm) $errors[] = 'Passwords do not match. Please try again.';

          if (!$errors) {
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->fetch()) {
              $errors[] = "It looks like this email already planted a garden here. <a href='?action=login'>Try logging in?</a>";
            } else {
              $hash = password_hash($password, PASSWORD_DEFAULT);

              $stmt = $pdo->prepare("
              INSERT INTO users (email, username, password, role, first_name, last_name, date_joined)
              VALUES (:email, :username, :password, :role, :first_name, :last_name, :joined)");
              $stmt->execute([
                'email' => $email,
                'username' => $username,
                'password' => $hash,  
                'role' => $role,
                'first_name' => $first,
                'last_name' => $last,
                'date_joined' => $joined
              ]);

              $newUserId = $pdo->lastInsertId();
              $_SESSION['user'] = [
                'user_id' => $newUserId,
                'email' => $email,
                'username' => $username,
                'role' => $role,
                'name' => trim("$first $last"),
                'date_joined' => $joined
              ];

              header('Location: ' . BASE_URL . 'views/users/user_dashboard.php');
              exit();
            }
          break;
          }
        }

// login



// logout





    }