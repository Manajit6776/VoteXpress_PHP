<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}
include '../db_connect.php';
include '../includes/admin_header.php';

// Fetch all positions from the database, ordered by priority
$positions_sql = "SELECT * FROM positions ORDER BY priority ASC";
$positions_result = $conn->query($positions_sql);
?>

<div class="header">
    <h2 class="page-title">Ballot Position</h2>
    <p>Drag and drop to reorder positions</p>
</div>

<div class="data-section">
    <div class="table-container">
        <div id="position-list" class="list-group">
            <?php
            if ($positions_result->num_rows > 0) {
                while ($pos_row = $positions_result->fetch_assoc()) {
                    echo "<div class='list-group-item' data-id='" . $pos_row['id'] . "'>";
                    echo htmlspecialchars($pos_row['description']);
                    echo "<i class='fas fa-grip-vertical handle'></i>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-data'>No positions found. Please add some first.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        var positionList = document.getElementById('position-list');

        if (positionList) {
            new Sortable(positionList, {
                animation: 150,
                handle: '.handle',
                onEnd: function(evt) {
                    var order = [];
                    // Get the new order of positions
                    positionList.querySelectorAll('.list-group-item').forEach(function(item) {
                        order.push(item.getAttribute('data-id'));
                    });

                    // Send the new order to a PHP script to update the database
                    fetch('update_ballot_order.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                order: order
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Optional: Display a success message
                                console.log('Ballot order updated successfully!');
                            } else {
                                console.error('Error updating ballot order:', data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Fetch error:', error);
                        });
                }
            });
        }
    });
</script>