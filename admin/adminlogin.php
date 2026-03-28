<?php
session_start();
include '../db_connect.php';

// Check if the user is already logged in
if (isset($_SESSION['admin'])) {
    header('location: dashboard.php');
    exit();
}

if (isset($_POST['login'])) {
    // Sanitize and validate input
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password using password_verify
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $row['id'];
            header('location: dashboard.php');
            exit();
        } else {
            $_SESSION['error'] = 'Incorrect password.';
        }
    } else {
        $_SESSION['error'] = 'Cannot find user with that username.';
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Command Center - VoteXpress</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="auth-page">
    <div class="bg-glow glow-top-right" style="opacity: 0.5;"></div>
    <div class="bg-glow glow-bottom-left" style="opacity: 0.2;"></div>

    <div class="auth-card animate-up">
        <div class="auth-header">
            <div class="auth-logo" style="background: rgba(255, 59, 59, 0.1); color: var(--accent-red); border: 1.5px solid rgba(255, 59, 59, 0.3);">
                <i class="fas fa-user-shield"></i>
            </div>
            <h1 style="font-size: 2rem; margin-bottom: 0.5rem; color: #fff;">Admin Login</h1>
            <p style="color: var(--text-mid); font-size: 0.95rem;">Command center access for authorized personnel.</p>
        </div>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-error">
                <i class="fas fa-shield-halved"></i>
                <span>' . htmlspecialchars($_SESSION['error']) . '</span>
            </div>';
            unset($_SESSION['error']);
        }
        ?>

        <form action="adminlogin.php" method="POST">
            <div class="form-group">
                <label class="form-label">Administrator ID</label>
                <div style="position: relative;">
                    <i class="fas fa-user-tag" style="position: absolute; left: 1rem; top: 1.1rem; color: var(--text-low);"></i>
                    <input type="text" name="username" class="form-input" style="padding-left: 2.8rem;" placeholder="e.g. root_admin" required>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 2.5rem;">
                <label class="form-label">Secure Access Key</label>
                <div style="position: relative;">
                    <i class="fas fa-lock" style="position: absolute; left: 1rem; top: 1.1rem; color: var(--text-low);"></i>
                    <input type="password" name="password" class="form-input" style="padding-left: 2.8rem;" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" name="login" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.1rem; border-radius: var(--radius-lg);">
                <i class="fas fa-unlock-alt" style="margin-right: 10px;"></i> Initialize Dashboard
            </button>
        </form>

        <div style="margin-top: 2.5rem; text-align: center; border-top: 1px solid var(--glass-border); padding-top: 2rem;">
            <a href="../index.php" style="color: var(--text-low); font-size: 0.9rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-house-user"></i> Return to Public Site
            </a>
        </div>
    </div>
</body>

</html>