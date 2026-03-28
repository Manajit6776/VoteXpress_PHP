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

<div>
    <?php if ($voter_has_voted): ?>
        <div class="premium-card animate-up" style="text-align: center; padding: 5rem 3rem;">
            <div style="width: 100px; height: 100px; background: rgba(0, 245, 155, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2.5rem; color: var(--accent-green);">
                <i class="fas fa-check-double" style="font-size: 3rem;"></i>
            </div>
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: #fff;">Ballot Successfully Processed</h1>
            <p style="color: var(--text-mid); font-size: 1.15rem; margin-bottom: 3rem; max-width: 600px; margin-inline: auto;">Thank you for exercising your democratic right. Your choices have been cryptographically secured and recorded in the system.</p>
            <a href="view_ballot.php" class="btn btn-secondary btn-lg" style="width: 100%; max-width: 300px; border-radius: var(--radius-lg);">
                <i class="fas fa-receipt"></i> Inspect My Ballot
            </a>
        </div>
    <?php else: ?>
        <div style="margin-bottom: 4rem; text-align: center;">
            <h1 style="font-size: clamp(2rem, 8vw, 3rem); margin-bottom: 0.5rem;">Official Digital Ballot</h1>
            <p style="color: var(--text-low); font-size: 1.1rem; padding: 0 1rem;">Please select one candidate for each of the following contested positions.</p>
        </div>
        
        <form action="submit_vote.php" method="POST" id="ballotForm">
            <?php
            $positions_result = $conn->query("SELECT * FROM positions ORDER BY priority ASC");
            while ($pos_row = $positions_result->fetch_assoc()) {
                echo "<div class='premium-card' style='margin-bottom: 3rem; border-left: 5px solid var(--accent-red);'>";
                echo "  <div class='flex-responsive' style='justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 1.5rem; gap: 1rem;'>";
                echo "    <h2 style='font-size: 1.4rem; color: var(--text-pure); display: flex; align-items: center; gap: 12px;'>
                            <i class='fas fa-briefcase' style='color: var(--accent-red); font-size: 1rem;'></i>" 
                            . htmlspecialchars($pos_row['description']) . "</h2>";
                echo "    <span class='badge' style='background: rgba(255,255,255,0.05); color: var(--text-low);'>Select One Candidate Only</span>";
                echo "  </div>";
                
                echo "  <div style='display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;'>";
                
                $candidates_result = $conn->query("SELECT * FROM candidates WHERE position_id = " . $pos_row['id']);
                while ($cand_row = $candidates_result->fetch_assoc()) {
                    $cand_id = $cand_row['id'];
                    $full_name = htmlspecialchars($cand_row['firstname'] . ' ' . $cand_row['lastname']);
                    $photo_path = '../assets/images/' . (($cand_row['photo'] && file_exists('../assets/images/' . $cand_row['photo'])) ? htmlspecialchars($cand_row['photo']) : 'voter_default.png');
                    
                    echo "<div class='candidate-option'>";
                    echo "  <input type='radio' id='candidate_" . $cand_id . "' name='position_" . $pos_row['id'] . "' value='" . $cand_id . "' required style='display: none;'>";
                    echo "  <label for='candidate_" . $cand_id . "' class='candidate-label-card'>";
                    echo "    <div class='candidate-avatar-container'>";
                    echo "      <img src='" . $photo_path . "' class='cand-img'>";
                    echo "      <div class='selection-indicator'><i class='fas fa-check'></i></div>";
                    echo "    </div>";
                    echo "    <div style='text-align: center;'>";
                    echo "      <h4 style='font-size: 1.15rem; margin-bottom: 0.3rem;'>" . $full_name . "</h4>";
                    echo "      <p style='font-size: 0.8rem; color: var(--text-low); text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em;'>Qualified Nominee</p>";
                    if (!empty($cand_row['platform'])) {
                        echo "    <button type='button' class='btn btn-outline btn-sm' style='margin-top: 1.2rem; border: none; background: var(--bg-hover);' data-platform='" . htmlspecialchars($cand_row['platform']) . "' onclick='openPlatformModal(this, \"" . $full_name . "\", event)'><i class='fas fa-eye'></i> View Platform</button>";
                    }
                    echo "    </div>";
                    echo "  </label>";
                    echo "</div>";
                }
                echo "  </div>";
                echo "</div>";
            }
            ?>
            <div class="flex-responsive" style="position: sticky; bottom: 2rem; background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); padding: 1.5rem 3rem; border-radius: var(--radius-xl); box-shadow: 0 20px 40px rgba(0,0,0,0.5); display: flex; justify-content: space-between; align-items: center; margin-top: 4rem; gap: 1.5rem;">
                <p style="color: var(--text-mid); font-weight: 500; text-align: center;"><i class="fas fa-info-circle" style="margin-right: 8px; color: var(--accent-red);"></i> Review your selections before selection.</p>
                <button type="submit" name="submit_vote" class="btn btn-secondary btn-lg full-width-mobile" style="padding: 1rem 3rem; border-radius: var(--radius-md); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 800;">
                    <i class="fas fa-paper-plane" style="margin-right: 12px;"></i> Finalize Ballot
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>

