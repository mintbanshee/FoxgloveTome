<?php 
declare(strict_types=1); 

include __DIR__ . '/../views/header.php';

?>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<div class="loginBG">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">

        <div class="loginCard p-4">

            <h1 class="login-title mb-4">Forgot Your Password?</h1>

            <form method="post" action="<?= BASE_URL ?>controllers/auth_controller.php?action=forgot_password">
    
                <div class="mb-2 text-start">
                    <label class="form-text text-white mb-4">Enter your email address below and we'll send you a link to reset your password.</label>
                    <input type="email" name="email" class="form-control" placeholder="email" required>
                </div>

                <button type="submit" class="btn btn-light rounded-pill px-4 mt-4 w-100">Send Reset Link</button>
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