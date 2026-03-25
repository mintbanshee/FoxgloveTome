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
            $weeklyFlowers[] = '🍂';
            break;
        case 'Prickly':
            $weeklyFlowers[] = '🌵';
            break;
    }

    $index++;
}
?>

<div id="gardenIntro" class="container py-5">
    <h1 class="text-center mb-2">My Garden</h1>
    <p class="text-center">
        A visual mood tracker based on your logged moods. Each flower represents a mood entry from the past month.<br>
        Watch your garden bloom as you nurture it with your thoughts and feelings!
    </p>

    <?php if (empty($weeklyFlowers)): ?>
        <div class="alert alert-light border text-center mt-4">
            Your garden will begin to bloom as you write entries 🌿
        </div>
    <?php else: ?>

    <div class="garden">

        <div class="gardenPlants">
            <?php $position = 1; ?>
            <?php foreach ($weeklyFlowers as $flower): ?>

            <div class="gardenPlant pos<?= $position ?>">
                <span class="flower"><?= $flower ?></span>
            </div>

            <?php $position++; ?>
        <?php endforeach; ?>
        </div>
    </div>

    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>