<?php
require_once __DIR__ . '/../../auth/require_login.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../header.php';
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


<nav class="navbar fixed-bottom navbar-sanctuary navbar-dark border-top">
  <div class="container-fluid justify-content-around">

    <a class="btn btn-light btn-outline-success rounded-pill px-4 mt-3" 
        href="<?= BASE_URL ?>views/users/user_dashboard.php">
        Dashboard
    </a>

    <a href="<?= BASE_URL ?>controllers/entry_controller.php?action=delete&id=<?= $entry['entry_id'] ?>" 
    class="btn btn-light btn-outline-danger rounded-pill px-4 mt-3" 
    onclick="return confirm('Are you sure you want to delete this entry?');">
        Delete
    </a>

    <a href="<?= BASE_URL ?>controllers/entry_controller.php?action=edit_entry&id=<?= $entry['entry_id'] ?>"
    class="btn btn-light btn-outline-primary rounded-pill px-4 mt-3">
    Edit Entry
    </a>

  </div>
</nav>




<?php include __DIR__ . '/../footer.php'; ?>