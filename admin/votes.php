<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}
include '../db_connect.php';
include '../includes/admin_header.php';
?>

<div class="flex-responsive" style="justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem; gap: 1rem;">
    <div>
        <h1 style="font-size: 2.22rem; margin-bottom: 0.2rem;">Electoral Audit Log</h1>
        <p style="color: var(--text-mid); font-size: 0.95rem;">Tamper-evident record of all processed ballots and voter activity.</p>
    </div>
    <div style="display: flex; gap: 1rem;" class="full-width-mobile">
        <button class="btn btn-outline btn-sm full-width-mobile" onclick="window.print()">
            <i class="fas fa-print"></i> Generate Audit PDF
        </button>
    </div>
</div>

<div class="premium-card" style="padding: 0;">
    <div style="padding: 1.25rem 2rem; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center;">
        <h2 style="font-size: 1rem; color: var(--text-pure); display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-shield-check" style="color: var(--accent-green); font-size: 0.85rem;"></i> Verified Vote Transactions
        </h2>
    </div>

    <div class="table-container" style="margin-top: 0; border: none; border-radius: 0;">
        <table>
            <thead>
                <tr>
                    <th>Transaction ID (Voter)</th>
                    <th>Voter Full Name</th>
                    <th>Contested Position</th>
                    <th>Allocated Choice (Candidate)</th>
                    <th style="text-align: right;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT 
                            votes.voters_id, 
                            voters.firstname AS voter_fn, 
                            voters.lastname AS voter_ln, 
                            positions.description AS pos_desc, 
                            candidates.firstname AS cand_fn, 
                            candidates.lastname AS cand_ln 
                        FROM votes 
                        LEFT JOIN voters ON voters.voters_id=votes.voters_id 
                        LEFT JOIN candidates ON candidates.id=votes.candidate_id 
                        LEFT JOIN positions ON positions.id=votes.position_id 
                        ORDER BY votes.voters_id ASC";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                        <tr>
                            <td>
                                <code style="background: rgba(0, 245, 155, 0.05); color: var(--accent-green); padding: 4px 10px; border-radius: 6px; font-weight: 700; font-family: monospace; font-size: 0.85rem; border: 1px solid rgba(0, 245, 155, 0.1);">
                                    <?php echo htmlspecialchars($row['voters_id']); ?>
                                </code>
                            </td>
                            <td style="font-weight: 600; color: var(--text-pure); font-size: 0.9rem;">
                                <?php echo htmlspecialchars($row['voter_fn'] . ' ' . $row['voter_ln']); ?>
                            </td>
                            <td style="color: var(--text-mid); font-size: 0.9rem;">
                                <?php echo htmlspecialchars($row['pos_desc']); ?>
                            </td>
                            <td style="font-weight: 700; color: var(--text-pure);">
                                <?php echo htmlspecialchars($row['cand_fn'] . ' ' . $row['cand_ln']); ?>
                            </td>
                            <td style="text-align: right;">
                                <span class="badge" style="background: rgba(0, 245, 155, 0.1); color: var(--accent-green); font-size: 0.7rem; padding: 0.2rem 0.6rem;">
                                    <i class="fas fa-circle" style="font-size: 0.5rem; margin-right: 4px;"></i> Encrypted
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 5rem; color: var(--text-low);">
                            <i class="fas fa-box-archive" style="font-size: 3rem; margin-bottom: 1.5rem; display: block; opacity: 0.2;"></i>
                            Legislative vault is currently empty. No votes recorded.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
echo '</div>'; // Close content-area
include '../includes/admin_footer.php'; 
?>