<?php
declare(strict_types=1); 

require_once __DIR__ . '/../models/JournalEntry.php';
require_once __DIR__ . '/../auth/require_login.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
            unset($_SESSION['success']);
            $_SESSION['error'] = "It looks like something is missing. Please fill in all fields before saving.";
            header("Location: ". BASE_URL . "views/journal/new_entry.php");
            exit();
        }

          // Create the journal entry
        $entry = new JournalEntry();
        $success = $entry->create($userId, $title, $content, $moodCategory, $mood);

        if ($success) {
            unset($_SESSION['error']);
            $_SESSION['success'] = "Your thoughts have been safely stored in the tome.";
            header("Location: " . BASE_URL . "views/users/user_dashboard.php");
            exit();
        } else {
            unset($_SESSION['success']);
            $_SESSION['error'] = "Some dust must have settled on the page while saving your entry. Please try again.";
            header("Location: " . BASE_URL . "views/journal/new_entry.php");
            exit();
        }

    // When user clicks on an entry from the dashboard, show the full entry with all details 
    case 'view_entry': 
        $entryId = isset($_GET['id']) ? (int) $_GET['id'] : null;
        $userId = $_SESSION['user']['user_id'];

        if (!$entryId) {
            $_SESSION['error'] = "The keepers could not find that entry. It does not exist within the pages of the tome.";
            header("Location: " . BASE_URL . "views/users/user_dashboard.php");
            exit();
        }

        // get entry and user info for the view entries page. 
        // if there is no entry or it is not the correct user - redirect to dashboard with error message
        $journalEntry = new JournalEntry();
        $entry = $journalEntry->getEntryById($entryId, $userId);

        if (!$entry) {
            $_SESSION['error'] = "The keepers could not find that entry. It does not exist within the pages of the tome.";
            header("Location: " . BASE_URL . "views/users/user_dashboard.php");
            exit();
        }

        require __DIR__ . '/../views/journal/view_entry.php';
        break;
    
    // edit journal entry when user clicks edit button on view_entry page
    case 'edit_entry':
        // get the entry id and user id 
        $entryId = isset($_GET['id']) ? (int) $_GET['id'] : null;
        $userId = $_SESSION['user']['user_id'];

        // if the entry id is not there or is invalid, redirect to dashboard with error 
        if (!$entryId) {
            $_SESSION['error'] = "The keepers could not find that entry. It does not exist within the pages of the tome.";
            header("Location: " . BASE_URL . "views/users/user_dashboard.php");
            exit();
        }

        // get the entry and user info
        $journalEntry = new JournalEntry();
        $entry = $journalEntry->getEntryById($entryId, $userId);

        // if there is no entry or it is not the correct user, redirect to dashboard with error
        if (!$entry) {
            $_SESSION['error'] = "The keepers could not find that entry. It does not exist within the pages of the tome.";
            header("Location: " . BASE_URL . "views/users/user_dashboard.php");
            exit();
        }

        require __DIR__ . '/../views/journal/edit_entry.php';
        break;
    
    // save the edited journal entry to the database when user clicks save 
    case 'update_entry':
        $entryId = isset($_POST['entry_id']) ? (int) $_POST['entry_id'] : null;
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $moodCategory = trim($_POST['mood_category'] ?? '');
        $mood = trim($_POST['mood'] ?? ''); 
        $userId = $_SESSION['user']['user_id'];

        // Validate required fields - if any are missing, redirect back with error message
        if (!$entryId || !$title || !$content || !$moodCategory || !$mood) {
            $_SESSION['error'] = "It looks like something is missing. Please fill in all fields before saving.";
            header("Location: " . BASE_URL . "controllers/entry_controller.php?action=edit_entry&id=$entryId");
            exit();
        }

        // Update the journal entry
        $journalEntry = new JournalEntry();
        $success = $journalEntry->update($entryId, $userId, $title, $content, $moodCategory, $mood);

        if ($success) {
            $_SESSION['success'] = "The changes to your entry have been safely stored in the tome.";
            header("Location: " . BASE_URL . "controllers/entry_controller.php?action=view_entry&id=$entryId");
            exit();
        } else {
            $_SESSION['error'] = "Some dust must have settled on the page while updating your entry. Please try again.";
            header("Location: " . BASE_URL . "controllers/entry_controller.php?action=edit_entry&id=$entryId");
            exit();
        }

    // delete a journal entry when user clicks delete button
    case 'delete':
        $entryId = isset($_GET['id']) ? (int) $_GET['id'] : null;
        $userId = $_SESSION['user']['user_id'];

        if (!$entryId) {
            $_SESSION['error'] = "The keepers could not find that entry. It does not exist within the pages of the tome.";
            header("Location: " . BASE_URL . "views/users/user_dashboard.php");
            exit();
        }

        $journalEntry = new JournalEntry();
        $success = $journalEntry->delete($entryId, $userId);

        if ($success) {
            $_SESSION['success'] = "Your journal entry has been safely removed from the tome.";
            header("Location: " . BASE_URL . "views/users/user_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Some dust must have settled on the page while deleting your entry. Please try again.";
            header("Location: " . BASE_URL . "views/users/user_dashboard.php");
            exit();
        }

    default:
        $_SESSION['error'] = "We couldn't find that page, it looks like it does not exist within the pages of the tome.";
        header("Location: " . BASE_URL . "views/users/user_dashboard.php");
        exit();

} // close switch statement 
