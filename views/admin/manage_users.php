<?php
require_once __DIR__ . '/../../auth/require_admin.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../header.php';
?>

<div class="container py-4">
    <div class="mb-4 text-center">
        <p class="adminFlourish mb-2"><sub>⟡</sub>☾<sup>⟡</sup></p>
        <h1 class="montecarlo-regular mb-2 fw-bold">Manage Users</h1>
        <p class="text-muted">A look at every soul currently within the tome.</p>
    </div>

    <?php if (empty($users)): ?>
        <div class="alert alert-light border">
            No users were found in the sanctuary.
        </div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($users as $user): ?>
                <div class="userCard card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-1 text-truncate me-2" style="max-width: 70%;"><?= htmlspecialchars($user['username']) ?></h5>
                            
                                <a href="<?= BASE_URL ?>controllers/admin_controller.php?action=editUser&id=<?= $user['user_id'] ?>"
                                    class="btn btn-xs btn-outline-success rounded-pill">
                                    Manage
                                </a>
                        </div>
                        <p class="mb-1 text-muted text-truncate" style="max-width: 100%;"><?= htmlspecialchars($user['email']) ?></p>
                        <p class="mb-1">
                            <strong>Role:</strong> <?= htmlspecialchars($user['role']) ?>
                        </p>
                        <p class="mb-0">
                            <strong>Joined:</strong> <?= htmlspecialchars($user['date_joined']) ?>
                        </p>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
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

<?php include __DIR__ . '/../footer.php'; ?>