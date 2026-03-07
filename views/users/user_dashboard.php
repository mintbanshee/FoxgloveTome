<?php require_once __DIR__ . '/../../auth/require_login.php'; ?>

<h1>User Dashboard</h1>

<!-- Welcome Message and User Info -->
<p>Welcome <?= htmlspecialchars($_SESSION['user']['name']) ?></p>
<p>Your role: <?= htmlspecialchars($_SESSION['user']['role']) ?></p>



<!-- Journal Entries -->
<h2>Your Journal Entries</h2>
<?php if (empty($entries)): ?>
    <p>You have no journal entries yet.</p> 
<?php else: ?>
    <ul>
        <?php foreach ($entries as $entry): ?>
            <li>Entry 1</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>









<a href="<?= BASE_URL ?>controllers/auth_controller.php?action=logout">Logout</a>