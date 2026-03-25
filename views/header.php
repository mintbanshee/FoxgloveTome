<?php 
require_once __DIR__ . '/../config/app.php'; 

// if (session_status() === PHP_SESSION_NONE) session_start(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/scss/app.scss">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/garden.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=MonteCarlo&display=swap" rel="stylesheet">
  <title>The Foxglove Tome</title>
</head>


<body class="bg-light">

<nav class="navbar navbar-sanctuary navbar-dark">
  <div class="container-fluid">

    <!-- logo -->
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
      <img src="<?php echo BASE_URL; ?>assets/logo/FoxgloveTome.svg"
           alt="Foxglove tome logo"
           width="40" height="40">
    </a>

    <!-- dashboard button (always visible) -->
    <div class="ms-auto">
      <a href="<?= BASE_URL ?>views/users/user_dashboard.php">
        <img src="<?php echo BASE_URL; ?>assets/images/icons/accountWhite.png"
             alt="Dashboard"
             width="40" height="40">
      </a>
    </div>

  </div>
</nav>
