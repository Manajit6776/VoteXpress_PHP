<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}
include '../db_connect.php';

$message = '';
$status = '';
if (isset($_POST['save_title'])) {
    $new_title = $conn->real_escape_string($_POST['title']);
    $update_sql = "UPDATE election_title SET title = '$new_title' WHERE id = 1";
    if ($conn->query($update_sql)) {
        $message = 'Election identity updated successfully.';
        $status = 'success';
    } else {
        $message = 'Protocol Failure: ' . $conn->error;
        $status = 'error';
    }
}

$election_title_query = $conn->query("SELECT title FROM election_title WHERE id = 1");
$current_title = $election_title_query->fetch_assoc()['title'] ?? 'VoteXpress 2025';

include '../includes/admin_header.php';
?>

<div class="flex-responsive" style="justify-content: space-between; align-items: flex-end; margin-bottom: 3rem; gap: 1rem;">
    <div>
        <h1 style="font-size: 2.22rem; margin-bottom: 0.2rem;">Global Branding</h1>
        <p style="color: var(--text-mid); font-size: 0.95rem;">Configure the public-facing identity for the current election cycle.</p>
    </div>
</div>

<?php if ($message): ?>
    <div class="alert alert-<?php echo $status == 'success' ? 'success' : 'error'; ?> animate-up">
        <i class="fas <?php echo $status == 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>"></i>
        <span><?php echo $message; ?></span>
    </div>
<?php endif; ?>

<div class="premium-card animate-up" style="max-width: 600px;">
    <h2 style="font-size: 1.1rem; margin-bottom: 1.5rem; color: var(--text-pure); display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-heading" style="color: var(--accent-red);"></i> Election Identity Configuration
    </h2>
    
    <form action="election_title.php" method="POST">
        <div class="form-group">
            <label class="form-label" for="title">Active Election Name</label>
            <input type="text" name="title" id="title" class="form-input" 
                   value="<?php echo htmlspecialchars($current_title); ?>" 
                   placeholder="e.g. Presidential Election 2025" required>
            <p style="color: var(--text-low); font-size: 0.8rem; margin-top: 0.8rem;">
                This title will appear on the landing page, voter dashboard, and final audit reports.
            </p>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" name="save_title" class="btn btn-primary" style="flex: 1;">
                <i class="fas fa-save"></i> Deploy New Branding
            </button>
        </div>
    </form>
</div>

<?php 
echo '</div>'; // Close content-area
include '../includes/admin_footer.php'; 
?>