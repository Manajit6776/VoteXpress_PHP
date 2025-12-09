<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}
include '../db_connect.php';

$message = '';
if (isset($_POST['save_title'])) {
    $new_title = $_POST['title'];
    $update_sql = "UPDATE election_title SET title = '$new_title' WHERE id = 1";
    if ($conn->query($update_sql)) {
        $message = 'Election title updated successfully!';
    } else {
        $message = 'Error updating title: ' . $conn->error;
    }
}

$election_title_query = $conn->query("SELECT title FROM election_title WHERE id = 1");
$current_title = $election_title_query->fetch_assoc()['title'] ?? 'Online Voting System';

include '../includes/admin_header.php';
?>
<div class="header">
    <h2>Configure Election Title</h2>
</div>
<div class="content-box">
    <?php if ($message): ?>
        <p class="success-msg"><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="election_title.php" method="POST">
        <label for="title">Election Title</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($current_title); ?>" required>
        <button type="submit" name="save_title">Save Title</button>
    </form>
</div>
<?php include '../includes/admin_footer.php'; ?>