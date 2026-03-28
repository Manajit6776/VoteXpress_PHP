<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}
include '../db_connect.php';

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $description = $conn->real_escape_string($_POST['description']);
    $max_vote = intval($_POST['max_vote']);
    $priority = isset($_POST['priority']) ? intval($_POST['priority']) : 0;

    if ($id > 0) {
        $sql = "UPDATE positions SET description = '$description', max_vote = '$max_vote', priority = '$priority' WHERE id = $id";
        $message = "Position logic updated successfully.";
    } else {
        $sql = "INSERT INTO positions (description, max_vote, priority) VALUES ('$description', '$max_vote', '$priority')";
        $message = "New position registered in the hierarchy.";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = $message;
    } else {
        $_SESSION['error'] = "Protocol Error: " . $conn->error;
    }
    header('location: positions.php');
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($conn->query("DELETE FROM positions WHERE id = $id")) {
        $_SESSION['success'] = "Position removed from active election.";
    } else {
        $_SESSION['error'] = "Deletion Refused: " . $conn->error;
    }
    header('location: positions.php');
    exit();
}

$positions_result = $conn->query("SELECT * FROM positions ORDER BY priority ASC");

include '../includes/admin_header.php';
?>

<div class="flex-responsive" style="justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; gap: 1rem;">
    <div>
        <h1 style="font-size: 2.22rem; margin-bottom: 0.2rem;">Election 2025: Hierarchy</h1>
        <p style="color: var(--text-mid); font-size: 0.95rem;">Configure contested positions and electoral constraints.</p>
    </div>
    <button class="btn btn-primary full-width-mobile" onclick="openModal('addPositionModal')">
        <i class="fas fa-sitemap"></i> Define New Position
    </button>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success animate-up">
        <i class="fas fa-check-circle"></i>
        <span><?php echo $_SESSION['success']; ?></span>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error animate-up">
        <i class="fas fa-shield-virus"></i>
        <span><?php echo $_SESSION['error']; ?></span>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="premium-card" style="padding: 0;">
    <div style="padding: 1.25rem 2rem; border-bottom: 1px solid var(--glass-border);">
        <h2 style="font-size: 1rem; color: var(--text-pure); display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-list-ul" style="color: var(--accent-red); font-size: 0.85rem;"></i> Active Organizational Structure
        </h2>
    </div>

    <div class="table-container" style="margin-top: 0; border: none; border-radius: 0;">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">Priority</th>
                    <th>Official Description</th>
                    <th>Maximum Votes</th>
                    <th style="text-align: right;">Administrative Control</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($positions_result->num_rows > 0): ?>
                    <?php while ($row = $positions_result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <span style="background: var(--bg-hover); color: var(--text-mid); padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.85rem;">
                                    #<?php echo htmlspecialchars($row['priority']); ?>
                                </span>
                            </td>
                            <td style="font-weight: 600; color: var(--text-pure); font-size: 1rem;">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </td>
                            <td>
                                <span class="badge" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2);">
                                    <?php echo htmlspecialchars($row['max_vote']); ?> Max Votes
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                                    <button class="btn btn-outline btn-sm" style="padding: 0.4rem 0.6rem; border-color: rgba(255,255,255,0.1);" 
                                            onclick='openEditModal(<?php echo json_encode($row); ?>)'>
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="positions.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline btn-sm" 
                                       style="padding: 0.4rem 0.6rem; color: var(--accent-red); border-color: rgba(255,59,59,0.15);" 
                                       onclick="return confirm('Immediately purge this position from the system? ALL associated votes and candidates will be affected.');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 4rem; color: var(--text-low);">
                            <i class="fas fa-folder-open" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                            No organizational hierarchy defined yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div> <!-- Close animate-up area -->

<!-- Modals outside animated area -->
<div id="addPositionModal" class="modal-overlay">
    <div class="modal auth-card">
        <div class="modal-header" style="border-bottom: 1px solid var(--glass-border); padding-bottom: 1.25rem; margin-bottom: 1.75rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.35rem; margin: 0; color: var(--accent-red);"><i class="fas fa-plus-circle" style="margin-right: 12px;"></i>Hierarchy Definition</h3>
            <button onclick="closeModal('addPositionModal')" style="background: none; border: none; color: var(--text-low); cursor: pointer; font-size: 1.5rem;"><i class="fas fa-times"></i></button>
        </div>
        <form action="positions.php" method="POST">
            <div class="form-group">
                <label class="form-label">Position Designation</label>
                <input type="text" name="description" class="form-input" placeholder="e.g. Executive President" required>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Vote Limit</label>
                    <input type="number" name="max_vote" class="form-input" placeholder="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Sequence (Priority)</label>
                    <input type="number" name="priority" class="form-input" value="1" required>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" class="btn btn-outline" style="flex: 1;" onclick="closeModal('addPositionModal')">Abort</button>
                <button type="submit" class="btn btn-primary" style="flex: 2;">Commit Position</button>
            </div>
        </form>
    </div>
</div>

<div id="editPositionModal" class="modal-overlay">
    <div class="modal auth-card">
        <div class="modal-header" style="border-bottom: 1px solid var(--glass-border); padding-bottom: 1.25rem; margin-bottom: 1.75rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.35rem; margin: 0; color: var(--accent-red);"><i class="fas fa-edit" style="margin-right: 12px;"></i>Recalibrate Position</h3>
            <button onclick="closeModal('editPositionModal')" style="background: none; border: none; color: var(--text-low); cursor: pointer; font-size: 1.5rem;"><i class="fas fa-times"></i></button>
        </div>
        <form action="positions.php" method="POST">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-group">
                <label class="form-label">Designation String</label>
                <input type="text" name="description" id="edit_description" class="form-input" required>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label class="form-label">Max Allowed Votes</label>
                    <input type="number" name="max_vote" id="edit_max_vote" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Sequence Weight</label>
                    <input type="number" name="priority" id="edit_priority" class="form-input" required>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" class="btn btn-outline" style="flex: 1;" onclick="closeModal('editPositionModal')">Cancel</button>
                <button type="submit" class="btn btn-primary" style="flex: 2;">Save Specifications</button>
            </div>
        </form>
    </div>
</div>

<?php 
include '../includes/admin_footer.php'; 
?>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    function openEditModal(pos) {
        document.getElementById('edit_id').value = pos.id;
        document.getElementById('edit_description').value = pos.description;
        document.getElementById('edit_max_vote').value = pos.max_vote;
        document.getElementById('edit_priority').value = pos.priority;
        openModal('editPositionModal');
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            closeModal(event.target.id);
        }
    }
</script>