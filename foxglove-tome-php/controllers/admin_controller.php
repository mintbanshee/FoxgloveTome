<?php
declare(strict_types=1);

// *~*~*~*~*~*~* ADMIN CONTROLLER *~*~*~*~*~*~*

session_start();

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/JournalEntry.php';

// Determine the action to take based on the 'action' parameter in POST or GET
$action = $_POST['action'] ?? $_GET['action'] ?? 'sanctuaryControl';

// check if the user is logged in
if (!isset($_SESSION['user'])) {
    exit('No user session found.');
}

// check if they are an admin or not
if ($_SESSION['user']['role'] !== 'admin') {
    exit('Access denied. Role found: ' . htmlspecialchars((string) $_SESSION['user']['role']));
}

switch ($action) {

    // Admin dashboard stats 
    case 'sanctuaryControl':
        $userModel = new User();
        $totalUsers = $userModel->getTotalUsers();
        $totalEntries = (new JournalEntry())->getTotalEntries();
        $mostCommonMood = (new JournalEntry())->getMostCommonMood();

        require_once __DIR__ . '/../views/admin/admin_dashboard.php';
        exit(); 


    // show list of all users
    case 'manageUsers':
        $userModel = new User();
        $users = $userModel->getAllUsers();

        require_once __DIR__ . '/../views/admin/manage_users.php';
        exit();
    
    // show details for a specific user and allow editing
    case 'editUser':
        $userId = (int) ($_GET['id'] ?? 0);

        if ($userId <= 0) {
            exit('Sorry, that journaler ID is invalid. Please try again.');
        }

        $userModel = new User();
        $user = $userModel->getUserById($userId);

        if (!$user) {
            exit('That journaler could not be found.');
        }

        $journalEntry = new JournalEntry();
        $entryCount = $journalEntry->getEntryCountByUser($userId);
        $summary = $journalEntry->getWeeklyMoodSummary($userId);        

        require_once __DIR__ . '/../views/admin/manage_user.php';
        exit();

    // handle role updates (promote/demote) from the manage user page
    case 'updateRole':
        $userId = (int) ($_POST['user_id'] ?? 0);
        $newRole = $_POST['new_role'] ?? '';

        if ($userId <= 0 || !in_array($newRole, ['user', 'admin'])) {
            exit('Invalid role update request.');
        }

        $userModel = new User();
        $userModel->updateUserRole($userId, $newRole);

        header("Location: " . BASE_URL . "controllers/admin_controller.php?action=editUser&id=" . $userId);
        exit();    

    // manage moods dashboard page - show mood stats and links to admin functions for moods
    case 'manageMoods':
        $journalEntry = new JournalEntry();

        $mostCommonMood = $journalEntry->getMostCommonMood();
        $mostCommonCategory = $journalEntry->getMostCommonCategory();

        require_once __DIR__ . '/../views/admin/manage_moods.php';
        exit();

    // manage list of moods and categories
    /* this feature is currently just for viewing the lists, 
        but in the future I will add functionality to add/edit/delete */
    case 'manageMoodsLists': 

        require_once __DIR__ . '/../views/admin/manage_moods_lists.php';
        exit();

    // manage weekly summary quotes - show quotes by category
    // in the future I will add functionality to add/edit/delete 
    case 'manageQuotes':
        $summaryQuotes = require __DIR__ . '/../config/quotes.php';

        $selectedCategory = $_GET['category'] ?? 'Blooming';

        if (!array_key_exists($selectedCategory, $summaryQuotes)) {
            $selectedCategory = 'Blooming';
        }

        $categoryQuotes = $summaryQuotes[$selectedCategory];

        require_once __DIR__ . '/../views/admin/manage_quotes.php';
        exit();


        default:
            exit('Unknown admin action.'); 
}
