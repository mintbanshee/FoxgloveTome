<?php 
declare(strict_types=1); 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>
<body>

<h1>Forgot Password</h1>

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

<form method="post" action="<?= BASE_URL ?>controllers/auth_controller.php?action=forgot_password">
    <label>Email</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required><br><br>

    <button type="submit">Send Reset Link</button>
</form>

<p><a href="<?= BASE_URL ?>controllers/auth_controller.php?action=login">Back to login</a></p>

</body>
</html>