<?php 
declare(strict_types=1); 

require_once __DIR__ . '/../config/app.php'; 
require_once __DIR__ . '/require_login.php';

// if the user is not an admin redirect them to user dashboard 
if(($_SESSION['user']['role'] ?? '') !== 'admin') { 
  header('Location: ' . BASE_URL . '/views/users/user_dashboard.php'); 
  exit(); 
}