<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}
include '../db_connect.php';

// Pagination and Entries logic
$limit = isset($_GET['entries']) ? intval($_GET['entries']) : 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Handle form submissions for Add, Edit, and Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_voter'])) {
        $voters_id = $conn->real_escape_string($_POST['voters_id']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $firstname = $conn->real_escape_string($_POST['firstname']);
        $lastname = $conn->real_escape_string($_POST['lastname']);

        $photo = '';
        if (!empty($_FILES['photo']['name'])) {
            $photo_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo_name = uniqid('voter_') . '.' . $photo_ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], '../assets/images/' . $photo_name);
            $photo = $photo_name;
        }

        $sql = "INSERT INTO voters (voters_id, password, firstname, lastname, photo) VALUES ('$voters_id', '$password', '$firstname', '$lastname', '$photo')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = 'Voter successfully registered in the system.';
        } else {
            $_SESSION['error'] = 'Critical Error: ' . $conn->error;
        }
        header('location: voters.php');
        exit();
    }

    if (isset($_POST['edit_voter'])) {
        $id = intval($_POST['id']);
        $voters_id = $conn->real_escape_string($_POST['voters_id']);
        $firstname = $conn->real_escape_string($_POST['firstname']);
        $lastname = $conn->real_escape_string($_POST['lastname']);
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';

        $photo_update = false;
        $photo_name = '';

        if (!empty($_FILES['photo']['name'])) {
            $photo_update = true;
            $photo_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo_name = uniqid('voter_') . '.' . $photo_ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], '../assets/images/' . $photo_name);

            $old_photo_query = $conn->query("SELECT photo FROM voters WHERE id = '$id'");
            if ($old_photo = $old_photo_query->fetch_assoc()) {
                if ($old_photo['photo'] && file_exists('../assets/images/' . $old_photo['photo'])) {
                    unlink('../assets/images/' . $old_photo['photo']);
                }
            }
        }

        $sql = "UPDATE voters SET voters_id = '$voters_id', firstname = '$firstname', lastname = '$lastname'";
        if ($password) $sql .= ", password = '$password'";
        if ($photo_update) $sql .= ", photo = '$photo_name'";
        $sql .= " WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = 'Voter profile updated successfully.';
        } else {
            $_SESSION['error'] = 'Update Failed: ' . $conn->error;
        }
        header('location: voters.php');
        exit();
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $old_photo_query = $conn->query("SELECT photo FROM voters WHERE id = '$id'");
    if ($old_photo = $old_photo_query->fetch_assoc()) {
        if ($old_photo['photo'] && file_exists('../assets/images/' . $old_photo['photo'])) {
            unlink('../assets/images/' . $old_photo['photo']);
        }
    }
    if ($conn->query("DELETE FROM voters WHERE id = '$id'")) {
        $_SESSION['success'] = 'Voter access revoked and record deleted.';
    } else {
        $_SESSION['error'] = 'Deletion Failed: ' . $conn->error;
    }
    header('location: voters.php');
    exit();
}

$total_voters = $conn->query("SELECT COUNT(*) AS total FROM voters")->fetch_assoc()['total'];
$total_pages = ceil($total_voters / $limit);
$voters_result = $conn->query("SELECT * FROM voters LIMIT $start, $limit");

include '../includes/admin_header.php';
?>

