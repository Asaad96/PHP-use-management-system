<?php
session_start();
require_once 'includes/db.php';

//  to check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$message = "";

// submits form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    //  Validation 
    if (!$name || !$phone || !$email) {
        $message = "All fields except password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } else {
        try {
            // Check duplicates 
            $stmt = $pdo->prepare("SELECT * FROM users WHERE (email = ? OR phone = ?) AND id != ?");
            $stmt->execute([$email, $phone, $user['id']]);
            $existing = $stmt->fetch();

            if ($existing) {
                $message = "Email or phone already in use.";
            } else {
                // Update user info
                if ($password) {
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $update = $pdo->prepare("UPDATE users SET name=?, phone=?, email=?, password=? WHERE id=?");
                    $update->execute([$name, $phone, $email, $hashed, $user['id']]);
                } else {
                    $update = $pdo->prepare("UPDATE users SET name=?, phone=?, email=? WHERE id=?");
                    $update->execute([$name, $phone, $email, $user['id']]);
                }

                // Refresh session data
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
                $stmt->execute([$user['id']]);
                $_SESSION['user'] = $stmt->fetch();

                $message = "Profile updated successfully!";
            }
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white text-center">
                <h4>Edit Profile</h4>
            </div>
            <div class="card-body">
                <?php if ($message): ?>
                    <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password (optional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep old password">
                    </div>

                    <button type="submit" class="btn btn-success w-100">Save Changes</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="profile.php" class="btn btn-outline-primary">Back to Profile</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
