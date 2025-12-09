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
        $message = "Candidate updated successfully!";
    } else {
        $sql = "INSERT INTO candidates (firstname, lastname, position_id, photo, platform) VALUES ('$firstname', '$lastname', '$position_id', '$photo_name', '$platform')";
        $message = "New candidate added successfully!";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = $message;
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
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

    $sql = "DELETE FROM candidates WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Candidate deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting record: " . $conn->error;
    }
    header('location: candidates.php');
    exit();
}

$candidates_sql = "SELECT c.*, p.description AS position_description FROM candidates c JOIN positions p ON c.position_id = p.id ORDER BY p.priority, c.lastname";
$candidates_result = $conn->query($candidates_sql);

$positions_query = $conn->query("SELECT id, description FROM positions ORDER BY priority ASC");
$positions = [];
while ($row = $positions_query->fetch_assoc()) {
    $positions[] = $row;
}

include '../includes/admin_header.php';

if (isset($_SESSION['success'])) {
    echo '<div class="message success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo '<div class="message error">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

<div class="header">
    <h2 class="page-title">Candidates</h2>
    <button class="add-new-btn" onclick="openModal('addCandidateModal')"><i class="fas fa-plus"></i> New</button>
</div>

<div class="data-section">
    <div class="data-controls">
        <label>Show
            <select class="entries-select">
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select>
            entries
        </label>
        <div class="search-box">
            Search: <input type="text" class="search-input">
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Firstname <i class="fas fa-sort"></i></th>
                    <th>Lastname <i class="fas fa-sort"></i></th>
                    <th>Position <i class="fas fa-sort"></i></th>
                    <th>Platform</th>
                    <th>Tools</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($candidates_result->num_rows > 0) {
                    while ($cand_row = $candidates_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='candidate-photo-cell'><img src='../assets/images/" . htmlspecialchars($cand_row['photo']) . "' alt='Candidate Photo' class='candidate-photo'></td>";
                        echo "<td>" . htmlspecialchars($cand_row['firstname']) . "</td>";
                        echo "<td>" . htmlspecialchars($cand_row['lastname']) . "</td>";
                        echo "<td>" . htmlspecialchars($cand_row['position_description']) . "</td>";
                        echo "<td>";
                        if (!empty($cand_row['platform'])) {
                            echo "<button class='view-platform-btn' data-platform='" . htmlspecialchars($cand_row['platform']) . "' onclick='openPlatformModal(this)'><i class='fas fa-eye'></i> View</button>";
                        }
                        echo "</td>";
                        echo "<td class='tools-cell'>";
                        echo "<button class='edit-btn' 
                            data-id='" . $cand_row['id'] . "' 
                            data-firstname='" . htmlspecialchars($cand_row['firstname']) . "' 
                            data-lastname='" . htmlspecialchars($cand_row['lastname']) . "' 
                            data-positionid='" . htmlspecialchars($cand_row['position_id']) . "'
                            data-platform='" . htmlspecialchars($cand_row['platform']) . "'
                            onclick='openEditModal(this)'>
                            <i class='fas fa-edit'></i> Edit
                        </button>";
                        echo "<a href='candidates.php?delete=" . $cand_row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this candidate?\");' class='delete-btn'><i class='fas fa-trash-alt'></i> Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='no-data'>No candidates found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div id="addCandidateModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Candidate</h3>
            <span class="close-btn" onclick="closeModal('addCandidateModal')">&times;</span>
        </div>
        <div class="modal-body">
            <form action="candidates.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstname">Firstname</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Lastname</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="position_id">Position</label>
                    <select id="position_id" name="position_id" required>
                        <?php foreach ($positions as $pos): ?>
                            <option value="<?php echo $pos['id']; ?>"><?php echo htmlspecialchars($pos['description']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="photo">Photo</label>
                    <input type="file" id="photo" name="photo" required>
                </div>
                <div class="form-group">
                    <label for="platform">Platform</label>
                    <textarea id="platform" name="platform" rows="3"></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="close-btn-form" onclick="closeModal('addCandidateModal')">Close</button>
                    <button type="submit" class="save-btn"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editCandidateModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Candidate</h3>
            <span class="close-btn" onclick="closeModal('editCandidateModal')">&times;</span>
        </div>
        <div class="modal-body">
            <form action="candidates.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="edit-id" name="id">
                <div class="form-group">
                    <label for="edit-firstname">Firstname</label>
                    <input type="text" id="edit-firstname" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="edit-lastname">Lastname</label>
                    <input type="text" id="edit-lastname" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="edit-position_id">Position</label>
                    <select id="edit-position_id" name="position_id" required>
                        <?php foreach ($positions as $pos): ?>
                            <option value="<?php echo $pos['id']; ?>"><?php echo htmlspecialchars($pos['description']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit-photo">Photo (optional)</label>
                    <input type="file" id="edit-photo" name="photo">
                </div>
                <div class="form-group">
                    <label for="edit-platform">Platform</label>
                    <textarea id="edit-platform" name="platform" rows="3"></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="close-btn-form" onclick="closeModal('editCandidateModal')">Close</button>
                    <button type="submit" class="save-btn"><i class="fas fa-save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="platformModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Candidate Platform</h3>
            <span class="close-btn" onclick="closeModal('platformModal')">&times;</span>
        </div>
        <div class="modal-body">
            <p id="platform-content"></p>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    function openEditModal(button) {
        var id = button.getAttribute('data-id');
        var firstname = button.getAttribute('data-firstname');
        var lastname = button.getAttribute('data-lastname');
        var positionId = button.getAttribute('data-positionid');
        var platform = button.getAttribute('data-platform');

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-firstname').value = firstname;
        document.getElementById('edit-lastname').value = lastname;
        document.getElementById('edit-position_id').value = positionId;
        document.getElementById('edit-platform').value = platform;

        openModal('editCandidateModal');
    }

    function openPlatformModal(button) {
        var platformText = button.getAttribute('data-platform');
        document.getElementById('platform-content').textContent = platformText;
        openModal('platformModal');
    }

    window.onclick = function(event) {
        const addModal = document.getElementById('addCandidateModal');
        const editModal = document.getElementById('editCandidateModal');
        const platformModal = document.getElementById('platformModal');
        if (event.target == addModal) {
            addModal.style.display = "none";
        }
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
        if (event.target == platformModal) {
            platformModal.style.display = "none";
        }
    }
</script>