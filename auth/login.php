<?php 
declare(strict_types=1); 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="<?= BASE_URL ?>controllers/auth_controller.php?action=login">
    <label>Email</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Log In</button>
</form>

<p><a href="<?= BASE_URL ?>controllers/auth_controller.php?action=signup">Need an account? Sign up</a></p>
<p><a href="<?= BASE_URL ?>controllers/auth_controller.php?action=forgot_password">Forgot your password?</a></p>

</body>
</html>