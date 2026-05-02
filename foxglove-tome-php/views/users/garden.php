<?php

// *~*~*~*~*~*~* USER GARDEN VIEW *~*~*~*~*~*~*

require_once __DIR__ . '/../../auth/require_login.php';
require_once __DIR__ . '/../../models/Garden.php';
require_once __DIR__ . '/../../models/User.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../header.php';

// allows admin to view user's garden by passing user id in query string, otherwise shows logged in user's garden
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
$requestedUserId = (int) ($_GET['id'] ?? 0);

// if admin and valid user id provided, show that user's garden, otherwise show logged in user's garden
if ($isAdmin && $requestedUserId > 0) {
    $userId = $requestedUserId;
    $isAdminView = true;
    $userModel = new User();
    $viewedUser = $userModel->getUserById($userId);
 
} else {
    $userId = $_SESSION['user']['user_id'];
    $isAdminView = false;
}

$garden = new Garden();

// get entries for the month by week to determine which flower to show in each planter
$entriesByWeek = $garden->getMonthlyEntriesByWeek($userId);
$weeklyFlowers = [];

foreach ([1, 2, 3, 4] as $weekNumber) {
    $weekEntries = $entriesByWeek[$weekNumber] ?? [];

    if (empty($weekEntries)) {
        $weeklyFlowers[] = null;
        continue;
    }

    $categoryCounts = [];

    // count the occurrences of each mood category for the week
    foreach ($weekEntries as $entry) {
        $category = $entry['mood_category'] ?? '';
        if (!isset($categoryCounts[$category])) {
            $categoryCounts[$category] = 0;
        }
        $categoryCounts[$category]++;
    }

    // sort categories by count in descending order to find the dominant mood category for the week
    arsort($categoryCounts);
    $dominantCategory = array_key_first($categoryCounts);

    // assign a flower image path based on the dominant mood category for the week
    switch ($dominantCategory) {
        case 'Blooming':
            $weeklyFlowers[] = BASE_URL . 'assets/images/flowers/BlueIris300.png';
            break;
        case 'Rooted':
            $weeklyFlowers[] = BASE_URL . 'assets/images/flowers/Lavender300.png';
            break;
        case 'Wilted':
            $weeklyFlowers[] = BASE_URL . 'assets/images/flowers/Chrysanthemum300.png';
            break;
        case 'Prickly':
            $weeklyFlowers[] = BASE_URL . 'assets/images/flowers/Petunia300.png';
            break;
        default:
            $weeklyFlowers[] = null;
            break;
    }
}
?>

<!--*~*~*~*   The Garden Display    *~*~*~*-->