<div class="flex-responsive" style="justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; gap: 1rem;">
    <div>
        <h1 style="font-size: 2.2rem; margin-bottom: 0.2rem;">Voter Management</h1>
        <p style="color: var(--text-mid); font-size: 0.9rem;">Maintain and audit the roster of verified election participants.</p>
    </div>
    <button class="btn btn-primary full-width-mobile" onclick="openModal('addVoterModal')">
        <i class="fas fa-user-plus"></i> Initialize New Record
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
        <i class="fas fa-shield-halved"></i>
        <span><?php echo $_SESSION['error']; ?></span>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="premium-card" style="padding: 0;">
    <div style="padding: 1.25rem 2rem; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center;">
        <div style="font-size: 0.85rem; color: var(--text-mid);">
            Displaying <span style="color: var(--text-pure); font-weight: 700;"><?php echo min($start + 1, $total_voters); ?> - <?php echo min($start + $limit, $total_voters); ?></span> of <?php echo $total_voters; ?> entries
        </div>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span style="font-size: 0.8rem; color: var(--text-low);">View Limit:</span>
            <select style="background: var(--bg-main); border: 1px solid var(--glass-border); color: #fff; padding: 4px 12px; border-radius: 6px; font-size: 0.85rem;" onchange="location.href='voters.php?entries='+this.value">
                <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25</option>
                <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
            </select>
        </div>
    </div>

    <div class="table-container" style="margin-top: 0; border: none; border-radius: 0;">
        <table>
            <thead>
                <tr>
                    <th>Security Badge</th>
                    <th>System ID</th>
                    <th>Voter Identity</th>
                    <th style="text-align: right;">Administrative Control</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $voters_result->fetch_assoc()): ?>
                    <tr>
                        <td style="width: 120px;">
                            <?php if ($row['photo'] && file_exists('../assets/images/' . $row['photo'])): ?>
                                <img src="../assets/images/<?php echo htmlspecialchars($row['photo']); ?>" style="width: 42px; height: 42px; border-radius: 10px; object-fit: cover; border: 1.5px solid var(--glass-border);">
                            <?php else: ?>
                                <div style="width: 42px; height: 42px; border-radius: 10px; background: var(--bg-hover); display: flex; align-items: center; justify-content: center; color: var(--text-low); border: 1.5px dashed var(--glass-border);"><i class="fas fa-user-circle"></i></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <code style="background: rgba(255,107,122,0.1); color: var(--accent-red); padding: 4px 10px; border-radius: 6px; font-weight: 700; font-family: monospace; font-size: 0.9rem;">
                                <?php echo htmlspecialchars($row['voters_id']); ?>
                            </code>
                        </td>
                        <td style="font-weight: 600; color: var(--text-pure); font-size: 0.95rem;">
                            <?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                                <button class="btn btn-outline btn-sm" style="padding: 0.4rem 0.6rem; border-color: rgba(255,255,255,0.1);" onclick='openEditModal(<?php echo json_encode($row); ?>)'>
                                    <i class="fas fa-pen-nib"></i>
                                </button>
                                <a href="voters.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline btn-sm" style="padding: 0.4rem 0.6rem; color: var(--accent-red); border-color: rgba(255,107,122,0.15);" onclick="return confirm('Immediately terminate access for this record?');">
                                    <i class="fas fa-user-minus"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php if ($total_pages > 1): ?>
        <div style="padding: 1.25rem 2rem; border-top: 1px solid var(--glass-border); display: flex; justify-content: center; gap: 0.5rem;">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="voters.php?page=<?php echo $i; ?>&entries=<?php echo $limit; ?>" 
                   class="btn btn-sm <?php echo $i == $page ? 'btn-primary' : 'btn-outline'; ?>" style="min-width: 36px; padding: 0.4rem; height: 36px;">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>



</div> <!-- Close animate-up area -->

<!-- Optimized Modal Overlays -->
<div id="addVoterModal" class="modal-overlay">
    <div class="modal auth-card">
        <div class="modal-header" style="border-bottom: 1px solid var(--glass-border); padding-bottom: 1rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.25rem; margin: 0; color: var(--accent-red);"><i class="fas fa-shield-virus" style="margin-right: 10px;"></i>Enroll New Participant</h3>
            <button onclick="closeModal('addVoterModal')" style="background: none; border: none; color: var(--text-low); cursor: pointer; font-size: 1.25rem;"><i class="fas fa-times"></i></button>
        </div>
        <form action="voters.php" method="POST" enctype="multipart/form-data">
            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">System Voter ID</label>
                    <input type="text" name="voters_id" class="form-input" placeholder="VOTE-100X" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Access Passcode</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Given Name</label>
                    <input type="text" name="firstname" class="form-input" placeholder="First Name" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Family Name</label>
                    <input type="text" name="lastname" class="form-input" placeholder="Last Name" required>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label">Biometric Verification (Photo)</label>
                <input type="file" name="photo" class="form-input" style="padding: 6px;" required>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button type="button" class="btn btn-outline" style="flex: 1;" onclick="closeModal('addVoterModal')">Abort</button>
                <button type="submit" name="add_voter" class="btn btn-primary" style="flex: 2;">Commit Registration</button>
            </div>
        </form>
    </div>
</div>

<div id="editVoterModal" class="modal-overlay">
    <div class="modal auth-card">
        <div class="modal-header" style="border-bottom: 1px solid var(--glass-border); padding-bottom: 1rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.25rem; margin: 0; color: var(--accent-red);"><i class="fas fa-fingerprint" style="margin-right: 10px;"></i>Update Profile Signature</h3>
            <button onclick="closeModal('editVoterModal')" style="background: none; border: none; color: var(--text-low); cursor: pointer; font-size: 1.25rem;"><i class="fas fa-times"></i></button>
        </div>
        <form action="voters.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit_id">
            
            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Identity Marker</label>
                    <input type="text" name="voters_id" id="edit_voters_id" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">New Passcode <small>(Optional)</small></label>
                    <input type="password" name="password" class="form-input" placeholder="Unchanged">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" name="firstname" id="edit_firstname" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastname" id="edit_lastname" class="form-input" required>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label">Update Verification Asset</label>
                <input type="file" name="photo" class="form-input" style="padding: 6px;">
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button type="button" class="btn btn-outline" style="flex: 1;" onclick="closeModal('editVoterModal')">Cancel</button>
                <button type="submit" name="edit_voter" class="btn btn-primary" style="flex: 2;">Apply Modifications</button>
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

    function openEditModal(voter) {
        document.getElementById('edit_id').value = voter.id;
        document.getElementById('edit_voters_id').value = voter.voters_id;
        document.getElementById('edit_firstname').value = voter.firstname;
        document.getElementById('edit_lastname').value = voter.lastname;
        openModal('editVoterModal');
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            closeModal(event.target.id);
        }
    }
</script>