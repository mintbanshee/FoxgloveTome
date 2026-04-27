<?php require __DIR__ . '/views/header.php'; ?>

<div class="container-fluid p-0">
    <section id="heroSection" class="text-center d-flex flex-column justify-content-center align-items-center">

        <div id="welcomeTitle" class="w-100 py-3">
            <h1 class="display-4 montecarlo-regular">The Foxglove Tome</h1>
            <p class="lead mb-0">A Digital Sanctuary for Mental Wellness</p>
        </div>

        <div class="container mt-5">
            <p id="welcomeMessage" class="lead fw-bold text-white">
                A gentle space to reflect, track your moods, and nurture your inner garden.
            </p>

            <a href="<?= BASE_URL ?>controllers/auth_controller.php?action=login"
               class="btn btn-light btn-outline-dark btn-lg rounded-pill px-4 mt-3">
                Login
            </a>
        </div>
    </section>
</div>

<section class="container py-4 text-center">
    <h2 class="mb-2">Features</h2>
    <p class="adminFlourish"><sub>⟡</sub>☾<sup>⟡</sup></p>
    <p class="subtitle text-muted mb-3">
        A digital sanctuary designed to feel gentle, not overwhelming.
    </p>
    <p class="adminFlourish mb-3">✦ ━━ ⟡ ━━ ✦</p>

       <div class="row g-4">

        <div class="col-md-4">
            <h5 class="featureTitle">Write Freely</h5>
            <p>Capture your thoughts in a private, calming space designed for reflection.</p>
            <p>Create, edit, and revisit entries as your story unfolds over time.</p>
        </div>

        <div class="col-md-4">
            <h5 class="featureTitle">Understand Your Emotions</h5>
            <p>Select from thoughtfully organized mood categories to describe how you're feeling.</p>
            <p>Simple, clear, and never overwhelming.</p>
        </div>

        <div class="col-md-4">
            <h5 class="featureTitle">Watch Your Garden Grow</h5>
            <p>Your emotional journey becomes a living garden.</p>
            <p>Each week blooms into a hand-crafted flower based on your mood patterns.</p>
            <p>Each flower is thoughtfully illustrated to reflect its emotional meaning.</p>
        </div>

        <div class="col-md-4">
            <h5 class="featureTitle">See Your Weekly Patterns</h5>
            <p>Receive a gentle summary of your most common mood each week.</p>
            <p>Paired with thoughtful reflections to guide you forward.</p>
        </div>

        <div class="col-md-4">
            <h5 class="featureTitle">Keep Your Thoughts Safe</h5>
            <p>Your journal belongs to you.</p>
            <p>Secure accounts ensure your reflections remain private and protected.</p>
        </div>

        <div class="col-md-4">
            <h5 class="featureTitle">Designed for Comfort</h5>
            <p>A calm, welcoming interface that feels like a sanctuary.</p>
            <p>Built to be simple, supportive, and easy to return to.</p>
        </div>

        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>controllers/auth_controller.php?action=signup"
               class="btn btn-lg btn-outline-dark rounded-pill px-3 mt-1">
                Begin Your Journey
            </a>
        </div>

    </div>
</section>

<?php require __DIR__ . '/views/footer.php'; ?>