<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}

// --- PHP Logic to handle CRUD operations ---

// Handle Add/Edit Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $description = $conn->real_escape_string($_POST['description']);
    $max_vote = intval($_POST['max_vote']);
    $priority = 0; // You can set a default priority or get it from the form

    if ($id > 0) {
        // Update an existing position
        $sql = "UPDATE positions SET description = '$description', max_vote = '$max_vote' WHERE id = $id";
        $message = "Position updated successfully!";
    } else {
        // Add a new position
        $sql = "INSERT INTO positions (description, max_vote, priority) VALUES ('$description', '$max_vote', '$priority')";
        $message = "New position added successfully!";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = $message;
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
    }
    header('location: positions.php');
    exit();
}

// Handle Delete Request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM positions WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Position deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting record: " . $conn->error;
    }
    header('location: positions.php');
    exit();
}

// --- Fetch all positions from the database for display ---
$positions_sql = "SELECT * FROM positions ORDER BY priority ASC";
$positions_result = $conn->query($positions_sql);

include '../includes/admin_header.php';

// Display session messages (success or error)
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
    <h2 class="page-title">Positions</h2>
    <button class="add-new-btn" onclick="openModal('addPositionModal')"><i class="fas fa-plus"></i> New</button>
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
                    <th>Description <i class="fas fa-sort"></i></th>
                    <th>Maximum Vote <i class="fas fa-sort"></i></th>
                    <th>Tools <i class="fas fa-sort"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($positions_result->num_rows > 0) {
                    while ($pos_row = $positions_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($pos_row['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($pos_row['max_vote']) . "</td>";
                        echo "<td class='tools-cell'>";
                        echo "<button class='edit-btn' data-id='" . $pos_row['id'] . "' data-description='" . htmlspecialchars($pos_row['description']) . "' data-maxvote='" . htmlspecialchars($pos_row['max_vote']) . "' onclick='openEditModal(this)'><i class='fas fa-edit'></i> Edit</button>";
                        echo "<a href='positions.php?delete=" . $pos_row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this position?\");' class='delete-btn'><i class='fas fa-trash-alt'></i> Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='no-data'>No positions found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <span>Showing 1 to <?php echo $positions_result->num_rows; ?> of <?php echo $positions_result->num_rows; ?> entries</span>
        <div class="pagination">
            <a href="#" class="page-link">Previous</a>
            <a href="#" class="page-link active">1</a>
            <a href="#" class="page-link">Next</a>
        </div>
    </div>
</div>

<div id="addPositionModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Position</h3>
            <span class="close-btn" onclick="closeModal('addPositionModal')">&times;</span>
        </div>
        <div class="modal-body">
            <form action="positions.php" method="POST">
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="max_vote">Maximum Vote</label>
                    <input type="number" id="max_vote" name="max_vote" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="close-btn-form" onclick="closeModal('addPositionModal')">Close</button>
                    <button type="submit" class="save-btn"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editPositionModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Position</h3>
            <span class="close-btn" onclick="closeModal('editPositionModal')">&times;</span>
        </div>
        <div class="modal-body">
            <form action="positions.php" method="POST">
                <input type="hidden" id="edit-id" name="id">
                <div class="form-group">
                    <label for="edit-description">Description</label>
                    <input type="text" id="edit-description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="edit-max_vote">Maximum Vote</label>
                    <input type="number" id="edit-max_vote" name="max_vote" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="close-btn-form" onclick="closeModal('editPositionModal')">Close</button>
                    <button type="submit" class="save-btn"><i class="fas fa-save"></i> Save Changes</button>
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

    function openEditModal(button) {
        var id = button.getAttribute('data-id');
        var description = button.getAttribute('data-description');
        var max_vote = button.getAttribute('data-maxvote');

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-description').value = description;
        document.getElementById('edit-max_vote').value = max_vote;

        openModal('editPositionModal');
    }

    window.onclick = function(event) {
        const addModal = document.getElementById('addPositionModal');
        const editModal = document.getElementById('editPositionModal');
        if (event.target == addModal) {
            addModal.style.display = "none";
        }
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
    }
</script>