<!-- Better Modal Design -->
<div id="platformModal" class="modal-overlay">
    <div class="modal auth-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 1.5rem;">
            <h3 id="modal-candidate-name" style="font-size: 1.5rem; color: var(--accent-red);">Candidate Platform</h3>
            <button onclick="closeModal('platformModal')" style="background: none; border: none; color: var(--text-low); cursor: pointer; font-size: 1.5rem;"><i class="fas fa-times"></i></button>
        </div>
        <div id="platform-content" style="color: var(--text-high); line-height: 1.8; font-size: 1.1rem;"></div>
        <div style="margin-top: 3rem; text-align: right;">
            <button class="btn btn-outline" onclick="closeModal('platformModal')">Close View</button>
        </div>
    </div>
</div>

<style>
    .candidate-label-card {
        display: block;
        background: var(--bg-surface);
        border: 2px solid var(--glass-border);
        border-radius: var(--radius-lg);
        padding: 2rem 1.5rem;
        cursor: pointer;
        transition: var(--transition-normal);
        position: relative;
    }
    
    .candidate-avatar-container {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto 1.5rem;
    }

    .cand-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--glass-border);
        transition: var(--transition-normal);
    }

    .selection-indicator {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 32px;
        height: 32px;
        background: var(--accent-green);
        color: #000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        transform: scale(0);
        transition: var(--transition-fast);
        opacity: 0;
    }

    input[type="radio"]:checked + .candidate-label-card {
        border-color: var(--accent-green);
        background: rgba(0, 245, 155, 0.05);
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.5), 0 0 20px rgba(0, 245, 155, 0.1);
    }

    input[type="radio"]:checked + .candidate-label-card .cand-img {
        border-color: var(--accent-green);
        box-shadow: 0 0 20px var(--accent-green-glow);
    }

    input[type="radio"]:checked + .candidate-label-card .selection-indicator {
        transform: scale(1);
        opacity: 1;
    }

    .candidate-label-card:hover {
        border-color: rgba(255,255,255,0.25);
        background: var(--bg-hover);
        transform: translateY(-5px);
    }
</style>

<script>
    function openModal(modalId, event) {
        const modal = document.getElementById(modalId);
        const card = modal.querySelector('.modal');
        
        modal.style.display = 'flex';
        modal.style.alignItems = 'center'; 
        modal.style.justifyContent = 'center';
        card.style.position = '';
        card.style.top = '';
        card.style.left = '';
        card.style.margin = '';
        card.style.opacity = '0';

        modal.classList.add('active');
        document.body.style.overflow = 'hidden';

        if (event && window.innerWidth > 768) {
            const mouseX = event.clientX;
            const mouseY = event.clientY;
            
            setTimeout(() => {
                modal.style.display = 'block';
                card.style.position = 'absolute';
                card.style.margin = '0';

                const cardWidth = card.offsetWidth || 500;
                const cardHeight = card.offsetHeight || 500;
                
                let top = mouseY - 50;
                let left = mouseX + 25;

                if (left + cardWidth > window.innerWidth) {
                    left = window.innerWidth - cardWidth - 25;
                }
                if (top + cardHeight > window.innerHeight) {
                    top = window.innerHeight - cardHeight - 15;
                }
                
                if (left < 15) left = 15;
                if (top < 15) top = 15;

                card.style.top = top + 'px';
                card.style.left = left + 'px';
                card.style.opacity = '1';
                card.style.transform = 'scale(1)';
                card.style.transition = 'opacity 0.2s ease, top 0.2s ease, left 0.2s ease';
            }, 50);
        } else {
            card.style.opacity = '1';
            card.style.margin = '0 auto';
            card.style.top = '10%'; 
            card.style.position = 'relative';
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        const card = modal.querySelector('.modal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
        
        setTimeout(() => {
            modal.style.display = '';
            card.style.top = '';
            card.style.left = '';
            card.style.position = '';
        }, 400);
    }

    function openPlatformModal(button, candName, event) {
        var platformText = button.getAttribute('data-platform');
        document.getElementById('platform-content').textContent = platformText;
        document.getElementById('modal-candidate-name').textContent = candName + "'s Platform";
        openModal('platformModal', event);
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            closeModal(event.target.id);
        }
    }
</script>

<?php 
echo '</main>'; // Close main from header
include '../includes/voter_footer.php'; 
?>