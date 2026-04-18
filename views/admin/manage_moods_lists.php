<?php
require_once __DIR__ . '/../../auth/require_admin.php';
require_once __DIR__ . '/../../config/moods.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../header.php';
?>

<div class="container py-4">
    <div class="mb-4 text-center">
        <p class="adminFlourish mb-2"><sub>⟡</sub>☾<sup>⟡</sup></p>
        <h1 class="montecarlo-regular mb-2 fw-bold">Manage Moods</h1>
        <p class="text-muted">Fine tune the emotional landscape of the tome.</p>
    </div>
    
    <!-- Mood Cards -->
    <div class="list-group">
        <div class="moodCard card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-3">Blooming</h5>
                        <a href="#"
                            class="btn btn-xs btn-outline-success rounded-pill">
                            Manage
                        </a>
                </div>                
                <p class="categoryDescription mb-2">Represents positive and uplifting emotions</p>
                <p class="moodsList mb-2">
                    <?php foreach ($moodOptions['Blooming'] as $mood): ?>
                        <span class="bloomingPill"><?= htmlspecialchars($mood) ?></span>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>

        <div class="moodCard card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-3">Rooted</h5>
                        <a href="#"
                            class="btn btn-xs btn-outline-success rounded-pill">
                            Manage
                        </a>
                </div>                 
                <p class="categoryDescription mb-2">Represents calm and steady emotions</p>
                <p class="moodsList mb-2">
                    <?php foreach ($moodOptions['Rooted'] as $mood): ?>
                        <span class="rootedPill"><?= htmlspecialchars($mood) ?></span>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>

        <div class="moodCard card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-3">Wilted</h5>
                        <a href="#"
                            class="btn btn-xs btn-outline-success rounded-pill">
                            Manage
                        </a>
                </div>
                <p class="categoryDescription mb-2">Represents low or heavy emotions</p>
                <p class="moodsList mb-2">
                    <?php foreach ($moodOptions['Wilted'] as $mood): ?>
                        <span class="wiltedPill"><?= htmlspecialchars($mood) ?></span>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>

        <div class="moodCard card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-3">Prickly</h5>
                        <a href="#"
                            class="btn btn-xs btn-outline-success rounded-pill">
                            Manage
                        </a>
                </div>
                <p class="categoryDescription mb-2">Represents tense or conflicted emotions</p>
                <p class="moodsList mb-2">
                    <?php foreach ($moodOptions['Prickly'] as $mood): ?>
                        <span class="pricklyPill"><?= htmlspecialchars($mood) ?></span>
                    <?php endforeach; ?>
                </p>
            </div>

    </div>


<!-- Bottom Nav --> 
<nav class="navbar fixed-bottom navbar-sanctuary navbar-dark border-top d-flex align-items-center" style="height:70px;">
  <div class="container-fluid justify-content-around align-items-center">

    <a class="btn btn-light btn-outline-primary rounded-pill px-4"
       href="<?= BASE_URL ?>controllers/admin_controller.php?action=manageMoods">
        Back
    </a>

    <a class="btn btn-light btn-outline-success rounded-pill px-4"
       href="<?= BASE_URL ?>views/users/user_dashboard.php">
        My Dashboard
    </a>

  </div>
</nav>

<?php include __DIR__ . '/../footer.php'; ?>