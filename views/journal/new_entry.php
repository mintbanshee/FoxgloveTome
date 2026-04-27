<?php
require_once __DIR__ . '/../../auth/require_login.php';
include __DIR__ . '/../header.php';
?>

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


<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="entryFormCard card shadow-sm">
                <div class="card-body p-4">

                    <h1 class="formHeader mb-4 text-center">New Journal Entry</h1>

                    <form id="entryForm" action="<?= BASE_URL ?>controllers/entry_controller.php?action=create" method="POST">
                        <input type="hidden" name="action" value="create">

                        <!-- Title -->
                        <div class="mb-3 text-muted">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>

                        <!-- Select Mood Category -->
                        <div class="mb-4">
                            <p class="fw-semibold mb-3">Select a mood category:</p>

                            <div class="d-flex flex-wrap gap-3 justify-content-center mood-category-icons">
                                <button type="button" class="mood-icon-btn btn p-0 border-0 bg-transparent" data-category="Blooming">
                                    <img src="<?= BASE_URL ?>assets/images/categories/Blooming.png" alt="Blooming mood category" width="50">
                                </button>

                                <button type="button" class="mood-icon-btn btn p-0 border-0 bg-transparent" data-category="Rooted">
                                    <img src="<?= BASE_URL ?>assets/images/categories/Rooted.png" alt="Rooted mood category" width="50">
                                </button>

                                <button type="button" class="mood-icon-btn btn p-0 border-0 bg-transparent" data-category="Wilted">
                                    <img src="<?= BASE_URL ?>assets/images/categories/Wilted.png" alt="Wilted mood category" width="50">
                                </button>

                                <button type="button" class="mood-icon-btn btn p-0 border-0 bg-transparent" data-category="Prickly">
                                    <img src="<?= BASE_URL ?>assets/images/categories/Prickly.png" alt="Prickly mood category" width="50">
                                </button>
                            </div>
                        </div>

                        <input type="hidden" id="mood_category" name="mood_category" required>

                        <!-- Mood dropdown -->
                        <div class="mb-4">
                            <p class="fw-semibold mb-3">Select your mood:</p>
                            <select id="mood" name="mood" class="form-select" required disabled>
                                <option value="">-- Choose a category first --</option>
                            </select>
                        </div>

                        <!-- Journal Entry -->
                        <div class="mb-4 text-muted">
                            <label for="content" class="form-label">Entry</label>
                            <textarea id="content" name="content" rows="8" class="form-control" required></textarea>
                        </div>                         

                    </form>


<!-- Bottom Nav -->
<nav class="navbar fixed-bottom navbar-sanctuary navbar-dark border-top d-flex align-items-center" style="height:70px;">
  <div class="container-fluid justify-content-around align-items-center">

    <a class="btn btn-light btn-outline-danger rounded-pill px-3" 
        href="<?= BASE_URL ?>views/users/user_dashboard.php">
        Cancel
    </a>

    <button type="submit" 
            form="entryForm"
            class="btn btn-light btn-outline-success rounded-pill px-3">
        Save Entry
    </button>

  </div>
</nav>

                </div>
            </div>

        </div>
    </div>
</div>



<script>
const moodOptions = {
    Blooming: ["Joyful", "Hopeful", "Excited", "Proud", "Loved", "Happy", "Optimistic", "Accomplished", "Strong", "Confident", "Inspired"],
    Rooted: ["Calm", "Grounded", "Content", "Peaceful", "Stable", "Grateful", "Focused", "Resilient", "Balanced", "Secure", "Safe"],
    Wilted: ["Sad", "Drained", "Lonely", "Heavy", "Tired", "Disappointed", "Hopeless", "Discouraged", "Vulnerable", "Confused", "Helpless"],
    Prickly: ["Anxious", "Frustrated", "Overwhelmed", "Restless", "Irritated", "Stressed", "Agitated", "Traumatized", "Nervous", "Uncomfortable"]
};

const categoryButtons = document.querySelectorAll(".mood-icon-btn");
const moodCategoryInput = document.getElementById("mood_category");
const moodSelect = document.getElementById("mood");

categoryButtons.forEach(button => {
    button.addEventListener("click", () => {
        const category = button.dataset.category;

        moodCategoryInput.value = category;
        moodSelect.innerHTML = '<option value="">-- Select a mood --</option>';
        moodSelect.disabled = false;

        const moods = moodOptions[category].sort();

        moods.forEach(mood => {
            const option = document.createElement("option");
            option.value = mood;
            option.textContent = mood;
            moodSelect.appendChild(option);
        });

        categoryButtons.forEach(btn => btn.classList.remove("selected"));
        button.classList.add("selected");
    });
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>