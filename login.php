<?php


require_once __DIR__ . '/includes/db.php';
session_start();

$message = ''; //  login error or success

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? ''); // for email or phone
    $password = $_POST['password'] ?? '';

    if (!$identifier || !$password) {
        $message = " Please fill in both fields.";
    } else {
        // to check email ^ phone
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
        $stmt->execute([$identifier, $identifier]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Login success
            $_SESSION['user'] = $user;
            header("Location: profile.php");
            exit;
        } else {
            $message = " Invalid login credentials.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Yandex SmartCaptcha -->
    <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="col-md-5 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>User Login</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['logged_out'])): ?>
                        <div class="alert alert-success text-center">You have been logged out successfully.</div>
                        <script>
                            // remove ?logged_out=1 from URL after showing the message
                            if (window.history.replaceState) {
                                const url = new URL(window.location);
                                url.searchParams.delete('logged_out');
                                window.history.replaceState({}, document.title, url.pathname);
                            }
                        </script>
                    <?php endif; ?>

                    <?php if ($message): ?>
                        <div class="alert alert-info text-center"><?= $message ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Email or Phone</label>
                            <input type="text" name="identifier" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <!--  Yandex SmartCaptcha -->
                        <div class="mb-3 text-center">
                            <div
                                id="captcha-container"
                                class="smart-captcha"
                                data-sitekey="your-yandex-sitekey-here"></div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    Don't have an account? <a href="register.php">Register here</a>.
                </div>
            </div>
        </div>
    </div>

</body>

</html>