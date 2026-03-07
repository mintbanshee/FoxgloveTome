<?php 
require_once __DIR__ . '/../../auth/require_login.php';
require_once __DIR__ . '/../../models/JournalEntry.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userID = $_SESSION['user']['user_id'];
$username = $_SESSION['user']['username'];

$journalEntry = new JournalEntry();
$entries = $journalEntry->getEntriesByUser($userID);

include __DIR__ . '/../../header.php'; 
?>



<h1>User Dashboard</h1>

<!-- Welcome Message and User Info -->
<p>Welcome <?= htmlspecialchars($username) ?></p>



<!-- Journal Entries -->
<h2>Your Journal Entries</h2>
<?php if (empty($entries)): ?>
    <p>You have no journal entries yet.</p> 
<?php else: ?>
    <ul>
        <?php foreach ($entries as $entry): ?>
            <li>
                <h3><?= htmlspecialchars($entry['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars($entry['content'])) ?></p>
                <p><strong>Mood:</strong> <?= htmlspecialchars($entry['mood_category']) ?> - <?= htmlspecialchars($entry['mood']) ?></p>
                <p><em>Created on: <?= htmlspecialchars($entry['date_created']) ?></em></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>









<a href="<?= BASE_URL ?>controllers/auth_controller.php?action=logout">Logout</a>