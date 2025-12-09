<?php
session_start();
if (!isset($_SESSION['voter'])) {
    header('location: voterlogin.php');
    exit();
}
include '../includes/voter_header.php';

$voter_id = $_SESSION['voter'];
$voter_check = $conn->query("SELECT * FROM votes WHERE voters_id = '$voter_id'");
$voter_has_voted = $voter_check->num_rows > 0;
?>
<div class="voter-main-content">
    <div class="ballot-container">
        <?php if ($voter_has_voted): ?>
            <div class="voted-message">
                <h2>You have already voted for this election.</h2>
                <a href="view_ballot.php" class="view-ballot-btn">View Ballot</a>
            </div>
        <?php else: ?>
            <h2 class="page-title">Cast Your Vote</h2>
            <form action="submit_vote.php" method="POST">
                <?php
                $positions_sql = "SELECT * FROM positions ORDER BY priority ASC";
                $positions_result = $conn->query($positions_sql);
                while ($pos_row = $positions_result->fetch_assoc()) {
                    echo "<div class='position-section card'>";
                    echo "<div class='card-header'><h3 class='card-title'>" . htmlspecialchars($pos_row['description']) . "</h3></div>";
                    echo "<div class='card-body'>";
                    echo "<h4>Select only one candidate</h4>";
                    echo "<div class='candidate-list'>";
                    $candidates_sql = "SELECT * FROM candidates WHERE position_id = " . $pos_row['id'];
                    $candidates_result = $conn->query($candidates_sql);
                    while ($cand_row = $candidates_result->fetch_assoc()) {
                        echo "<div class='candidate-box'>";
                        echo "<input type='radio' id='candidate_" . $cand_row['id'] . "' name='position_" . $pos_row['id'] . "' value='" . $cand_row['id'] . "'>";
                        echo "<label for='candidate_" . $cand_row['id'] . "'>";
                        echo "<img src='../assets/images/" . htmlspecialchars($cand_row['photo']) . "' alt='" . htmlspecialchars($cand_row['firstname']) . "'>";
                        echo "<span>" . htmlspecialchars($cand_row['firstname']) . " " . htmlspecialchars($cand_row['lastname']) . "</span>";
                        if (!empty($cand_row['platform'])) {
                            echo "<button type='button' class='view-platform-btn' data-platform='" . htmlspecialchars($cand_row['platform']) . "' onclick='openPlatformModal(this)'><i class='fas fa-eye'></i> View</button>";
                        }
                        echo "</label>";
                        echo "</div>";
                    }
                    echo "</div></div></div>";
                }
                ?>
                <button type="submit" name="submit_vote" class="submit-btn">Submit Ballot</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- Platform Modal -->
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

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    function openPlatformModal(button) {
        var platformText = button.getAttribute('data-platform');
        document.getElementById('platform-content').textContent = platformText;
        openModal('platformModal');
    }

    window.onclick = function(event) {
        const platformModal = document.getElementById('platformModal');
        if (event.target == platformModal) {
            platformModal.style.display = "none";
        }
    }
</script>

<?php include '../includes/voter_footer.php'; ?>