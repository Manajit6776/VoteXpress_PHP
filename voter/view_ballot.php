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

<div style="max-width: 900px; margin: 0 auto; padding-bottom: 5rem;">
    <div style="margin-bottom: 3rem; text-align: center;" class="animate-up">
        <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem; background: linear-gradient(to right, #fff, #999); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">Your Finalized Ballot</h1>
        <p style="color: var(--text-mid); font-size: 1.1rem;">Digital receipt of your encrypted selections for the 2025 Cycle.</p>
        <div style="margin-top: 1.5rem; display: inline-flex; align-items: center; gap: 10px; padding: 0.5rem 1.25rem; background: rgba(0, 245, 155, 0.1); border-radius: var(--radius-full); border: 1px solid rgba(0, 245, 155, 0.2); color: var(--accent-green); font-size: 0.85rem; font-weight: 700;">
            <i class="fas fa-shield-check"></i> TRANSACTION VERIFIED & AUDITED
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <?php
        $positions_query = $conn->query("SELECT * FROM positions ORDER BY priority ASC");

        if ($positions_query->num_rows > 0) {
            $has_voted = false;
            while ($pos_row = $positions_query->fetch_assoc()) {
                $vote_query = $conn->query("SELECT * FROM votes WHERE voters_id = '$voter_id' AND position_id = " . $pos_row['id']);
                
                echo "<div class='premium-card animate-up' style='border-left: 4px solid var(--accent-red);'>";
                echo "  <div style='display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 1rem;'>";
                echo "    <h3 style='font-size: 1.25rem; color: var(--text-pure);'>" . htmlspecialchars($pos_row['description']) . "</h3>";
                echo "    <span style='font-size: 0.75rem; color: var(--text-low); text-transform: uppercase; letter-spacing: 0.1em;'>Position ID: #" . $pos_row['id'] . "</span>";
                echo "  </div>";

                if ($vote_query->num_rows > 0) {
                    $has_voted = true;
                    $vote_row = $vote_query->fetch_assoc();
                    $candidate_id = $vote_row['candidate_id'];
                    $candidate_query = $conn->query("SELECT * FROM candidates WHERE id = '$candidate_id'");
                    $candidate_row = $candidate_query->fetch_assoc();

                    $photo_url = ($candidate_row['photo'] && file_exists('../assets/images/' . $candidate_row['photo'])) ? "../assets/images/" . htmlspecialchars($candidate_row['photo']) : "../assets/images/voter_default.png";
                    echo "  <div style='display: flex; align-items: center; gap: 2.5rem; padding: 1rem;'>";
                    echo "    <img src='" . $photo_url . "' style='width: 100px; height: 100px; border-radius: 20px; object-fit: cover; border: 2px solid var(--accent-red); box-shadow: 0 10px 20px rgba(0,0,0,0.3);'>";
                    echo "    <div>";
                    echo "      <h4 style='color: var(--accent-red); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;'>Allocated Selection</h4>";
                    echo "      <p style='font-size: 1.8rem; font-family: Outfit; font-weight: 800; color: var(--text-pure);'>" . htmlspecialchars($candidate_row['firstname'] . ' ' . $candidate_row['lastname']) . "</p>";
                    echo "      <div style='margin-top: 0.75rem; color: var(--text-low); font-size: 0.9rem; display: flex; align-items: center; gap: 8px;'><i class='fas fa-fingerprint' style='color: var(--accent-red);'></i> Encrypted Entry ID: " . bin2hex(random_bytes(6)) . "</div>";
                    echo "    </div>";
                    echo "  </div>";
                } else {
                    echo "  <div style='padding: 2rem; text-align: center; background: rgba(255,255,255,0.02); border-radius: var(--radius-md); color: var(--text-low); border: 2px dashed var(--glass-border);'>";
                    echo "    <i class='fas fa-ghost' style='font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;'></i>";
                    echo "    <p style='font-weight: 500;'>No selection was recorded for this position.</p>";
                    echo "  </div>";
                }
                echo "</div>";
            }

            if (!$has_voted) {
                echo "<div class='premium-card animate-up' style='text-align: center; padding: 5rem; border: 2px dashed var(--accent-red);'>";
                echo "  <i class='fas fa-box-open' style='font-size: 4rem; color: var(--accent-red); opacity: 0.3; margin-bottom: 2rem;'></i>";
                echo "  <h2 style='font-size: 2rem; margin-bottom: 1rem;'>Empty Ballot Detected</h2>";
                echo "  <p style='color: var(--text-mid); margin-bottom: 3rem;'>Our systems show no recorded activity for your ID. Access the digital ballot to participate.</p>";
                echo "  <a href='ballot.php' class='btn btn-primary' style='padding: 1rem 3rem;'>Access Core Ballot</a>";
                echo "</div>";
            }
        }
        ?>
    </div>
</div>

<?php include '../includes/voter_footer.php'; ?>