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
               class="btn btn-light btn-lg rounded-pill px-4 mt-3">
                Login
            </a>
        </div>

    </section>
</div>

<section class="container py-5 text-center">
    <h2 class="mb-4">Features</h2>

    <div class="row g-4">

        <div class="col-md-4">
            <h5>Interactive Mood Tracker</h5>
            <p>Log your mood with your journal entries and watch your garden grow.</p>
            <p>Each mood corresponds to a unique plant, creating a visual representation of your emotional journey.</p>
        </div>

        <div class="col-md-4">
            <h5>Security</h5>
            <p>A safe, calming space to write freely and reflect on your thoughts.</p>
            <p>Your entries are personal and protected, your garden belongs only to you.</p>
        </div>

        <div class="col-md-4">
            <h5>Mindful Prompts</h5>
            <p>Receive planting suggestions based on your entered mood to encourage healing.</p>
            <p>Journal prompts designed to inspire self-reflection and growth.</p>
        </div>

        <div class="col-md-4">
            <h5>Expansive Garden of Feelings</h5>
            <p>Cultivate clarity with over 20 moods organized in to 4 categories:</p>
            <p>Prickly, Wilted, Blooming and Rooted.</p>
        </div>

        <div class="col-md-4">
            <h5>Calming Environment</h5>
            <p>A peaceful space where you can express your thoughts and emotions.</p>
            <p>Designed to not feel overwhelming or cluttered, using negative space and earthy tones to keep a gentle environment.</p>
        </div>

        <div class="col-md-4">
            <h5>Inspired by Love</h5>
            <p>Inspired by "What can I build to help my Mum?"</p>
            <p>Using her own journey with mental health as a guide, the creator has made the Foxglove Tome a labor of love meant to provide comfort and support to others.</p>
        </div>
        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>controllers/auth_controller.php?action=signup" class="btn btn-dark btn-lg rounded-pill px-4 mt-3">
                Sign Up Now
            </a>
        </div>

</section>

<?php require __DIR__ . '/views/footer.php'; ?>