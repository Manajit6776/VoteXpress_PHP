<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
    exit();
}
include '../db_connect.php';
include '../includes/admin_header.php';

$positions_result = $conn->query("SELECT * FROM positions ORDER BY priority ASC");
?>

<div class="flex-responsive" style="justify-content: space-between; align-items: flex-end; margin-bottom: 3rem; gap: 1.5rem;">
    <div>
        <h1 style="font-size: 2.22rem; margin-bottom: 0.2rem;">Ballot Sequencing</h1>
        <p style="color: var(--text-mid); font-size: 0.95rem;">Drag and drop positions to define the structural order on the digital ballot.</p>
    </div>
</div>

<div class="premium-card animate-up" style="max-width: 800px; width: 100%;">
    <div style="padding: 1rem 1.5rem; background: rgba(255,59,59,0.05); border-radius: 12px; margin-bottom: 2rem; border: 1px dashed rgba(255,59,59,0.2); display: flex; align-items: center; gap: 12px; color: var(--accent-red); font-size: 0.9rem;">
        <i class="fas fa-info-circle"></i>
        <span>Sequence changes are saved in real-time as you reorder the list below.</span>
    </div>

    <div id="position-list" style="display: flex; flex-direction: column; gap: 0.75rem;">
        <?php if ($positions_result->num_rows > 0): ?>
            <?php while ($row = $positions_result->fetch_assoc()): ?>
                <div class="list-draggable-item" data-id="<?php echo $row['id']; ?>" 
                     style="background: var(--bg-surface); padding: 1.25rem 1.5rem; border-radius: 12px; border: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center; cursor: grab; transition: all 0.2s ease;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <i class="fas fa-grip-vertical" style="color: var(--text-muted); cursor: grab;"></i>
                        <span style="font-weight: 600; color: var(--text-pure); font-size: 1rem;">
                            <?php echo htmlspecialchars($row['description']); ?>
                        </span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; color: var(--text-low); font-size: 0.85rem;">
                        <i class="fas fa-layer-group"></i> 
                        Ref: <?php echo $row['id']; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 4rem; color: var(--text-low);">
                <i class="fas fa-th-list" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                No positions available for sequencing.
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .list-draggable-item:hover {
        border-color: var(--accent-red);
        background: var(--bg-hover);
        transform: translateX(5px);
    }
    .sortable-ghost {
        opacity: 0.4;
        background: var(--accent-red) !important;
        border-style: dashed;
    }
    .sortable-drag {
        cursor: grabbing !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
</style>

<?php 
echo '</div>'; // Close content-area
include '../includes/admin_footer.php'; 
?>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const list = document.getElementById('position-list');
        if (list) {
            new Sortable(list, {
                animation: 250,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                onEnd: function() {
                    let order = [];
                    list.querySelectorAll('.list-draggable-item').forEach(item => {
                        order.push(item.getAttribute('data-id'));
                    });

                    fetch('update_ballot_order.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ order: order })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.status === 'success') {
                            console.log('Hierarchy sequence synchronized.');
                        }
                    });
                }
            });
        }
    });
</script>