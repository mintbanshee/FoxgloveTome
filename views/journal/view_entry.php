<?php
require_once __DIR__ . '/../../auth/require_login.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../header.php';
?>

<div class="container py-5">
  <div class="d-flex gap-2 mb-4">

    <a href="<?= BASE_URL ?>views/users/user_dashboard.php"
       class="btn btn-secondary">
        Back to Dashboard
    </a>

    <a href="<?= BASE_URL ?>controllers/entry_controller.php?action=delete&id=<?= $entry['entry_id'] ?>"
       class="btn btn-danger"
       onclick="return confirm('Are you sure you want to delete this entry?');">
        Delete
    </a>

    <a href="<?= BASE_URL ?>controllers/entry_controller.php?action=edit&id=<?= $entry['entry_id'] ?>"
       class="btn btn-primary">
        Edit
    </a>

</div>

  <p class="text-muted">
                <?= htmlspecialchars($entry['date_created']) ?>
            </p>

            <h2 class="mb-3">
                <?= htmlspecialchars($entry['title']) ?>
            </h2>

            <p class="mb-3">
                <strong>Mood:</strong>
                <?= htmlspecialchars($entry['mood_category']) ?> —
                <?= htmlspecialchars($entry['mood']) ?>
            </p>

            <hr>

            <p>
                <?= nl2br(htmlspecialchars($entry['content'])) ?>
            </p>

        </div>
    </div>

</div>