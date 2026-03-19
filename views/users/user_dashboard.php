<!-- User Dashboard View -->

<?php 
require_once __DIR__ . '/../../auth/require_login.php';
require_once __DIR__ . '/../../models/JournalEntry.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../header.php'; 

$userId = $_SESSION['user']['user_id'];
$username = $_SESSION['user']['username'];

$journalEntry = new JournalEntry();
$entries = $journalEntry->getEntriesByUser($userId);

// get the weekly mood summary
$journalEntry = new JournalEntry();
$summary = $journalEntry->getWeeklyMoodSummary($userId);

// quotes array for the mood summary section 
$quotes = include __DIR__ . '/../../config/quotes.php';

?>

<div class="container py-5">

<!-- Error & Success Flash Messages -->

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

<!-- Welcome Message and User Info -->

    <div class="mb-4 text-center">
        <h1>My Dashboard</h1>
        <p>Welcome back, <?= htmlspecialchars($username) ?></p>
    </div>

<!-- Weekly Mood Summary -->
    <div class="card mb-4">
        <div class="card-body text-center">
            <h5 class="card-title">Weekly Mood Summary</h5>

            <!-- display the dominant mood for this week -->
            <?php if (!empty($summary['dominantMood'])): ?>
                <p class="text-muted">
                    This week, you have been feeling mostly <?= htmlspecialchars($summary['dominantMood']) ?>.
                </p>

                <?php if (!empty($summary['quote'])): ?>
                    <p class="fst-italic mt-2">
                        "<?= htmlspecialchars($summary['quote']) ?>"
                    </p>
                <?php endif; ?>

            <?php else: ?>
                <!-- if there are no entries in the past week, display a message -->
                <p class="text-muted">
                    Your story is still unfolding this week 🌱
                </p>
            <?php endif; ?>
        </div>
    </div>

<!-- Recent Journal Entries -->
    <h3>My Journal</h3>
    <?php if (empty($entries)): ?>
        <div class="alert alert-light border">
            You have no journal entries yet. Start by creating your first entry!
        </div>
    <?php else: ?>

        <div class="list-group">
            <?php foreach ($entries as $entry): ?>
                <a href="<?= BASE_URL ?>controllers/entry_controller.php?action=view_entry&id=<?= $entry['entry_id'] ?>" class="text-decoration-none text-dark">
                
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="text-muted"><?= htmlspecialchars($entry['date_created']) ?></p>
                            <h5 class="mt-2"><?= htmlspecialchars($entry['title']) ?></h5>
                            <span><?= htmlspecialchars($entry['mood']) ?></span>
                            <p><?= substr(htmlspecialchars($entry['content']), 0, 120) ?>...</p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<!-- Dashboard Buttons -->
    <div class="mt-4 d-flex justify-content-center gap-3">
        <a href="<?= BASE_URL ?>controllers/auth_controller.php?action=logout" class="btn btn-outline-secondary">
Logout
</a>
        <a href="#" class="btn btn-secondary">Filter</a>
        <a href="#" class="btn btn-secondary">My Garden</a>
        <a href="<?= BASE_URL ?>views/journal/new_entry.php" class="btn btn-dark">
            + New Entry
        </a>
    </div>

</div>

