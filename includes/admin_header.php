<?php
include_once '../db_connect.php';

$election_title_query = $conn->query("SELECT title FROM election_title WHERE id = 1");
$election_title = $election_title_query->fetch_assoc()['title'] ?? 'Online Voting System';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Command - VoteXpress</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: var(--bg-surface);
            border-bottom: 1px solid var(--glass-border);
            margin: -2rem -2rem 2rem -2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <aside class="sidebar">
            <a href="dashboard.php" class="sidebar-brand">
                <div class="brand-icon">
                    <i class="fas fa-vote-yea"></i>
                </div>
                <span class="brand-name">VoteXpress</span>
            </a>
            
            <ul class="sidebar-menu">
                <li class="menu-label">Reports</li>
                <li><a href="dashboard.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="votes.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'votes.php' ? 'active' : ''; ?>"><i class="fas fa-chart-pie"></i> Vote Tally</a></li>
                
                <li class="menu-label">Administration</li>
                <li><a href="voters.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'voters.php' ? 'active' : ''; ?>"><i class="fas fa-users-gear"></i> Voter Registry</a></li>
                <li><a href="positions.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'positions.php' ? 'active' : ''; ?>"><i class="fas fa-sitemap"></i> Positions</a></li>
                <li><a href="candidates.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'candidates.php' ? 'active' : ''; ?>"><i class="fas fa-user-tie"></i> Candidates</a></li>
                
                <li class="menu-label">Configuration</li>
                <li><a href="ballot_position.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'ballot_position.php' ? 'active' : ''; ?>"><i class="fas fa-layer-group"></i> Ballot Flow</a></li>
                <li><a href="election_title.php" class="sidebar-link <?php echo basename($_SERVER['PHP_SELF']) == 'election_title.php' ? 'active' : ''; ?>"><i class="fas fa-pen-nib"></i> Election Title</a></li>
            </ul>
            
            <div style="margin-top: auto; padding-top: 2rem; border-top: 1px solid var(--glass-border);">
                <a href="logout.php" class="sidebar-link" style="color: var(--accent-red);"><i class="fas fa-power-off"></i> Terminate Session</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-nav">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <button class="menu-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 style="font-size: 1.25rem; font-weight: 700; color: var(--text-pure); display: flex; align-items: center; gap: 12px;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ff737c" width="30px"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM9.71002 19.6674C8.74743 17.6259 8.15732 15.3742 8.02731 13H4.06189C4.458 16.1765 6.71639 18.7747 9.71002 19.6674ZM10.0307 13C10.1811 15.4388 10.8778 17.7297 12 19.752C13.1222 17.7297 13.8189 15.4388 13.9693 13H10.0307ZM19.9381 13H15.9727C15.8427 15.3742 15.2526 17.6259 14.29 19.6674C17.2836 18.7747 19.542 16.1765 19.9381 13ZM4.06189 11H8.02731C8.15732 8.62577 8.74743 6.37407 9.71002 4.33256C6.71639 5.22533 4.458 7.8235 4.06189 11ZM10.0307 11H13.9693C13.8189 8.56122 13.1222 6.27025 12 4.24799C10.8778 6.27025 10.1811 8.56122 10.0307 11ZM14.29 4.33256C15.2526 6.37407 15.8427 8.62577 15.9727 11H19.9381C19.542 7.8235 17.2836 5.22533 14.29 4.33256Z"></path></svg>
                        <span class="nav-title"><?php echo htmlspecialchars($election_title); ?></span>
                    </h1>
                </div>
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <div style="text-align: right; line-height: 1.2;">
                        <div style="font-size: 0.85rem; font-weight: 700; color: var(--text-high);">System Admin</div>
                        <div style="font-size: 0.75rem; color: var(--accent-green);">Session Encrypted</div>
                    </div>
                </div>
            </header>
            <div class="sidebar-overlay" id="sidebarOverlay"></div>
            <div class="animate-up" id="main-animate-area">

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sidebar = document.querySelector('.sidebar');
                    const toggle = document.getElementById('sidebarToggle');
                    const overlay = document.getElementById('sidebarOverlay');

                    if (toggle) {
                        toggle.addEventListener('click', () => {
                            sidebar.classList.toggle('active');
                            overlay.classList.toggle('active');
                        });
                    }

                    if (overlay) {
                        overlay.addEventListener('click', () => {
                            sidebar.classList.remove('active');
                            overlay.classList.remove('active');
                        });
                    }
                });
            </script>