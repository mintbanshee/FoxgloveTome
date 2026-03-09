<?php
declare(strict_types=1); 

require_once __DIR__ . '/../models/JournalEntry.php';
require_once __DIR__ . '/../auth/require_login.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action') ?? '';

switch ($action) {

    // Create a new journal entry
    case 'create':
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $moodCategory = trim($_POST['mood_category'] ?? '');
        $mood = trim($_POST['mood'] ?? ''); 

        // Get user ID from session
        $userId = $_SESSION['user']['user_id'];

          // Validate required fields - if any are missing, redirect back with error message
        if (!$title || !$content || !$moodCategory || !$mood) {
            $_SESSION['error'] = "Oops! You are missing something, all fields are required.";
            header("Location: ../views/journal/new_entry.php");
            exit();
        }

          // Create the journal entry
        $entry = new JournalEntry();
        $success = $entry->create($userId, $title, $content, $moodCategory, $mood);

        if ($success) {
            $_SESSION['success'] = "Your journal entry has been saved!";
            header("Location: ../views/users/user_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Sorry, there was an issue saving your entry. Please try again.";
            header("Location: ../views/journal/new_entry.php");
            exit();
        }

    // When user clicks on an entry from the dashboard, show the full entry with all details 
 case "view_entry": 
    $entryId = isset($_GET['id']) ? (int) $_GET['id'] : null;
    $userId = $_SESSION['user']['user_id'];

    if (!$entryId) {
        $_SESSION['error'] = "Sorry, we could not find this entry.";
        header("Location: ../views/users/user_dashboard.php");
        exit();
    }

    $journalEntry = new JournalEntry();
    $entry = $journalEntry->getEntryById($entryId);

    if (!$entry) {
        $_SESSION['error'] = "Sorry, we could not find this entry.";
        header("Location: ../views/users/user_dashboard.php");
        exit();
    }

    require __DIR__ . '/../views/journal/view_entry.php';
    break;
    
}