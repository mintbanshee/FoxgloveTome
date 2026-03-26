<?php 
declare(strict_types=1); 

include __DIR__ . '/../views/header.php';
?>


<div class="signupBG">
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-10 col-md-6 col-lg-4">
      <div class="loginCard p-4">

        <h1 class="login-title">Create an Account</h1>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="<?= BASE_URL ?>controllers/auth_controller.php?action=signup">
    
    <div class="mb-3 text-start">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" placeholder="optional" value="<?= htmlspecialchars($first ?? '') ?>">
    </div>

    <div class="mb-3 text-start">
        <label class="form-label">Last Name</label>
        <input  type="text" 
                name="last_name" 
                class="form-control" 
                placeholder="optional" 
                value="<?= htmlspecialchars($last ?? '') ?>">
    </div>

    <div class="mb-3 text-start">
        <label class="form-label">Username</label>
        <input  type="text" 
                name="username" 
                class="form-control" 
                required>
    </div>

    <div class="mb-3 text-start">
        <label class="form-label">Email</label>
        <input  type="email" 
                name="email" 
                class="form-control" 
                value="<?= htmlspecialchars($email ?? '') ?>" 
                required>
    </div>

    <div class="mb-3 text-start">
        <label class="form-label">Password</label>
        <input  type="password" 
                name="password" 
                class="form-control" 
                required>
    </div>

    <div class="mb-3 text-start">
        <label class="form-label">Confirm Password</label>
        <input  type="password" 
                name="confirm_password" 
                class="form-control" 
                required>
    </div>

    <button type="submit" class="btn btn-light rounded-pill px-4">Create Account</button>
</form>

<p class="mt-3 mb-1">Already have an account?</p>
<a href="<?= BASE_URL ?>controllers/auth_controller.php?action=login"
    class="btn btn-outline-light rounded-pill px-4 mt-2">
    Log in
</a>

</body>
</html>