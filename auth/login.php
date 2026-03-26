<?php 
declare(strict_types=1); 

?>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>




<body class="login-page">

<div class="login-card">

    <h1 class="login-title">Login</h1>
    <h3 class="mb-4">The Foxglove Tome</h3>

    <form method="post" action="<?= BASE_URL ?>controllers/auth_controller.php?action=login">

        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="email" required>
        </div>

        <div class="mb-4">
            <input type="password" name="password" class="form-control" placeholder="password" required>
        </div>

        <button type="submit" class="btn btn-light rounded-pill px-4 mb-3">
            Log In
        </button>
    </form>

    <p class="mb-2">Don't have a garden yet?</p>
    <a href="<?= BASE_URL ?>controllers/auth_controller.php?action=signup" class="btn btn-outline-light rounded-pill px-3">
        Sign Up
    </a>

    <p class="mt-4 small">
        Your mind is a garden, your thoughts are the seeds...<br>
        You can grow flowers or you grow weeds.
    </p>

</div>

</body>