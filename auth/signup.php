<?php 
declare(strict_types=1); 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body>

<h1>Sign Up</h1>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="<?= BASE_URL ?>controllers/auth_controller.php?action=signup">
    <label>First Name</label><br>
    <input type="text" name="first_name" value="<?= htmlspecialchars($first ?? '') ?>" required><br><br>

    <label>Last Name</label><br>
    <input type="text" name="last_name" value="<?= htmlspecialchars($last ?? '') ?>" required><br><br>

    <label>Username</label><br>
    <input type="text" name="username" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirm Password</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Create Account</button>
</form>

<p><a href="<?= BASE_URL ?>controllers/auth_controller.php?action=login">Already have an account? Log in</a></p>

</body>
</html>