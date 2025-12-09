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
<html>

<head>
    <title>Admin Login | VoteXpress</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h2 class="text-center">Admin Login</h2>
            <p class="text-center">Sign in to start your session</p>
            <form action="adminlogin.php" method="POST">
                <div class="form-group">
                    <i class="fas fa-user icon"></i>
                    <input type="text" name="username" class="input" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <i class="fas fa-lock icon"></i>
                    <input type="password" name="password" class="input" placeholder="Password" required>
                </div>
                <div class="form-actions">
                    <button type="submit" name="login" class="button is-primary">Sign in</button>
                </div>
            </form>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p class="error-msg">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>
</body>

</html><?php
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
<html>

<head>
    <title>Admin Login | VoteXpress</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h2 class="text-center">Admin Login</h2>
            <p class="text-center">Sign in to start your session</p>
            <form action="adminlogin.php" method="POST">
                <div class="form-group">
                    <i class="fas fa-user icon"></i>
                    <input type="text" name="username" class="input" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <i class="fas fa-lock icon"></i>
                    <input type="password" name="password" class="input" placeholder="Password" required>
                </div>
                <div class="form-actions">
                    <button type="submit" name="login" class="button is-primary">Sign in</button>
                </div>
            </form>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p class="error-msg">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>
</body>

</html>