<?php
require_once __DIR__ . '/../../auth/require_login.php';
include __DIR__ . '/../header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="entryFormCard card shadow-sm">
                <div class="card-body p-4">

                    <h1 class="formHeader mb-4 text-center">Edit Journal Entry</h1>

                    <form action="<?= BASE_URL ?>controllers/entry_controller.php?action=update_entry" method="POST">
                      <input type="hidden" name="entry_id" value="<?= $entry['entry_id'] ?>">

                        <!-- Title -->
                        <div class="mb-3 text-muted">
                            <label for="title" class="form-label">Title</label>
                            <input 
                              type="text" 
                              id="title" 
                              name="title" 
                              class="form-control"
                              value="<?= htmlspecialchars($entry['title']) ?>" 
                              required>
                        </div>

                        <!-- Select Mood Category -->
                        <div class="mb-4">
                          <p class="fw-semibold mb-3">Select a mood category:</p>

                          <div class="d-flex flex-wrap gap-3 justify-content-center mood-category-icons">
                            <button type="button"
                                    class="mood-icon-btn btn p-0 border-0 bg-transparent <?= $entry['mood_category'] === 'Blooming' ? 'selected' : '' ?>"
                                    data-category="Blooming">
                                <img src="<?= BASE_URL ?>assets/images/categories/Blooming.png" alt="Blooming mood category" width="50">
                            </button>

                            <button type="button"
                                    class="mood-icon-btn btn p-0 border-0 bg-transparent <?= $entry['mood_category'] === 'Rooted' ? 'selected' : '' ?>"
                                    data-category="Rooted">
                                <img src="<?= BASE_URL ?>assets/images/categories/Rooted.png" alt="Rooted mood category" width="50">
                            </button>

                            <button type="button"
                                    class="mood-icon-btn btn p-0 border-0 bg-transparent <?= $entry['mood_category'] === 'Wilted' ? 'selected' : '' ?>"
                                    data-category="Wilted">
                                <img src="<?= BASE_URL ?>assets/images/categories/Wilted.png" alt="Wilted mood category" width="50">
                            </button>

                            <button type="button"
                                    class="mood-icon-btn btn p-0 border-0 bg-transparent <?= $entry['mood_category'] === 'Prickly' ? 'selected' : '' ?>"
                                    data-category="Prickly">
                                <img src="<?= BASE_URL ?>assets/images/categories/Prickly.png" alt="Prickly mood category" width="50">
                            </button>
                        </div>
                    </div>

                    <!-- Hidden input to store the selected mood category -->
                    <input type="hidden"
                          id="mood_category"
                          name="mood_category"
                          value="<?= htmlspecialchars($entry['mood_category']) ?>"
                          required>

                        <!-- Mood dropdown -->
                        <div class="mb-4">
                            <p class="fw-semibold mb-3">Select your mood:</p>
                            <select id="mood" name="mood" class="form-select" required>
                                <option value="<?= htmlspecialchars($entry['mood']) ?>" selected>
                                    <?= htmlspecialchars($entry['mood']) ?>
                                </option>
                            </select>
                        </div>

                        <!-- Journal Entry -->
                        <div class="mb-4 text-muted">
                            <label for="content" class="form-label">Entry</label>
                            <textarea 
                            id="content" 
                            name="content" 
                            rows="8" 
                            class="form-control" 
                            required><?= htmlspecialchars($entry['content']) ?></textarea>
                        </div>                        


<!-- Bottom Nav -->  
<nav class="navbar fixed-bottom navbar-sanctuary navbar-dark border-top d-flex align-items-center" style="height:70px;">
  <div class="container-fluid justify-content-around align-items-center">

    <a class="btn btn-light btn-outline-danger rounded-pill px-3" 
        href="<?= BASE_URL ?>views/users/user_dashboard.php">
        Cancel
    </a>

    <button type="submit" class="btn btn-light btn-outline-success rounded-pill px-3">
        Save Entry
    </button>

  </div>
</nav>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>







<script>
const moodOptions = {
    Blooming: ["Joyful", "Hopeful", "Excited", "Proud", "Loved", "Happy", "Optimistic", "Accomplished", "Strong", "Confident", "Inspired"],
    Rooted: ["Calm", "Grounded", "Content", "Peaceful", "Stable", "Grateful", "Focused", "Resilient", "Balanced", "Secure", "Safe"],
    Wilted: ["Sad", "Drained", "Lonely", "Heavy", "Scared", "Tired", "Disappointed", "Hopeless", "Discouraged", "Vulnerable", "Confused", "Helpless"],
    Prickly: ["Anxious", "Angry", "Frustrated", "Overwhelmed", "Restless", "Irritated", "Stressed", "Agitated", "Traumatized", "Nervous", "Uncomfortable"]
};

// mood category and selection
const categoryButtons = document.querySelectorAll(".mood-icon-btn");
const moodCategoryInput = document.getElementById("mood_category");
const moodSelect = document.getElementById("mood");

// mood category button clicks
categoryButtons.forEach(button => {
    button.addEventListener("click", () => {
        const category = button.dataset.category;

        // reset the mood selection when a new category is chosen
        moodCategoryInput.value = category;
        moodSelect.innerHTML = '<option value="">-- Select a mood --</option>';
        moodSelect.disabled = false;

        // have the moods appear in the dropdown in alphabetical order
        const moods = moodOptions[category].sort();

        // the dropdown shows the moods only for the selected category
        moods.forEach(mood => {
            const option = document.createElement("option");
            option.value = mood;
            option.textContent = mood;
            moodSelect.appendChild(option);
        });

        // make the selected category stand out visually
        categoryButtons.forEach(btn => btn.classList.remove("selected"));
        button.classList.add("selected");
    });
});

// show the preselected mood and category when the page loads
const currentCategory = moodCategoryInput.value;
const currentMood = "<?= htmlspecialchars($entry['mood'], ENT_QUOTES) ?>";

if (currentCategory && moodOptions[currentCategory]) {
    moodSelect.innerHTML = '<option value="">-- Select a mood --</option>';
    moodSelect.disabled = false;

    const moods = moodOptions[currentCategory].sort();

    moods.forEach(mood => {
        const option = document.createElement("option");
        option.value = mood;
        option.textContent = mood;

        if (mood === currentMood) {
            option.selected = true;
        }

        moodSelect.appendChild(option);
    });
}

</script>

<?php include __DIR__ . '/../footer.php'; ?>