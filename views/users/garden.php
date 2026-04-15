<?php
require_once __DIR__ . '/../../auth/require_login.php';
require_once __DIR__ . '/../../models/Garden.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../header.php';

$userId = $_SESSION['user']['user_id'];

$garden = new Garden();
$monthlyEntries = $garden->getMonthlyEntries($userId);

/* TEMP: simple weekly flowers (we will improve later) */
$weeklyFlowers = [];

/* just take first 4 entries for now to stabilize */
$index = 0;
foreach ($monthlyEntries as $entry) {
    if ($index >= 4) break;

    switch ($entry['mood_category']) {
        case 'Blooming':
            $weeklyFlowers[] = '🌼';
            break;
        case 'Rooted':
            $weeklyFlowers[] = '🌿';
            break;
        case 'Wilted':
            $weeklyFlowers[] = BASE_URL . 'assets/images/flowers/Chrysanthemum300.png';
            break;
        case 'Prickly':
            $weeklyFlowers[] = BASE_URL . 'assets/images/flowers/Petunia300.png';
            break;
    }

    $index++;
}
?>

<div id="gardenIntro" class="container py-5">
    <h1 class="formHeader text-center mb-3">My Garden</h1>
    <p class="text-center mb-3">
        Watch your garden bloom as you nurture it with your thoughts and feelings!
    </p>
    <small class="text-muted d-block text-center mb-4">
        Each planter represents a week in the month and grows a flower for your average mood category 🌸</small>


    <?php if (empty($weeklyFlowers)): ?>
        <div class="alert alert-light border text-center mt-4">
            Your garden will begin to bloom as you write entries 🌿
        </div>
    <?php else: ?>

    <div id="gardenSnapshot" class="garden">
        <div class="gardenPlants">
            <?php $position = 1; ?>
            <?php foreach ($weeklyFlowers as $flower): ?>

                <?php
                $flowerClass = '';

                if (str_contains($flower, 'Chrysanthemum.png')) {
                    $flowerClass = 'flower-wilted';
                } elseif (str_contains($flower, 'BlackPetunia.png')) {
                    $flowerClass = 'flower-prickly';
                }
                ?>

                <div class="gardenPlant pos<?= $position ?> <?= $flowerClass ?>">
                    <?php if (str_contains($flower, '.png')): ?>
                        <img src="<?= htmlspecialchars($flower) ?>" alt="Mood flower" class="flower flowerImage">
                    <?php else: ?>
                        <span class="flower"><?= htmlspecialchars($flower) ?></span>
                    <?php endif; ?>
                </div>

                <?php $position++; ?>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php endif; ?>
</div>

<!-- bottom nav -->

<nav class="navbar fixed-bottom navbar-sanctuary navbar-dark border-top d-flex align-items-center" style="height:70px;">
  <div class="container-fluid justify-content-around align-items-center">

    <button type="button" id="saveGardenBtn" class="btn btn-light btn-outline-primary rounded-pill px-4">
        Save Image
    </button>
    
    <a class="btn btn-light btn-outline-success rounded-pill px-4" 
        href="<?= BASE_URL ?>views/users/user_dashboard.php">
        Dashboard
    </a>

  </div>
</nav>

<!-- script to save garden image -->

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const saveBtn = document.getElementById('saveGardenBtn');
    const garden = document.getElementById('gardenSnapshot');

    if (saveBtn && garden) {
        saveBtn.addEventListener('click', async function () {
            const canvas = await html2canvas(garden, {
                useCORS: true,
                scale: 2,
                backgroundColor: null
            });

            const link = document.createElement('a');
            link.download = 'GardenMoodTracker' + new Date().toISOString().slice(0,10) + '.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    }
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>