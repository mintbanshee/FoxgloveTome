<?php
declare(strict_types=1); 

require_once __DIR__ . '/../db/database.php';
require_once __DIR__ . '/../config/app.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action')
    ?? 'login'; // default action for if not specified

    switch ($action) {

// signup 
  case 'signup':
    $errors = [];
    $email = '';
    $first = '';
    $last = '';
    $role = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // all the variables needed for signup 
        $email = strtolower(trim($_POST['email'] ?? ''));
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? '';
        $first = trim($_POST['first_name'] ?? '');
        $last = trim($_POST['last_name'] ?? '');
        $joined = date('Y-m-d H:i:s');

        // signup errors 
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "That email doesn't look quite right. Maybe check the @ symbol?";
        }
        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters to keep your thoughts safe.';
        }
        if ($password !== $confirm) {
            $errors[] = 'Passwords do not match. Please try again.';
        }

        if (empty($errors)) {
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);

            if ($stmt->fetch()) {
                $errors[] = "It looks like this email already planted a garden here. <a href='?action=login'>Try logging in?</a>";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // create the user in the database 
                $stmt = $pdo->prepare("
                    INSERT INTO users (email, username, password_hash, role, first_name, last_name, date_joined)
                    VALUES (:email, :username, :password_hash, :role, :first_name, :last_name, :joined)
                ");

                $stmt->execute([
                    'email' => $email,
                    'username' => $username,
                    'password_hash' => $hash,
                    'role' => $role,
                    'first_name' => $first,
                    'last_name' => $last,
                    'joined' => $joined
                ]);

                $_SESSION['user'] = [
                    'user_id' => $pdo->lastInsertId(),
                    'email' => $email,
                    'username' => $username,
                    'role' => $role,
                    'name' => trim("$first $last"),
                    'date_joined' => $joined
                ];

                header('Location: ' . BASE_URL . 'views/users/user_dashboard.php');
                exit();
            }
        }
    }
    require_once __DIR__ . '/../auth/signup.php';
    break;


// login
  case 'login':
    $errors = [];          
    $email = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        // fetch the user from the database with limit 1 safety-net in case somehow there is duplicate email 
        $stmt = $pdo->prepare("
            SELECT user_id, email, password_hash, role, first_name, last_name, username
            FROM users
            WHERE email = :email
            LIMIT 1
        ");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // authenticate the user by verifying their account exists 
        // as well as verifying the password 
        if (!$user || !password_verify($password, $user['password_hash'])) {
            
            $errors[] = "Invalid email or password.";
        } else {
            session_regenerate_id(true); // for additional security, if login successful create a fresh session id 

            $_SESSION['user'] = [
                'user_id' => (int)$user['user_id'],
                'email'   => $user['email'],
                'username'=> $user['username'] ?? '',
                'role'    => $user['role'] ?? 'user',
                'name'    => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')),
            ];

            // return to previous page if applicable
            if (!empty($_SESSION['redirect_url'])) {
                $destination = $_SESSION['redirect_url'];
                unset($_SESSION['redirect_url']);
                header('Location: ' . $destination);
                exit();
            }

            // if admin - send to admin dashboard 
            if (($_SESSION['user']['role'] ?? '') === 'admin') {
                header('Location: ' . BASE_URL . 'views/admin/admin_dashboard.php');
                exit();
            }

            // if user send to user dashboard 
            header('Location: ' . BASE_URL . 'views/users/user_dashboard.php');
            exit();
        }
    }
    require_once __DIR__ . '/../auth/login.php';
    break;
      



