<?php
session_start();
include '../db_connect.php';

if (isset($_POST['login'])) {
    $voters_id = $_POST['voters_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM voters WHERE voters_id = '$voters_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['voter'] = $row['voters_id'];
            header('location: ballot.php');
            exit();
        } else {
            $_SESSION['error'] = 'Incorrect password.';
        }
    } else {
        $_SESSION['error'] = 'Cannot find user with that ID.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Access Portal - VoteXpress</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .auth-logo {
            width: 80px;
            height: 80px;
            background: rgba(0, 245, 155, 0.1);
            color: var(--accent-green);
            border: 1.5px solid rgba(0, 245, 155, 0.3);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 20px var(--accent-green-glow);
        }
    </style>
</head>

<body class="auth-page">
    <div class="bg-glow glow-top-right"></div>
    <div class="bg-glow glow-bottom-left" style="background: radial-gradient(circle, var(--accent-green-glow) 0%, transparent 70%);"></div>

    <div class="auth-card animate-up">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-user-circle"></i>
            </div>
            <h1 style="font-size: 2rem; margin-bottom: 0.5rem; color: #fff;">Voter Access</h1>
            <p style="color: var(--text-mid); font-size: 0.95rem;">Please enter your secure credentials to proceed.</p>
        </div>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <span>' . htmlspecialchars($_SESSION['error']) . '</span>
            </div>';
            unset($_SESSION['error']);
        }
        ?>

        <form action="voterlogin.php" method="POST">
            <div class="form-group">
                <label class="form-label">Voter Unique ID</label>
                <div style="position: relative;">
                    <i class="fas fa-id-card" style="position: absolute; left: 1rem; top: 1.1rem; color: var(--text-low);"></i>
                    <input type="text" name="voters_id" class="form-input" style="padding-left: 2.8rem;" placeholder="e.g. VOTE-2024-X-01" required>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label">Secure PIN / Password</label>
                <div style="position: relative;">
                    <i class="fas fa-key" style="position: absolute; left: 1rem; top: 1.1rem; color: var(--text-low);"></i>
                    <input type="password" name="password" class="form-input" style="padding-left: 2.8rem;" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" name="login" class="btn btn-secondary" style="width: 100%; padding: 1rem; font-size: 1.1rem; border-radius: var(--radius-lg);">
                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i> Authenticate & Enter
            </button>
        </form>

        <div style="margin-top: 2.5rem; text-align: center; border-top: 1px solid var(--glass-border); padding-top: 2rem;">
            <a href="../index.php" style="color: var(--text-low); font-size: 0.9rem; font-weight: 500; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-arrow-left"></i> Return to Main Gate
            </a>
        </div>
    </div>
</body>

</html>