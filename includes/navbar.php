<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="landing-navbar">
    <div class="navbar-container">
        <a href="index.php" style="display: flex; align-items: center; gap: 12px; margin-bottom: 0;">
            <div class="brand-icon" style="width: 36px; height: 36px;">
                <i class="fas fa-shield-halved" style="font-size: 1rem;"></i>
            </div>
            <span class="brand-name" style="font-size: 1.25rem;">VoteXpress</span>
        </a>
        
        <ul class="nav-links">
            <li><a href="about.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active-link' : ''; ?>">Intelligence</a></li>
            <li><a href="contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active-link' : ''; ?>">Support</a></li>
            <li><a href="privacy.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'privacy.php' ? 'active-link' : ''; ?>">Protocols</a></li>
        </ul>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <div class="auth-buttons">
                <?php if (isset($_SESSION['admin']) || isset($_SESSION['voter'])): ?>
                    <a href="<?php echo isset($_SESSION['admin']) ? 'admin/dashboard.php' : 'voter/ballot.php'; ?>"
                        class="btn btn-primary btn-sm">
                        Command
                    </a>
                <?php else: ?>
                    <a href="index.php#login" class="btn btn-primary btn-sm">Access</a>
                <?php endif; ?>
            </div>
            <button class="menu-toggle" id="mobileMenuBtn" style="display: none;">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

<div class="mobile-drawer" id="mobileDrawer">
    <div style="padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
            <span class="brand-name" style="font-size: 1.25rem;">Menu</span>
            <button class="menu-toggle" id="closeDrawerBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="about.php"><i class="fas fa-microchip"></i> Intelligence</a></li>
            <li><a href="contact.php"><i class="fas fa-headset"></i> Support</a></li>
            <li><a href="privacy.php"><i class="fas fa-shield-alt"></i> Protocols</a></li>
            <?php if (isset($_SESSION['admin']) || isset($_SESSION['voter'])): ?>
                <li><a href="<?php echo isset($_SESSION['admin']) ? 'admin/dashboard.php' : 'voter/ballot.php'; ?>"><i class="fas fa-terminal"></i> Command Center</a></li>
            <?php else: ?>
                <li><a href="index.php#login"><i class="fas fa-key"></i> Access System</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<style>
    .landing-navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        padding: 1.25rem 2rem;
        background: rgba(5, 5, 5, 0.7);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--glass-border);
    }

    .navbar-container {
        max-width: var(--container-max);
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-links {
        display: flex;
        gap: 3rem;
        list-style: none;
    }

    .nav-links a {
        color: var(--text-mid);
        font-weight: 600;
        font-size: 0.9rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        transition: var(--transition-fast);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .nav-links a:hover, .nav-links a.active-link {
        color: var(--accent-red);
    }

    .auth-buttons {
        display: flex;
        gap: 1.5rem;
    }

    /* Mobile Drawer */
    .mobile-drawer {
        position: fixed;
        top: 0;
        right: -100%;
        width: 300px;
        height: 100vh;
        background: var(--bg-surface);
        z-index: 2000;
        transition: right 0.4s var(--ease-out);
        border-left: 1px solid var(--glass-border);
        box-shadow: -20px 0 40px rgba(0,0,0,0.5);
    }

    .mobile-drawer.active {
        right: 0;
    }

    .mobile-nav-links {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .mobile-nav-links a {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-mid);
        padding: 0.8rem 1rem;
        border-radius: var(--radius-md);
        transition: var(--transition-fast);
    }

    .mobile-nav-links a:hover {
        background: var(--bg-hover);
        color: var(--accent-red);
    }

    @media (max-width: 900px) {
        .nav-links {
            display: none;
        }
        #mobileMenuBtn {
            display: flex !important;
        }
        .landing-navbar {
            padding: 1rem 1.5rem;
        }
        .auth-buttons {
            display: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const drawer = document.getElementById('mobileDrawer');
        const openBtn = document.getElementById('mobileMenuBtn');
        const closeBtn = document.getElementById('closeDrawerBtn');

        if (openBtn) {
            openBtn.addEventListener('click', () => {
                drawer.classList.add('active');
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                drawer.classList.remove('active');
            });
        }

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') drawer.classList.remove('active');
        });
    });
</script>
