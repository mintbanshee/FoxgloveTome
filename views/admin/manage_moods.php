<?php
require_once __DIR__ . '/../../auth/require_admin.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../header.php';
?>

<div class="container py-4">

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


<!-- Welcome Message --> 


<div class="container py-4">
    <div class="mb-4 text-center">
        <p class="adminFlourish mb-2"><sub>⟡</sub>☾<sup>⟡</sup></p>
        <h1 class="montecarlo-regular mb-2 fw-bold">Manage Moods</h1>
        <p class="text-muted">Fine tune the emotional landscape of the tome.</p>
    </div>

<!-- Show Mood Stats -->

<div class="d-flex text-center justify-content-center mb-4">
  <div class="statCard card p-0 overflow-hidden w-100" style="max-width: 500px;">
    <div class="row g-0">

      <div class="col-6 moodStat p-2 border-end">
        <div class="p-3">
          <h4><?= htmlspecialchars((string) ($mostCommonMood ?? '—')) ?></h4>
          <p class="text-muted mb-0">Most Common Mood</p>
        </div>
      </div>

      <div class="col-6 moodStat p-2">
        <div class="p-3">
          <h4><?= htmlspecialchars((string) ($mostCommonCategory ?? '—')) ?></h4>
          <p class="text-muted mb-0">Most Common Category</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Admin Actions -->
<div class="text-center mt-4">
  <h4 class="mb-3 text-muted">Which landscape would you like to manage?</h4>
    <div class="d-flex flex-wrap justify-content-center gap-3">

    <a href="<?= BASE_URL ?>controllers/admin_controller.php?action=manageMoodsLists" 
      class="btn btn-outline-success rounded-pill px-4 mt-3">
      Mood Lists
    </a>

    <a href="<?= BASE_URL ?>controllers/admin_controller.php?action=manageQuotes" 
      class="btn btn-outline-success rounded-pill px-4 mt-3">
      Summary Quotes
    </a>

  </div>
</div>



<!-- Bottom Nav -->

<nav class="navbar fixed-bottom navbar-sanctuary navbar-dark border-top d-flex align-items-center" style="height:70px;">
  <div class="container-fluid justify-content-around align-items-center">

    <a class="btn btn-light btn-outline-primary rounded-pill px-3"
       href="<?= BASE_URL ?>controllers/admin_controller.php?action=sanctuaryControl">
        Sanctuary Control
    </a>

    <a class="btn btn-light btn-outline-success rounded-pill px-3"
       href="<?= BASE_URL ?>views/users/user_dashboard.php">
        My Dashboard
    </a>

  </div>
</nav>    