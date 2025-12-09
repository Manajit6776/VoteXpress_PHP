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
            $_SESSION['success'] = 'Voter added successfully';
        } else {
            $_SESSION['error'] = 'Error adding voter: ' . $conn->error;
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

            $old_photo_sql = "SELECT photo FROM voters WHERE id = '$id'";
            $old_photo_result = $conn->query($old_photo_sql);
            if ($old_photo = $old_photo_result->fetch_assoc()) {
                if ($old_photo['photo'] && file_exists('../assets/images/' . $old_photo['photo'])) {
                    unlink('../assets/images/' . $old_photo['photo']);
                }
            }
        }

        $sql = "UPDATE voters SET voters_id = '$voters_id', firstname = '$firstname', lastname = '$lastname'";
        if ($password) {
            $sql .= ", password = '$password'";
        }
        if ($photo_update) {
            $sql .= ", photo = '$photo_name'";
        }
        $sql .= " WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = 'Voter updated successfully';
        } else {
            $_SESSION['error'] = 'Error updating voter: ' . $conn->error;
        }
        header('location: voters.php');
        exit();
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $old_photo_sql = "SELECT photo FROM voters WHERE id = '$id'";
    $old_photo_result = $conn->query($old_photo_sql);
    if ($old_photo = $old_photo_result->fetch_assoc()) {
        if ($old_photo['photo'] && file_exists('../assets/images/' . $old_photo['photo'])) {
            unlink('../assets/images/' . $old_photo['photo']);
        }
    }
    $sql = "DELETE FROM voters WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = 'Voter deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting voter: ' . $conn->error;
    }
    header('location: voters.php');
    exit();
}

// Get total number of records for pagination
$total_voters_query = $conn->query("SELECT COUNT(*) AS total FROM voters");
$total_voters = $total_voters_query->fetch_assoc()['total'];
$total_pages = ceil($total_voters / $limit);

// Main SQL query with LIMIT for pagination
$sql = "SELECT * FROM voters LIMIT $start, $limit";
$voters_result = $conn->query($sql);

include '../includes/admin_header.php';
?>

<div class="header">
    <h2 class="page-title">Voters List</h2>
    <button class="add-new-btn" onclick="openModal('addVoterModal')"><i class="fas fa-plus"></i> Add New</button>
</div>

<div class="data-section">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="message success">
            <?php echo $_SESSION['success']; ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="message error">
            <?php echo $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="data-controls">
        <label>Show
            <select class="entries-select" onchange="window.location.href = `voters.php?entries=${this.value}`">
                <option value="10" <?php echo ($limit == 10) ? 'selected' : ''; ?>>10</option>
                <option value="25" <?php echo ($limit == 25) ? 'selected' : ''; ?>>25</option>
                <option value="50" <?php echo ($limit == 50) ? 'selected' : ''; ?>>50</option>
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
                    <th>Voters ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Tools</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($voters_result->num_rows > 0): ?>
                    <?php while ($row = $voters_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['voters_id']); ?></td>
                            <td class="candidate-photo-cell">
                                <?php if ($row['photo']): ?>
                                    <img src="../assets/images/<?php echo htmlspecialchars($row['photo']); ?>" class="candidate-photo">
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                            <td class="tools-cell">
                                <button class="edit-btn" onclick='openEditModal(<?php echo json_encode($row); ?>)'>
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <a href="voters.php?delete=<?php echo htmlspecialchars($row['id']); ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this voter?');">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan='4' class='no-data'>No voters found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <div class="info">
            <?php
            $start_entry = $start + 1;
            $end_entry = min($start + $limit, $total_voters);
            if ($total_voters > 0) {
                echo "Showing {$start_entry} to {$end_entry} of {$total_voters} entries";
            } else {
                echo "No entries found.";
            }
            ?>
        </div>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="voters.php?page=<?php echo $i; ?>&entries=<?php echo $limit; ?>" class="page-link <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</div>

<div id="addVoterModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Voter</h3>
            <span class="close-btn" onclick="closeModal('addVoterModal')">&times;</span>
        </div>
        <div class="modal-body">
            <form action="voters.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="voters_id">Voters ID</label>
                    <input type="text" name="voters_id" id="voters_id" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" id="firstname" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" id="lastname" required>
                </div>
                <div class="form-group">
                    <label for="photo">Photo</label>
                    <input type="file" name="photo" id="photo" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="close-btn-form" onclick="closeModal('addVoterModal')">Close</button>
                    <button type="submit" name="add_voter" class="save-btn"><i class="fas fa-save"></i> Add Voter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editVoterModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Voter</h3>
            <span class="close-btn" onclick="closeModal('editVoterModal')">&times;</span>
        </div>
        <div class="modal-body">
            <form action="voters.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group">
                    <label for="edit_voters_id">Voters ID</label>
                    <input type="text" name="voters_id" id="edit_voters_id" required>
                </div>
                <div class="form-group">
                    <label for="edit_firstname">First Name</label>
                    <input type="text" name="firstname" id="edit_firstname" required>
                </div>
                <div class="form-group">
                    <label for="edit_lastname">Last Name</label>
                    <input type="text" name="lastname" id="edit_lastname" required>
                </div>
                <div class="form-group">
                    <label for="edit_password">New Password (optional)</label>
                    <input type="password" name="password" id="edit_password">
                </div>
                <div class="form-group">
                    <label for="edit_photo">Photo (optional)</label>
                    <input type="file" name="photo" id="edit_photo">
                </div>
                <div class="form-actions">
                    <button type="button" class="close-btn-form" onclick="closeModal('editVoterModal')">Close</button>
                    <button type="submit" name="edit_voter" class="save-btn"><i class="fas fa-save"></i> Save Changes</button>
                </div>
            </form>
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

    function openEditModal(voter) {
        document.getElementById('edit_id').value = voter.id;
        document.getElementById('edit_voters_id').value = voter.voters_id;
        document.getElementById('edit_firstname').value = voter.firstname;
        document.getElementById('edit_lastname').value = voter.lastname;
        openModal('editVoterModal');
    }

    window.onclick = function(event) {
        const addModal = document.getElementById('addVoterModal');
        const editModal = document.getElementById('editVoterModal');
        if (event.target == addModal) {
            addModal.style.display = "none";
        }
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
    }
</script>