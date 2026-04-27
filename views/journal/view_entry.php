<?php
require_once __DIR__ . '/../../auth/require_login.php';
require_once __DIR__ . '/../../models/MoodIcons.php';

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

    <!-- Entry Details -->
    <div class="detailsCard card shadow-sm">
        <div class="card-body text-center">
            <small class="text-muted">
                <?= htmlspecialchars($entry['date_created']) ?>
            </small>
                <h1 class="mb-3">
                    <?= htmlspecialchars($entry['title']) ?>                
                </h1>
        
                <?php $iconPath = getMoodIcon($entry['mood_category']); ?>
                    <p class="moodRow mb-3 text-muted align-items-center justify-content-center d-flex">
            
                        <?php if (!empty($iconPath)): ?>
                            <img
                                src="<?= htmlspecialchars($iconPath) ?>"
                                alt="<?= htmlspecialchars($entry['mood_category']) ?>"
                                class="moodIcon">
                        <?php endif; ?>
                        <span class="moodText">
                            <?= htmlspecialchars($entry['mood_category']) ?> -
                            <?= htmlspecialchars($entry['mood']) ?>
                        </span>
                    </p>
        </div>
    </div>
    <hr>

    <!-- Entry Content -->

    <div class="contentCard card shadow-sm">
        <div class="card-body">
            
            <p>
                <?= nl2br(htmlspecialchars($entry['content'])) ?>
            </p>

        </div>
    </div>

</div>

<!-- Bottom Nav -->
<nav class="navbar fixed-bottom navbar-sanctuary navbar-dark border-top d-flex align-items-center" style="height:70px;">
  <div class="container-fluid justify-content-around align-items-center">

    <a class="btn btn-light btn-outline-success rounded-pill px-3" 
        href="<?= BASE_URL ?>views/users/user_dashboard.php">
        Dashboard
    </a>

    <button type="button"
        class="btn btn-light btn-outline-danger rounded-pill px-3 deleteTrigger"
        data-bs-toggle="modal"
        data-bs-target="#deleteEntryModal"
        data-entry-id="<?= $entry['entry_id'] ?>">
        Delete
    </button>

    <a href="<?= BASE_URL ?>controllers/entry_controller.php?action=edit_entry&id=<?= $entry['entry_id'] ?>"
        class="btn btn-light btn-outline-primary rounded-pill px-3">
        Edit Entry
    </a>

  </div>
</nav>



<!-- Delete Confirmation Modal and Script -->

<div class="modal fade" id="deleteEntryModal" tabindex="-1" aria-labelledby="deleteEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content foxgloveDeleteModal">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title mb-3" id="deleteEntryModalLabel">Delete Entry?</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-2 text-center">
                <p>Are you sure you want to remove this entry from your tome?</p>
                <small>This cannot be undone.</small>
            </div>

            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Keep Entry</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-outline-light rounded-pill px-4">Delete Entry</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.deleteTrigger');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const entryId = this.dataset.entryId;
            confirmDeleteBtn.href = "<?= BASE_URL ?>controllers/entry_controller.php?action=delete&id=" + entryId;
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include __DIR__ . '/../footer.php'; ?>