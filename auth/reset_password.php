<?php 
declare(strict_types=1); 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>

<h1>Reset Password</h1>

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

<form method="post" action="<?= BASE_URL ?>controllers/auth_controller.php?action=reset_password">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">

    <label>New Password</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirm New Password</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Reset Password</button>
</form>

<p><a href="<?= BASE_URL ?>controllers/auth_controller.php?action=login">Back to login</a></p>

</body>
</html>