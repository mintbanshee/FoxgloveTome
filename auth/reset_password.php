<?php 
declare(strict_types=1); 

require_once __DIR__ . '/../config/app.php';

include __DIR__ . '/../views/header.php';
?>

<div class="loginBG">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">

        <div class="loginCard p-4">

            <h1 class="login-title mb-4">Set A New Password</h1>
            <p class="text-white small mb-3">
                Choose a new password to access the tome.
            </p>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <div><?= htmlspecialchars($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <?php if (!empty($message)): ?>
                <p><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <form method="post" action="<?= BASE_URL ?>controllers/auth_controller.php?action=reset_password">

                <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">

                <div class="mb-3 text-start">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-light rounded-pill px-4 mt-3 w-100">
                    Update Password
                </button>

            </form>

            <p class="mt-4">
                <a href="<?= BASE_URL ?>controllers/auth_controller.php?action=login"
                   class="text-light small text-decoration-underline">
                    Back to login
                </a>
            </p>

        </div>
    </div>
</div>
</div>

<?php include __DIR__ . '/../views/footer.php'; ?>