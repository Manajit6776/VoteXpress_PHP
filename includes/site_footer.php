<footer style="background: var(--bg-main); padding: 5rem 2rem 3rem; border-top: 1px solid var(--glass-border); margin-top: 6rem;">
    <div class="navbar-container" style="display: flex; flex-direction: column; align-items: center; gap: 3rem;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 0;">
            <div class="brand-icon" style="width: 44px; height: 44px; background: linear-gradient(135deg, var(--accent-red), #990000); box-shadow: 0 10px 20px var(--accent-red-glow);">
                <i class="fas fa-microchip"></i>
            </div>
            <span class="brand-name" style="font-size: 1.8rem;">VoteXpress</span>
        </div>
        
        <div style="display: flex; gap: 3rem; flex-wrap: wrap; justify-content: center;">
            <a href="about.php" style="color: var(--text-mid); font-weight: 600; font-size: 0.9rem; letter-spacing: 0.05em; text-transform: uppercase;">Intelligence</a>
            <a href="contact.php" style="color: var(--text-mid); font-weight: 600; font-size: 0.9rem; letter-spacing: 0.05em; text-transform: uppercase;">Direct Line</a>
            <a href="privacy.php" style="color: var(--text-mid); font-weight: 600; font-size: 0.9rem; letter-spacing: 0.05em; text-transform: uppercase;">Protocols</a>
            <a href="#" style="color: var(--text-mid); font-weight: 600; font-size: 0.9rem; letter-spacing: 0.05em; text-transform: uppercase;">Terms</a>
        </div>
        
        <div style="display: flex; gap: 1.5rem;">
            <!-- <a href="#" class="social-link"><i class="fab fa-twitter"></i></a> -->
            <a href="https://www.linkedin.com/in/manajit-mondal-032371387" class="social-link"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://github.com/Manajit6776" class="social-link"><i class="fab fa-github"></i></a>
        </div>
        
        <div style="text-align: center; border-top: 1px solid var(--glass-border); padding-top: 2rem; width: 100%; max-width: 600px;">
            <p style="color: var(--text-low); font-size: 0.85rem; line-height: 1.8;">
                &copy; <?php echo date('Y'); ?> VoteXpress Strategic Systems. All rights reserved. <br>
                <span style="color: var(--accent-red); font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.2em;">Secure / Encrypted / Auditable</span>
            </p>
        </div>
    </div>
</footer>

<style>
    .social-link {
        width: 44px; 
        height: 44px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        background: var(--bg-surface); 
        border-radius: var(--radius-md); 
        color: var(--text-mid);
        border: 1px solid var(--glass-border);
        transition: var(--transition-fast);
    }
    .social-link:hover {
        background: var(--bg-hover);
        color: var(--accent-red);
        border-color: var(--accent-red);
        transform: translateY(-5px);
    }
</style>