// logout
    case 'logout':
      
      $_SESSION = []; 
      if (ini_get("session.use_cookies")) { 
        $params = session_get_cookie_params(); 
        setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"], $params["secure"], $params["httponly"] 
      ); 
    } // close case logout
    session_destroy(); 

    header('Location: ' . BASE_URL . 'controllers/auth_controller.php?action=login'); 
    exit();

    case 'forgot_password':
        $errors = [];
        $email = '';
        $message = ''; // successful message with info 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = strtolower(trim($_POST['email'] ?? ''));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "That email doesn't look quite right. Maybe check the @ symbol?";
            }
            
            // look up the user
            if (empty($errors)) {
                $statement = $pdo->prepare("SELECT user_id FROM users WHERE email = :email LIMIT 1");
                $statement->execute(['email' => $email]);
                $user = $statement->fetch(PDO::FETCH_ASSOC);

                // create a secure random token
                if ($user) {
                    $token = bin2hex(random_bytes(32)); // goes in the email
                    $tokenHash = hash('sha256', $token); // what gets stored
                    $expires = date('Y-m-d H:i:s', time() + 60 * 30); // expires in 30 minutes

                    // store the reset request
                    $statement = $pdo->prepare ("
                        INSERT INTO password_resets (user_id, token_hash, expires_at)
                        VALUES (:user_id, :token_hash, :expires_at)
                    ");
                    $statement->execute ([
                        'user_id' => (int)$user['user_id'],
                        'token_hash' => $tokenHash,
                        'expires_at' => $expires
                    ]);

                    $resetLink = BASE_URL . "controllers/auth_controller.php?action=reset_password&token=" . urlencode($token);

                    // send the email
                    // will use mail() or PHPMailer and proper SMTP
                    $subject = "Foxglove Tome Password Reset";
                    $body = "A password reset was requested for your account.\n\n"
                            . "Use this link to set a new password (expires in 30 minutes):\n"
                            . $resetLink . "\n\n"
                            . "If you did not place this request, you can ignore this email. You are still safe.";
                    @mail($email, $subject, $body); 
                } 

                $message = "If an account exists for this email, a reset link has been sent.";

            }
        }
        require_once __DIR__ . '/../auth/forgot_password.php';
        break;


        case 'reset_password':
            $errors = [];
            $token = $_GET['token'] ?? ($_POST['token'] ?? '');
            $token = trim($token);
            $message = '';
            
            // if the token is missing from the link 
            if ($token === '') {
                $errors[] = "This reset link is missing the key to your tome. Please request a new link to continue.";
                require_once __DIR__ . '/../auth/forgot_password.php';
                break;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newPassword = $_POST['password'] ?? '';
                $confirm = $_POST['confirm_password'] ?? '';

                // ensure password is long enough
                if (strlen($newPassword) < 8) {
                    $errors[] = 'Password must be at least 8 characters to keep your thoughts safe.';
                }
                // confirm new password fail 
                if ($newPassword !== $confirm) {
                    $errors[] = 'Passwords do not match. Please try again.';
                }
                // if no errors, continue
                if (empty($errors)) {
                    $tokenHash = hash('sha256', $token);

                    $statement = $pdo->prepare ("
                        SELECT reset_id, user_id, expires_at, used_at
                        FROM password_resets
                        WHERE token_hash = :token_hash
                        LIMIT 1
                    ");
                    $statement->execute(['token_hash' => $tokenHash]);
                    $reset = $statement->fetch(PDO::FETCH_ASSOC);

                    // expired link
                   if (!$reset || !empty($reset['used_at']) || strtotime($reset['expires_at']) < time()) {
                        $errors[] = "This reset link has expired or has already been used.";
                    } else {
                        // update the user's password
                        $hash = password_hash($newPassword, PASSWORD_DEFAULT);

                        $statement = $pdo->prepare ("
                            UPDATE users
                            SET password_hash = :password_hash
                            WHERE user_id = :user_id
                        ");
                        $statement->execute ([
                            'password_hash' => $hash,
                            'user_id' => (int)$reset['user_id']
                        ]);

                        // mark the token as used
                        $statement = $pdo->prepare ("
                            UPDATE password_resets
                            SET used_at = NOW()
                            WHERE reset_id = :reset_id
                        ");
                        $statement->execute(['reset_id' => (int)$reset['reset_id']]);

                        $message = "Your password has been updated. You can log in now.";
                    }
                }
            }
            require_once __DIR__ . '/../auth/reset_password.php';
            break;

  // if the action does not match a case redirect to a safe entry point / login page 
  default:
    header('Location: ' . BASE_URL . 'controllers/auth_controller.php?action=login');
    exit();

} // close switch 