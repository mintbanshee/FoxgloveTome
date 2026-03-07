<?php 
require_once __DIR__ . '/../../auth/require_login.php'; 
include __DIR__ . '/../../header.php';
?>

<h1>Admin Dashboard</h1>

<p>Welcome <?= htmlspecialchars($_SESSION['user']['name']) ?></p>
<p>Your role: <?= htmlspecialchars($_SESSION['user']['role']) ?></p>

<a href="<?= BASE_URL ?>controllers/auth_controller.php?action=logout">Logout</a>