<div id="gardenIntro" class="container py-5">
    <h1 class="formHeader text-center mb-3">
        <!--*~*~*~*   Show username if admin    *~*~*~*-->
        <?= $isAdmin && isset($viewedUser)
            ? htmlspecialchars($viewedUser['username']) . "'s Garden" : "My Garden" ?>
    </h1>

    <!--*~*~*~*   Change the text based on user or admin    *~*~*~*-->
    <p class="text-center mb-3">
        <?php if ($isAdminView): ?>
            A read-only view of this month’s garden pattern.
        <?php else: ?>
            Watch your garden bloom as you nurture it with your thoughts and feelings!
        <?php endif; ?>
    </p>

    <!--*~*~*~*   Garden description    *~*~*~*-->
    <small class="text-muted d-block text-center mb-4">
        Each planter represents a week in the month and grows a flower for your average mood category 🌸</small>

        <!--*~*~*~*   Empty state    *~*~*~*-->
    <?php if (empty($weeklyFlowers)): ?>
        <div class="alert alert-light border text-center mt-4">
            Your garden will begin to bloom as you write entries 🌿
        </div>
    <?php else: ?>

        <!--*~*~*~*   Place the flowers in the planters    *~*~*~*-->
    <div id="gardenSnapshot" class="garden">
        <div class="gardenPlants">
            <?php $position = 1; ?>
            <?php 
            // for each flower in the array check if it is an image path or temporary emoji
            // and assign appropriate class for styling
            foreach ($weeklyFlowers as $flower): ?>

                <?php
                // determine the css class 
                $flowerClass = '';

                // if the $flower is an image path, assign a class based on the type of flower
                /* illustrated assets have different spacing and sizing so I need to add css 
                     for each flower type through individual classes */
                if (str_contains($flower, 'Chrysanthemum')) {
                    $flowerClass = 'flower-wilted';
                } else if (str_contains($flower, 'Petunia')) {
                    $flowerClass = 'flower-prickly';
                } else if (str_contains($flower, 'BlueIris')) {
                    $flowerClass = 'flower-blooming';
                  } else if (str_contains($flower, 'Lavender')) {
                    $flowerClass = 'flower-rooted';
                }
                ?>

                <div class="gardenPlant pos<?= $position ?> <?= $flowerClass ?>">
                    <?php 

                    // if the $flower is an image path, display the image, otherwise display the temporary emoji in a span
                    if (str_contains($flower, '.png')): ?>
                        <img src="<?= htmlspecialchars($flower) ?>" alt="Mood flower" class="flower flowerImage">
                    <?php else: ?>
                        <span class="flower"><?= htmlspecialchars($flower) ?></span>
                    <?php endif; ?>
                </div>

                <?php 
                // increment position for next plant
                $position++; ?>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php endif; ?>
</div>

<!-- bottom nav -->

<nav class="navbar fixed-bottom navbar-sanctuary navbar-dark border-top d-flex align-items-center" style="height:70px;">
  <div class="container-fluid justify-content-around align-items-center">

    <?php if (!$isAdminView): ?>
        <button type="button" id="saveGardenBtn" class="btn btn-light btn-outline-primary rounded-pill px-3">
            Save Image
        </button>
    <?php endif; ?>
    
    <?php if ($isAdminView): ?>
        <a class="btn btn-light btn-outline-success rounded-pill px-3"
            href="<?= BASE_URL ?>controllers/admin_controller.php?action=editUser&id=<?= $userId ?>">
            Back to Manage User
        </a>
    <?php else: ?>
        <a class="btn btn-light btn-outline-success rounded-pill px-3"
            href="<?= BASE_URL ?>views/users/user_dashboard.php">
            Dashboard
        </a>
    <?php endif; ?>

  </div>
</nav>

<!-- script to save garden image -->

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const saveBtn = document.getElementById('saveGardenBtn');
    const garden = document.getElementById('gardenSnapshot');

    // Only add event listener if there is a garden to save
    if (saveBtn && garden) {
        saveBtn.addEventListener('click', async function () {

            // Use html2canvas to capture the garden div as an image
            const canvas = await html2canvas(garden, {
                useCORS: true,
                scale: 2,
                backgroundColor: null
            });

            // Create a link to download the image  
            const link = document.createElement('a');
            // Name the file with a timestamp for uniqueness
            link.download = 'GardenMoodTracker' + new Date().toISOString().slice(0,10) + '.png';
            // Convert the canvas to a data URL and set it as the link's href
            link.href = canvas.toDataURL('image/png');
            // click the button to trigger the download via the created link
            link.click();

            // Show confirmation modal
            const savedGardenModal = new bootstrap.Modal(document.getElementById('savedGardenModal'));
            savedGardenModal.show();

            // return save image button to normal state after click
            saveBtn.blur();
        });
    }
});
</script>

<!-- image saved confirmation modal and script --> 
<div class="modal fade" id="savedGardenModal" tabindex="-1" aria-labelledby="savedGardenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content gardenModal">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title mb-3" id="savedGardenModalLabel">Your image has been saved!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-2 text-center">
                <small>It can be found with your downloads</small>
            </div>

            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include __DIR__ . '/../footer.php'; ?>