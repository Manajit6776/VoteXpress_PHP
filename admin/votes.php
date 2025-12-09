<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}
include '../db_connect.php';

include '../includes/admin_header.php';
?>
<div class="header">
    <h2>Votes Report</h2>
</div>
<div class="content-box">
    <table>
        <thead>
            <tr>
                <th>Voters ID</th>
                <th>Voter Name</th>
                <th>Position</th>
                <th>Candidate</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT votes.voters_id, voters.firstname AS voter_fn, voters.lastname AS voter_ln, positions.description AS pos_desc, candidates.firstname AS cand_fn, candidates.lastname AS cand_ln FROM votes LEFT JOIN voters ON voters.voters_id=votes.voters_id LEFT JOIN candidates ON candidates.id=votes.candidate_id LEFT JOIN positions ON positions.id=votes.position_id ORDER BY votes.voters_id ASC";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $row['voters_id']; ?></td>
                    <td><?php echo $row['voter_fn'] . ' ' . $row['voter_ln']; ?></td>
                    <td><?php echo $row['pos_desc']; ?></td>
                    <td><?php echo $row['cand_fn'] . ' ' . $row['cand_ln']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/admin_footer.php'; ?>