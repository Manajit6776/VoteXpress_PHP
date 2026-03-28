<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../db_connect.php';

$election_title_query = $conn->query("SELECT title FROM election_title WHERE id = 1");
$election_title = $election_title_query->fetch_assoc()['title'] ?? 'Online Voting System';

$voter_name = "Authenticated Voter";
$voter_photo = "voter_default.png";

if (isset($_SESSION['voter'])) {
    $voter_id = $_SESSION['voter'];
    $voter_info_query = $conn->query("SELECT firstname, lastname, photo FROM voters WHERE voters_id = '$voter_id'");
    if ($voter_info_query && $voter_info_query->num_rows > 0) {
        $voter_info = $voter_info_query->fetch_assoc();
        $voter_name = htmlspecialchars($voter_info['firstname'] . ' ' . $voter_info['lastname']);
        $voter_photo = htmlspecialchars($voter_info['photo'] ?: 'voter_default.png');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Ballot - VoteXpress</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .voter-nav {
            background: var(--bg-surface);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: var(--glass-blur);
        }
    </style>
</head>

<body>
    <div class="bg-glow glow-top-right" style="opacity: 0.2;"></div>
    
    <nav class="voter-nav">
        <a href="ballot.php" class="sidebar-brand" style="margin-bottom: 0; padding-left: 0;">
            <div class="brand-icon">
                <i class="fas fa-vote-yea"></i>
            </div>
            <span class="brand-name">VoteXpress</span>
        </a>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <div class="voter-profile" style="display: flex; align-items: center; gap: 1rem; padding-right: 1.5rem; border-right: 1px solid var(--glass-border);">
                <img src="../assets/images/<?php echo $voter_photo; ?>" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--accent-green); object-fit: cover;">
                <div class="voter-meta" style="line-height: 1.2;">
                    <div style="font-weight: 700; color: var(--text-pure); font-size: 0.95rem;"><?php echo $voter_name; ?></div>
                    <div style="color: var(--accent-green); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Verified Voter</div>
                </div>
            </div>
            <a href="logout.php" class="btn btn-primary btn-sm" style="background: var(--bg-hover); color: var(--accent-red); box-shadow: none; border: 1px solid rgba(255,59,59,0.1);">
                <i class="fas fa-power-off"></i> <span class="logout-text">Logout</span>
            </a>
        </div>
    </nav>

    <style>
        @media (max-width: 768px) {
            .voter-nav {
                padding: 1rem !important;
            }
            .voter-meta, .logout-text {
                display: none;
            }
            .voter-profile {
                padding-right: 0 !important;
                border-right: none !important;
            }
        }
    </style>

    <main class="animate-up" style="max-width: 1000px; margin: 4rem auto; padding: 0 2rem;">