<?php
require_once __DIR__ . '/../../auth/require_admin.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$summaryQuotes = require __DIR__ . '/../../config/quotes.php';

$categoryClasses = [
    'Blooming' => 'btn-blooming',
    'Rooted' => 'btn-rooted',
    'Wilted' => 'btn-wilted',
    'Prickly' => 'btn-prickly'
];

include __DIR__ . '/../header.php';

?>

<!-- Welcome Message -->
<div class="container py-4">
    <div class="mb-4 text-center">
        <p class="adminFlourish mb-2"><sub>⟡</sub>☾<sup>⟡</sup></p>
        <h1 class="montecarlo-regular mb-2 fw-bold">Manage Quotes</h1>
        <p class="text-muted">Review the reflections woven throughout the tome.</p>
    </div>

    <!-- Category Buttons --> 
    <div class="card p-3 shadow-sm mb-4">
        <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
            <?php foreach ($summaryQuotes as $category => $quotes): ?>
                
                <button
                    type="button"
                    class="btn btn-sm rounded-pill category-btn <?= $categoryClasses[$category] ?? '' ?>"
                    data-category="<?= htmlspecialchars($category) ?>">
                    <?= htmlspecialchars($category) ?>
                </button>
            <?php endforeach; ?>
        </div>

        <label for="futureQuote" class="form-label">Add Reflection</label>
        <input
            type="text"
            id="futureQuote"
            class="form-control"
            placeholder="Add a new reflection (coming soon)"
            disabled
        >
        <small class="text-muted">
            Future versions will allow keepers to add new reflections to the tome.
        </small>
    </div>

    <div id="no-selection" class="text-center text-muted mt-4">
        <p>Select a category to view its reflections 🌿</p>
    </div>

    <!-- Quotes Display -->
    <?php foreach ($summaryQuotes as $category => $quotes): ?>
        <div class="quotes-group d-none" data-category="<?= htmlspecialchars($category) ?>">
            <div class="quotesCard card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-3"><?= htmlspecialchars($category) ?> Reflections</h4>
                        <a href="#"
                            class="btn btn-xs btn-outline-success rounded-pill">
                            Manage
                        </a>
                    </div>

                    <?php foreach ($quotes as $quote): ?>
                        <p class="fst-italic mb-3">“<?= htmlspecialchars($quote) ?>”</p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

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


<!-- Script to handle category button clicks and show/hide quote groups -->
<script>
const categoryButtons = document.querySelectorAll('.category-btn');
const quoteGroups = document.querySelectorAll('.quotes-group');
const emptyMessage = document.getElementById('no-selection');

categoryButtons.forEach(button => {
    button.addEventListener('click', () => {
        const selectedCategory = button.dataset.category;

        quoteGroups.forEach(group => {
            if (group.dataset.category === selectedCategory) {
                group.classList.remove('d-none');
            } else {
                group.classList.add('d-none');
            }
        });

        categoryButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        if (emptyMessage) {
            emptyMessage.classList.add('d-none');
        }
    });
});
</script>




<?php include __DIR__ . '/../footer.php'; ?>