<?php 
require_once __DIR__ . '/../../auth/require_admin.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../header.php';

$username = $_SESSION['user']['username'];
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

<!-- Welcome Message and User Info -->

    <div class="mb-4 text-center">
        <p class="adminFlourish mb-2"><sub>⟡</sub>☾<sup>⟡</sup></p>
        <h1 class="montecarlo-regular mb-2 fw-bold">The Keepers of the Tome</h1>
        <h4 class="text-muted">Sanctuary Control</h4>
        <p class="adminFlourish mt-3 mb-2">✦ ━━ ⟡ ━━ ✦</p>

        <p class="text-muted mb-3">Welcome back, Keeper <?= htmlspecialchars($username) ?></p>
        <p class="text-muted mb-3">Thank you for helping us make Foxglove a better place for everyone!</p>
    </div>


<!-- App Stats -->
<div class="statCard card p-0 overflow-hidden">
  <div class="row g-0 text-center">

    <div class="col-12 col-md-4 stat-item">
      <div class="p-2">
        <h4><?= htmlspecialchars((string) $totalUsers) ?></h4>
        <p class="text-muted mb-0">Total Users</p>
      </div>
    </div>

    <div class="col-12 col-md-4 stat-item">
      <div class="p-2">
        <h4><?= htmlspecialchars((string) ($totalEntries ?? '—')) ?></h4>
        <p class="text-muted mb-0">Journal Entries</p>
      </div>
    </div>

    <div class="col-12 col-md-4 stat-item">
      <div class="p-3">
        <h4><?= htmlspecialchars((string) ($mostCommonMood ?? '—')) ?></h4>
        <p class="text-muted mb-0">Most Common Mood</p>
      </div>
    </div>

  </div>
</div>
<!-- Admin Actions -->
<div class="text-center mt-4">

  <h4 class="mb-3 text-muted">Sanctuary Actions</h4>

  <div class="d-flex flex-wrap justify-content-center gap-3">

    <a href="<?= BASE_URL ?>controllers/admin_controller.php?action=manageUsers" 
      class="btn btn-outline-success rounded-pill px-4 mt-3">
      Manage Users
    </a>

    <a href="<?= BASE_URL ?>controllers/admin_controller.php?action=manageMoods" class="btn btn-outline-success rounded-pill px-4 mt-3">
      Manage Moods
    </a>

  </div>

</div>

<!-- Bottom Nav -->
<nav class="navbar fixed-bottom navbar-sanctuary navbar-dark border-top d-flex align-items-center" style="height:70px;">
  <div class="container-fluid justify-content-around align-items-center">

    <a class="btn btn-light btn-outline-danger rounded-pill px-4" 
        href="<?= BASE_URL ?>controllers/auth_controller.php?action=logout">
        Logout
    </a>

    <a class="btn btn-light btn-outline-success rounded-pill px-4" 
        href="<?= BASE_URL ?>views/users/user_dashboard.php">
        My Dashboard
    </a>



  </div>
</nav>

<?php include __DIR__ . '/../footer.php'; ?>