<?php
session_start();
if (!isset($_SESSION['voter'])) {
    header('location: voterlogin.php');
    exit();
}
include '../db_connect.php';
include '../includes/voter_header.php';

$voter_id = $_SESSION['voter'];
?>

<div class="voter-main-content">
    <div class="ballot-view-container">
        <h2 class="page-title">Your Submitted Ballot</h2>
        <?php
        $positions_query = $conn->query("SELECT * FROM positions ORDER BY priority ASC");

        if ($positions_query->num_rows > 0) {
            $has_voted_for_at_least_one = false;
            while ($pos_row = $positions_query->fetch_assoc()) {
                echo "<div class='position-section card'>";
                echo "<div class='card-header'><h3 class='card-title'>" . htmlspecialchars($pos_row['description']) . "</h3></div>";
                echo "<div class='card-body'>";

                $vote_query = $conn->query("SELECT * FROM votes WHERE voters_id = '$voter_id' AND position_id = " . $pos_row['id']);

                if ($vote_query->num_rows > 0) {
                    $vote_row = $vote_query->fetch_assoc();
                    $candidate_id = $vote_row['candidate_id'];
                    $candidate_query = $conn->query("SELECT * FROM candidates WHERE id = '$candidate_id'");
                    $candidate_row = $candidate_query->fetch_assoc();
                    $has_voted_for_at_least_one = true;

                    echo "<div class='selected-candidate-box'>";
                    echo "<img src='../assets/images/" . htmlspecialchars($candidate_row['photo']) . "' alt='" . htmlspecialchars($candidate_row['firstname']) . "' class='candidate-photo'>";
                    echo "<div class='candidate-details'>";
                    echo "<h4>Your Selection:</h4>";
                    echo "<p>" . htmlspecialchars($candidate_row['firstname']) . " " . htmlspecialchars($candidate_row['lastname']) . "</p>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<p class='no-selection-message'>No selection was made for this position.</p>";
                }
                echo "</div></div>";
            }

            if (!$has_voted_for_at_least_one) {
                echo "<div class='empty-ballot-message'>
                    <p>You have not cast your vote yet. Please go to the home page to vote.</p>
                    <a href='ballot.php' class='btn-primary'>Go to Ballot</a>
                </div>";
            }
        }
        ?>
    </div>
</div>

<?php include '../includes/voter_footer.php'; ?>