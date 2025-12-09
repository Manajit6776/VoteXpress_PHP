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
<html>

<head>
    <title>Voter Login | VoteXpress</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="login-page">
    <div class="login-container">
        <h2>Log in</h2>
        <form action="voterlogin.php" method="POST">
            <div class="form-group">
                <i class="fas fa-user icon"></i>
                <input type="text" name="voters_id" class="input" placeholder="Voters ID" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock icon"></i>
                <input type="password" name="password" class="input" placeholder="Password" required>
            </div>
            <div class="form-actions">
                <button type="submit" name="login" class="button is-primary">Log in</button>
            </div>
        </form>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p class="help is-danger">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        ?>
    </div>
</body>

</html>