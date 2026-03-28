<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}

// Handle Add/Edit Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $position_id = intval($_POST['position_id']);
    $platform = $conn->real_escape_string($_POST['platform']);

    $photo_name = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $photo_temp = $_FILES['photo']['tmp_name'];
        $photo_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo_name = uniqid('candidate_') . '.' . $photo_ext;
        $photo_path = '../assets/images/' . $photo_name;
        move_uploaded_file($photo_temp, $photo_path);
    }

    if ($id > 0) {
        $sql = "UPDATE candidates SET firstname = '$firstname', lastname = '$lastname', position_id = '$position_id', platform = '$platform'";
        if ($photo_name) {
            $sql .= ", photo = '$photo_name'";
        }
        $sql .= " WHERE id = $id";
        $message = "Nominee profile recalibrated successfully.";
    } else {
        $sql = "INSERT INTO candidates (firstname, lastname, position_id, photo, platform) VALUES ('$firstname', '$lastname', '$position_id', '$photo_name', '$platform')";
        $message = "New nominee registered for the 2025 cycle.";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = $message;
    } else {
        $_SESSION['error'] = "System Error: " . $conn->error;
    }
    header('location: candidates.php');
    exit();
}

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $photo_query = $conn->query("SELECT photo FROM candidates WHERE id = $id");
    $photo_row = $photo_query->fetch_assoc();
    if ($photo_row && !empty($photo_row['photo'])) {
        $photo_path = '../assets/images/' . $photo_row['photo'];
        if (file_exists($photo_path)) {
            unlink($photo_path);
        }
    }

    if ($conn->query("DELETE FROM candidates WHERE id = $id")) {
        $_SESSION['success'] = "Nominee purged from active records.";
    } else {
        $_SESSION['error'] = "Access Denied: " . $conn->error;
    }
    header('location: candidates.php');
    exit();
}

$candidates_result = $conn->query("SELECT c.*, p.description AS position_description FROM candidates c JOIN positions p ON c.position_id = p.id ORDER BY p.priority, c.lastname");

$positions_query = $conn->query("SELECT id, description FROM positions ORDER BY priority ASC");
$positions = [];
while ($row = $positions_query->fetch_assoc()) {
    $positions[] = $row;
}

include '../includes/admin_header.php';
?>

<div class="flex-responsive" style="justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; gap: 1rem;">
    <div>
        <h1 style="font-size: 2.22rem; margin-bottom: 0.2rem;">Nominee Registry: 2025</h1>
        <p style="color: var(--text-mid); font-size: 0.95rem;">Administrative control for candidates competing in contested positions.</p>
    </div>
    <button class="btn btn-primary full-width-mobile" onclick="openModal('addCandidateModal')">
        <i class="fas fa-user-tie"></i> Register New Nominee
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
        <i class="fas fa-exclamation-triangle"></i>
        <span><?php echo $_SESSION['error']; ?></span>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="premium-card" style="padding: 0;">
    <div style="padding: 1.25rem 2rem; border-bottom: 1px solid var(--glass-border);">
        <h2 style="font-size: 1rem; color: var(--text-pure); display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-id-card-alt" style="color: var(--accent-red); font-size: 0.85rem;"></i> Active Nominee Catalog
        </h2>
    </div>

    <div class="table-container" style="margin-top: 0; border: none; border-radius: 0;">
        <table>
            <thead>
                <tr>
                    <th>Identification</th>
                    <th>Full Name</th>
                    <th>Assigned Position</th>
                    <th>Platform Strategy</th>
                    <th style="text-align: right;">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($candidates_result->num_rows > 0): ?>
                    <?php while ($row = $candidates_result->fetch_assoc()): ?>
                        <tr>
                            <td style="width: 120px;">
                                <?php if ($row['photo'] && file_exists('../assets/images/' . $row['photo'])): ?>
                                    <img src="../assets/images/<?php echo htmlspecialchars($row['photo']); ?>" style="width: 44px; height: 44px; border-radius: 12px; object-fit: cover; border: 1.5px solid var(--glass-border);">
                                <?php else: ?>
                                    <div style="width: 44px; height: 44px; border-radius: 12px; background: var(--bg-hover); display: flex; align-items: center; justify-content: center; color: var(--text-low); border: 1.5px dashed var(--glass-border);"><i class="fas fa-user"></i></div>
                                <?php endif; ?>
                            </td>
                            <td style="font-weight: 600; color: var(--text-pure); font-size: 0.95rem;">
                                <?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?>
                            </td>
                            <td>
                                <span class="badge" style="background: rgba(0, 245, 155, 0.1); color: var(--accent-green); border: 1px solid rgba(0, 245, 155, 0.2);">
                                    <?php echo htmlspecialchars($row['position_description']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($row['platform'])): ?>
                                    <button class="btn btn-outline btn-sm" onclick='viewPlatform(<?php echo json_encode($row['platform']); ?>)'>
                                        <i class="fas fa-book-open"></i> View Manifesto
                                    </button>
                                <?php else: ?>
                                    <span style="color: var(--text-low); font-size: 0.85rem;">[None Set]</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                                    <button class="btn btn-outline btn-sm" style="padding: 0.4rem 0.6rem; border-color: rgba(255,255,255,0.1);" 
                                            onclick='openEditModal(<?php echo json_encode($row); ?>)'>
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="candidates.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline btn-sm" 
                                       style="padding: 0.4rem 0.6rem; color: var(--accent-red); border-color: rgba(255,59,59,0.15);" 
                                       onclick="return confirm('Purge nominee record and all associated campaign data?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 4rem; color: var(--text-low);">
                            <i class="fas fa-user-astronaut" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                            No nominees registered for this cycle.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>



