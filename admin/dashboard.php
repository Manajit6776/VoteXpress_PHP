<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}
include '../db_connect.php';
include '../includes/admin_header.php';

// Get counts for dashboard info boxes
$total_positions = $conn->query("SELECT COUNT(*) AS total FROM positions")->fetch_assoc()['total'];
$total_candidates = $conn->query("SELECT COUNT(*) AS total FROM candidates")->fetch_assoc()['total'];
$total_voters = $conn->query("SELECT COUNT(*) AS total FROM voters")->fetch_assoc()['total'];
$voters_voted = $conn->query("SELECT COUNT(DISTINCT voters_id) AS total FROM votes")->fetch_assoc()['total'];

?>

<div style="margin-bottom: 2.5rem;">
    <h1 style="font-size: 2.2rem; margin-bottom: 0.3rem;">System Intelligence</h1>
    <p style="color: var(--text-mid); font-size: 0.95rem;">Operational status of the core election engine.</p>
</div>

<div class="stats-grid animate-up" style="margin-bottom: 3rem;">
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-sitemap"></i></div>
        <div style="flex: 1;">
            <div class="stat-value" style="font-size: 1.5rem; line-height: 1;"><?php echo $total_positions; ?></div>
            <div class="stat-label" style="font-size: 0.75rem; color: var(--text-low); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;"><?php echo $total_positions == 1 ? 'Position' : 'Positions'; ?></div>
            <a href="positions.php" style="color: var(--accent-red); font-weight: 700; font-size: 0.75rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 4px;">Config <i class="fas fa-arrow-right" style="font-size: 0.6rem;"></i></a>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-user-tie"></i></div>
        <div style="flex: 1;">
            <div class="stat-value" style="font-size: 1.5rem; line-height: 1;"><?php echo $total_candidates; ?></div>
            <div class="stat-label" style="font-size: 0.75rem; color: var(--text-low); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">Nominees</div>
            <a href="candidates.php" style="color: var(--accent-green); font-weight: 700; font-size: 0.75rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 4px;">Teams <i class="fas fa-arrow-right" style="font-size: 0.6rem;"></i></a>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-users"></i></div>
        <div style="flex: 1;">
            <div class="stat-value" style="font-size: 1.5rem; line-height: 1;"><?php echo $total_voters; ?></div>
            <div class="stat-label" style="font-size: 0.75rem; color: var(--text-low); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">Voters</div>
            <a href="voters.php" style="color: #3b82f6; font-weight: 700; font-size: 0.75rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 4px;">Registry <i class="fas fa-arrow-right" style="font-size: 0.6rem;"></i></a>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-vote-yea"></i></div>
        <div style="flex: 1;">
            <div class="stat-value" style="font-size: 1.5rem; line-height: 1;"><?php echo $voters_voted; ?></div>
            <div class="stat-label" style="font-size: 0.75rem; color: var(--text-low); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">Audited Votes</div>
            <a href="votes.php" style="color: #a855f7; font-weight: 700; font-size: 0.75rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 4px;">Audit <i class="fas fa-arrow-right" style="font-size: 0.6rem;"></i></a>
        </div>
    </div>
</div>

<div class="premium-card animate-up">
    <div class="flex-responsive" style="justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 1.5rem; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.35rem; margin-bottom: 0.3rem;">Real-time Election Tally</h2>
            <p style="color: var(--text-mid); font-size: 0.85rem;">Live output stream from individual contested positions.</p>
        </div>
        <a href="#" onclick="window.print(); return false;" class="btn btn-outline btn-sm full-width-mobile" style="font-size: 0.75rem; padding: 0.5rem 1.2rem;">
            <i class="fas fa-print"></i> PDF Export
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
        <?php
        $positions_result = $conn->query("SELECT * FROM positions ORDER BY priority ASC");

        while ($pos_row = $positions_result->fetch_assoc()) {
            echo "<div class='tally-box' style='padding: 1.25rem;'>";
            echo "<h3 style='font-size: 1rem; margin-bottom: 1.25rem; color: var(--text-pure); display: flex; align-items: center; gap: 10px;'>
                    <span style='width: 3px; height: 16px; background: var(--accent-red); border-radius: 2px;'></span>" 
                    . htmlspecialchars($pos_row['description']) . "</h3>";
            
            // Find max votes for normalization
            $max_votes = 0;
            $votes_result = $conn->query("SELECT candidate_id, COUNT(*) as votes FROM votes WHERE position_id = " . $pos_row['id'] . " GROUP BY candidate_id");
            while ($vrow = $votes_result->fetch_assoc()) {
                if ($vrow['votes'] > $max_votes) $max_votes = $vrow['votes'];
            }

            $candidates_result = $conn->query("SELECT * FROM candidates WHERE position_id = " . $pos_row['id']);
            while ($cand_row = $candidates_result->fetch_assoc()) {
                $total_votes = $conn->query("SELECT COUNT(*) AS votes FROM votes WHERE candidate_id = " . $cand_row['id'])->fetch_assoc()['votes'];
                $bar_width = ($max_votes > 0) ? ($total_votes / $max_votes) * 100 : 0;
                $is_leading = ($max_votes > 0 && $total_votes == $max_votes);

                echo "<div style='margin-bottom: 1rem;'>";
                echo "  <div style='display: flex; justify-content: space-between; margin-bottom: 0.4rem; font-size: 0.85rem;'>";
                echo "    <span style='font-weight: 600; color: " . ($is_leading ? 'var(--accent-red)' : 'var(--text-high)') . "'>" 
                          . htmlspecialchars($cand_row['firstname'] . ' ' . $cand_row['lastname']) . "</span>";
                echo "    <span style='font-weight: 700;'>" . $total_votes . " <small style='font-weight: 400; color: var(--text-low);'>votes</small></span>";
                echo "  </div>";
                echo "  <div class='bar-container' style='height: 8px; margin: 4px 0;'>";
                echo "    <div class='bar-fill' style='width: " . $bar_width . "%; " . ($is_leading ? '' : 'filter: grayscale(0.6); opacity: 0.7;') . "'></div>";
                echo "  </div>";
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
    </div>
</div>

<?php 
// Close content-area div from header
echo '</div>';
include '../includes/admin_footer.php'; 
?>