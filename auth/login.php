<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../views/header.php';

?>
<div class="loginBG">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">

      <div class="loginCard p-4">

        <h1 class="login-title">Login</h1>

        <form method="post" action="<?= BASE_URL ?>controllers/auth_controller.php?action=login">

            <div class="mb-3 text-start">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-light rounded-pill px-4">
                Log In
            </button>

            <p class="mt-3 mb-1">Don’t have an account?</p>

<a href="<?= BASE_URL ?>controllers/auth_controller.php?action=signup" 
   class="btn btn-outline-light rounded-pill px-4 mt-2">
    Sign Up
</a>

        </form>

    </div>
    </div>
</div>
</div>

<?php include __DIR__ . '/../views/footer.php'; ?>