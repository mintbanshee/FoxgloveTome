<?php
require_once __DIR__ . '/../../auth/require_login.php';
include __DIR__ . '/../header.php';
?>

<h2>New Journal Entry</h2>

<form action="../../controllers/entry_controller.php?action=create" method="POST">
    <div>
        <label for="title">Title</label><br>
        <input type="text" id="title" name="title" required>
    </div>

    <br>

    <div>
        <label for="content">Entry</label><br>
        <textarea id="content" name="content" rows="8" cols="50" required></textarea>
    </div>

    <br>

   <!-- Select Mood Category / changes moods in dropdown -->
    <div>
        <p>Select a mood category:</p>

        <div class="mood-category-icons">
            <button type="button" class="mood-icon-btn" data-category="Blooming">
                <img src="../../assets/images/categories/Blooming.png" alt="Blooming mood category" width="80">
            </button>

            <button type="button" class="mood-icon-btn" data-category="Rooted">
                <img src="../../assets/images/categories/Rooted.png" alt="Rooted mood category" width="80">
            </button>

            <button type="button" class="mood-icon-btn" data-category="Wilted">
                <img src="../../assets/images/categories/Wilted.png" alt="Wilted mood category" width="80">
            </button>

            <button type="button" class="mood-icon-btn" data-category="Prickly">
                <img src="../../assets/images/categories/Prickly.png" alt="Prickly mood category" width="80">
            </button>
        </div>
    </div>

    <br>

    <input type="hidden" id="mood_category" name="mood_category" required>

<!-- Mood dropdown - moods available in dropdown change based on category selected above -->

    <div>
        <label for="mood">Select your mood:</label><br>
        <select id="mood" name="mood" required disabled>
            <option value="">-- Choose a category first --</option>
        </select>
    </div>

    <br>

    <button type="submit">Save Entry</button>
</form>

<script>
  // mood options 
const moodOptions = {
    Blooming: ["Joyful", "Hopeful", "Excited", "Proud", "Loved", "Happy", "Optimistic", "Accomplished", "Strong", "Condfident", "Inspired"],
    Rooted: ["Calm", "Grounded", "Content", "Peaceful", "Stable", "Grateful", "Focused", "Resilient", "Balanced", "Secure", "Safe"],
    Wilted: ["Sad", "Drained", "Lonely", "Heavy", "Tired", "Disappointed", "Hopeless", "Discouraged", "Vulnerable", "Confused", "Helpless"],
    Prickly: ["Anxious", "Frustrated", "Overwhelmed", "Restless", "Irritated", "Stressed", "Agitated", "Traumatized", "Nervous", "Uncomfortable"]
};

// category selection and mood dropdown population
const categoryButtons = document.querySelectorAll(".mood-icon-btn");
const moodCategoryInput = document.getElementById("mood_category");
const moodSelect = document.getElementById("mood");

// update the dropdown based on the category selected 
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

<?php include __DIR__ . '/../../footer.php'; ?>