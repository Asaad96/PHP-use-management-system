<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5 text-center">
    <h1 class="mb-4">Welcome to Our Website</h1>

    <?php if (isset($_SESSION['user_id'])): ?>
      <p>Hello, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong> </p>
      <a href="profile.php" class="btn btn-primary me-2">Profile</a>
      <a href="logout.php" class="btn btn-outline-danger">Log Out</a>
    <?php else: ?>
      <a href="register.php" class="btn btn-success me-2">Register</a>
      <a href="login.php" class="btn btn-primary">Login</a>
    <?php endif; ?>
  </div>
</body>
</html>
