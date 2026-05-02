<?php 

// *~*~*~*~*~*~* USER DASHBOARD *~*~*~*~*~*~*

require_once __DIR__ . '/../../auth/require_login.php';
require_once __DIR__ . '/../../models/JournalEntry.php';
require_once __DIR__ . '/../../models/MoodIcons.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../header.php'; 

$userId = $_SESSION['user']['user_id'];
$username = $_SESSION['user']['username'];

$journalEntry = new JournalEntry();

$entries = $journalEntry->getEntriesByUser($userId);

// get the weekly mood summary
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
        <h1 class="montecarlo-regular mb-2 fw-bold">My Dashboard</h1>
        <p class="text-muted mb-3">Welcome back, <?= htmlspecialchars($username) ?></p>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <a href="<?= BASE_URL ?>controllers/admin_controller.php?action=sanctuaryControl" 
        class="btn btn-outline-success rounded-pill px-4">
            <sub>⟡</sub>☾<sup>⟡</sup> Keeper Access
        </a>
    <?php endif; ?>
    </div>

<!-- Weekly Mood Summary -->
    <div class="summaryCard mb-4 py-3 shadow-sm">
        <div class="card-body text-center">
        <h4 class="montecarlo-regular card-title mb-2">Weekly Mood Summary</h4>
        <p class="flourish mb-2"><sub>⟡</sub><sup>⟡</sup></p>

            <!-- display the dominant mood for this week and pull a quote from the array -->
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
    <h3 class="montecarlo-regular mb-3 fw-bold">My Journal</h3>
    <?php if (empty($entries)): ?>
        <div class="alert alert-light border">
            You have no journal entries yet. Start by creating your first entry!
        </div>
    <?php else: ?>

        <div class="list-group">
            <?php foreach ($entries as $entry): ?>
                <a href="<?= BASE_URL ?>controllers/entry_controller.php?action=view_entry&id=<?= htmlspecialchars($entry['entry_id']) ?>" class="text-decoration-none text-dark">
                
                   <div class="entryCard px-2 py-1 mb-3 shadow-sm">
                        <div class="card-body">
                            <small class="date text-muted fst-italic d-block mb-2"><?= htmlspecialchars($entry['date_created']) ?></small>
                            <h5 class="title montecarlo-regular card-title mb-2"><?= htmlspecialchars($entry['title']) ?></h5>
                            
                            <!-- display the mood with an icon -->
                            <?php $iconPath = getMoodIcon($entry['mood_category']); ?>
                                <p class="moodRow mb-1 text-muted">
                                    <span class="moodText"><?= htmlspecialchars($entry['mood']) ?></span>
                                        <?php if (!empty($iconPath)): ?>
                                        <img
                                            src="<?= htmlspecialchars($iconPath) ?>"
                                            alt="<?= htmlspecialchars($entry['mood_category']) ?>"
                                            class="moodIcon">
                                    <?php endif; ?>
                                </p>

                            <p class="description text-muted fs-6 fst-italic text-truncate"><?= substr(htmlspecialchars($entry['content']), 0, 120) ?>...</p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<!-- Bottom Nav -->

<nav class="navbar fixed-bottom navbar-sanctuary navbar-dark border-top d-flex align-items-center" style="height:70px;">
  <div class="container-fluid justify-content-around align-items-center">

    <a class="btn btn-light btn-outline-danger rounded-pill px-3" 
        href="<?= BASE_URL ?>controllers/auth_controller.php?action=logout">
        Logout
    </a>

    <a class="btn btn-light btn-outline-success rounded-pill px-3" 
        href="<?= BASE_URL ?>views/users/garden.php">
        Garden
    </a>

    <a class="btn btn-light btn-outline-primary rounded-pill px-3" 
        href="<?= BASE_URL ?>views/journal/new_entry.php">
        New Entry
    </a>

  </div>
</nav>

<?php include __DIR__ . '/../footer.php'; ?>