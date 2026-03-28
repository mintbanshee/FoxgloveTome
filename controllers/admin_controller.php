<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/JournalEntry.php';

$action = $_GET['action'] ?? 'sanctuaryControl';

if (!isset($_SESSION['user'])) {
    exit('No user session found.');
}

if ($_SESSION['user']['role'] !== 'admin') {
    exit('Access denied. Role found: ' . htmlspecialchars((string) $_SESSION['user']['role']));
}

switch ($action) {
 case 'sanctuaryControl':
    $userModel = new User();
    $totalUsers = $userModel->getTotalUsers();
    $totalEntries = (new JournalEntry())->getTotalEntries();
    $mostCommonMood = (new JournalEntry())->getMostCommonMood();

    require_once __DIR__ . '/../views/admin/admin_dashboard.php';
    exit();

    default:
        exit('Unknown admin action.');  
}