</div> <!-- Close animate-up area -->

<!-- Modals outside animated area -->
<div id="addCandidateModal" class="modal-overlay">
    <div class="modal auth-card">
        <div class="modal-header" style="border-bottom: 1px solid var(--glass-border); padding-bottom: 1.25rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.35rem; margin: 0; color: var(--accent-red);"><i class="fas fa-user-plus" style="margin-right: 12px;"></i>Nomination Protocol</h3>
            <button onclick="closeModal('addCandidateModal')" style="background: none; border: none; color: var(--text-low); cursor: pointer; font-size: 1.5rem;"><i class="fas fa-times"></i></button>
        </div>
        <form action="candidates.php" method="POST" enctype="multipart/form-data">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-input" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastname" class="form-input" required>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Target Position</label>
                    <select name="position_id" class="form-input" required>
                        <?php foreach ($positions as $pos): ?>
                            <option value="<?php echo $pos['id']; ?>"><?php echo htmlspecialchars($pos['description']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Nominee Visual</label>
                    <input type="file" name="photo" class="form-input" style="padding: 7px;" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Campaign Platform / Bio</label>
                <textarea name="platform" class="form-input" rows="3" placeholder="Enter manifesto details..."></textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" class="btn btn-outline" style="flex: 1;" onclick="closeModal('addCandidateModal')">Abort</button>
                <button type="submit" class="btn btn-primary" style="flex: 2;">Commit Nominee</button>
            </div>
        </form>
    </div>
</div>

<div id="editCandidateModal" class="modal-overlay">
    <div class="modal auth-card">
        <div class="modal-header" style="border-bottom: 1px solid var(--glass-border); padding-bottom: 1.25rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.35rem; margin: 0; color: var(--accent-red);"><i class="fas fa-user-edit" style="margin-right: 12px;"></i>Recalibrate Nominee</h3>
            <button onclick="closeModal('editCandidateModal')" style="background: none; border: none; color: var(--text-low); cursor: pointer; font-size: 1.5rem;"><i class="fas fa-times"></i></button>
        </div>
        <form action="candidates.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit_id">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">First Name</label>
                    <input type="text" name="firstname" id="edit_firstname" class="form-input" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastname" id="edit_lastname" class="form-input" required>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Contested Position</label>
                    <select name="position_id" id="edit_position_id" class="form-input" required>
                        <?php foreach ($positions as $pos): ?>
                            <option value="<?php echo $pos['id']; ?>"><?php echo htmlspecialchars($pos['description']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Update Asset <small>(Optional)</small></label>
                    <input type="file" name="photo" class="form-input" style="padding: 7px;">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Campaign Platform</label>
                <textarea name="platform" id="edit_platform" class="form-input" rows="3"></textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" class="btn btn-outline" style="flex: 1;" onclick="closeModal('editCandidateModal')">Cancel</button>
                <button type="submit" class="btn btn-primary" style="flex: 2;">Save Modifications</button>
            </div>
        </form>
    </div>
</div>

<div id="viewPlatformModal" class="modal-overlay">
    <div class="modal auth-card">
        <div class="modal-header" style="border-bottom: 1px solid var(--glass-border); padding-bottom: 1rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.2rem; margin: 0; color: var(--accent-green);"><i class="fas fa-file-invoice" style="margin-right: 12px;"></i>Manifesto Overview</h3>
            <button onclick="closeModal('viewPlatformModal')" style="background: none; border: none; color: var(--text-low); cursor: pointer; font-size: 1.5rem;"><i class="fas fa-times"></i></button>
        </div>
        <div id="platform_text" style="color: var(--text-high); font-size: 1rem; line-height: 1.8; white-space: pre-wrap; max-height: 60vh; overflow-y: auto; padding-right: 10px;"></div>
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

    function openEditModal(cand) {
        document.getElementById('edit_id').value = cand.id;
        document.getElementById('edit_firstname').value = cand.firstname;
        document.getElementById('edit_lastname').value = cand.lastname;
        document.getElementById('edit_position_id').value = cand.position_id;
        document.getElementById('edit_platform').value = cand.platform;
        openModal('editCandidateModal');
    }

    function viewPlatform(text) {
        document.getElementById('platform_text').textContent = text;
        openModal('viewPlatformModal');
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            closeModal(event.target.id);
        }
    }
</script>