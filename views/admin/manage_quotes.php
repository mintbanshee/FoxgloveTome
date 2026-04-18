<?php
require_once __DIR__ . '/../../auth/require_admin.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$summaryQuotes = require __DIR__ . '/../../config/quotes.php';

include __DIR__ . '/../header.php';

$selectedCategory = $_GET['category'] ?? 'Blooming';

if (!array_key_exists($selectedCategory, $summaryQuotes)) {
    $selectedCategory = 'Blooming';
}

$categoryQuotes = $summaryQuotes[$selectedCategory];
?>

<div class="container py-4">
    <div class="mb-4 text-center">
        <p class="adminFlourish mb-2"><sub>⟡</sub>☾<sup>⟡</sup></p>
        <h1 class="montecarlo-regular mb-2 fw-bold">Manage Quotes</h1>
        <p class="text-muted">Review the reflections woven throughout the tome.</p>
    </div>

    <div class="card p-3 shadow-sm mb-4">
        <form method="GET" class="mb-3">
            <label for="category" class="form-label">Choose a category</label>
            <select name="category" id="category" class="form-select" onchange="this.form.submit()">
                <?php foreach ($summaryQuotes as $category => $quotes): ?>
                    <option value="<?= htmlspecialchars($category) ?>" <?= $selectedCategory === $category ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

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

    <div class="quotesCard card mb-3 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-3"><?= htmlspecialchars($selectedCategory) ?> Reflections</h4>
                    <a href="#"
                        class="btn btn-xs btn-outline-success rounded-pill">
                        Manage
                    </a>
            </div>                
            <?php foreach ($categoryQuotes as $quote): ?>
              <p class="fst-italic mb-3">“<?= htmlspecialchars($quote) ?>”</p>
            <?php endforeach; ?>
        </div>
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