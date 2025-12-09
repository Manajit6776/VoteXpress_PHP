<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}
include '../db_connect.php';
include '../includes/admin_header.php';

// Get counts for dashboard info boxes
$total_positions_query = $conn->query("SELECT COUNT(*) AS total FROM positions");
$total_positions = $total_positions_query->fetch_assoc()['total'];

$total_candidates_query = $conn->query("SELECT COUNT(*) AS total FROM candidates");
$total_candidates = $total_candidates_query->fetch_assoc()['total'];

$total_voters_query = $conn->query("SELECT COUNT(*) AS total FROM voters");
$total_voters = $total_voters_query->fetch_assoc()['total'];

$voters_voted_query = $conn->query("SELECT COUNT(DISTINCT voters_id) AS total FROM votes");
$voters_voted = $voters_voted_query->fetch_assoc()['total'];

?>
<div class="dashboard-header">
    <h2 class="dashboard-title">Dashboard</h2>
</div>

<div class="info-boxes">
    <div class="info-box tanjiro-box">
        <h4 class="box-label">No. of Positions</h4>
        <p class="box-value"><?php echo $total_positions; ?></p>
        <i class="fas fa-cog info-icon"></i>
        <a href="positions.php" class="more-info-btn">More info &raquo;</a>
    </div>
    <div class="info-box rengoku-box">
        <h4 class="box-label">No. of Candidates</h4>
        <p class="box-value"><?php echo $total_candidates; ?></p>
        <i class="fas fa-user-tie info-icon"></i>
        <a href="candidates.php" class="more-info-btn">More info &raquo;</a>
    </div>
    <div class="info-box mitsuri-box">
        <h4 class="box-label">Total Voters</h4>
        <p class="box-value"><?php echo $total_voters; ?></p>
        <i class="fas fa-users info-icon"></i>
        <a href="voters.php" class="more-info-btn">More info &raquo;</a>
    </div>
    <div class="info-box shinobu-box">
        <h4 class="box-label">Voters Voted</h4>
        <p class="box-value"><?php echo $voters_voted; ?></p>
        <i class="fas fa-edit info-icon"></i>
        <a href="votes.php" class="more-info-btn">More info &raquo;</a>
    </div>
</div>

<div class="votes-tally-container">
    <div class="tally-header">
        <h2 class="section-title">VOTES TALLY</h2>
        <a href="#" onclick="window.print(); return false;" class="print-btn"><i class="fas fa-print"></i> Print</a>
    </div>
    <div class="tally-results-grid">
        <?php
        $positions_sql = "SELECT * FROM positions ORDER BY priority ASC";
        $positions_result = $conn->query($positions_sql);

        while ($pos_row = $positions_result->fetch_assoc()) {
            echo "<div class='tally-box'>";
            echo "<h3 class='tally-position-title'>" . htmlspecialchars($pos_row['description']) . "</h3>";
            echo "<div class='chart-container'>";

            // First, find the maximum votes for this position to normalize the bar lengths
            $max_votes = 0;
            $votes_for_position_query = "SELECT candidate_id, COUNT(*) as votes FROM votes WHERE position_id = " . $pos_row['id'] . " GROUP BY candidate_id";
            $votes_for_position_result = $conn->query($votes_for_position_query);
            while ($vote_row = $votes_for_position_result->fetch_assoc()) {
                if ($vote_row['votes'] > $max_votes) {
                    $max_votes = $vote_row['votes'];
                }
            }

            // Loop through candidates and display the bar chart
            $candidates_sql = "SELECT * FROM candidates WHERE position_id = " . $pos_row['id'];
            $candidates_result = $conn->query($candidates_sql);

            while ($cand_row = $candidates_result->fetch_assoc()) {
                $vote_sql = "SELECT COUNT(*) AS votes FROM votes WHERE candidate_id = " . $cand_row['id'];
                $vote_result = $conn->query($vote_sql);
                $total_votes = $vote_result->fetch_assoc()['votes'];

                $bar_width = ($max_votes > 0) ? ($total_votes / $max_votes) * 100 : 0;

                echo "<div class='bar-item'>";
                echo "<span class='candidate-name'>" . htmlspecialchars($cand_row['lastname']) . "</span>";
                echo "<div class='bar-container'>";
                echo "<div class='bar-chart' style='width: " . $bar_width . "%;'></div>";
                echo "<span class='vote-count'>" . $total_votes . "</span>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>
<?php include '../includes/admin_footer.php'; ?>