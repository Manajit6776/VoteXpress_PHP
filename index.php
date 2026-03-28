<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoteXpress - Secure Online Voting Ecosystem</title>
    <!-- Favicon Placeholders would go here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Landing Page Specific Enhancements */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8rem 2rem 4rem;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .hero-content {
            max-width: 900px;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 59, 59, 0.1);
            border: 1px solid rgba(255, 59, 59, 0.2);
            padding: 0.6rem 1.2rem;
            border-radius: var(--radius-full);
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--accent-red);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 2rem;
        }

        .hero-title {
            font-size: clamp(3rem, 10vw, 7rem);
            line-height: 0.95;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #fff 0%, #aaa 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-mid);
            margin-bottom: 3rem;
            max-width: 650px;
            margin-inline: auto;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: var(--container-max);
            margin: 6rem auto;
            padding: 0 2rem;
        }

        .login-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            max-width: 900px;
            margin: 6rem auto;
            padding: 0 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: clamp(2.5rem, 8vw, 4rem);
            margin-bottom: 1rem;
            font-weight: 800;
        }

        .section-subtitle {
            color: var(--text-low);
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <div class="bg-glow glow-top-right"></div>
    <div class="bg-glow glow-bottom-left"></div>

    <?php include 'includes/navbar.php'; ?>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content animate-up">
                <div class="hero-badge">
                    <i class="fas fa-shield-halved"></i> Military Grade Security
                </div>
                <h1 class="hero-title">Shaping Democracy with Technology</h1>
                <p class="hero-subtitle">Experience a secure, transparent, and seamless voting journey. Built on modern encryption to ensure every voice is heard and every vote is protected.</p>
                <div style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap;">
                    <a href="#login" class="btn btn-primary btn-lg">Cast Your Vote Now</a>
                    <a href="about.php" class="btn btn-outline btn-lg">Explore Platform <i class="fas fa-arrow-right" style="margin-left: 8px;"></i></a>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section style="padding: 6rem 0;">
            <div class="section-header container">
                <h2 class="section-title">The VoteXpress Difference</h2>
                <p class="section-subtitle">We don't just count votes; we protect the future.</p>
            </div>
            <div class="feature-grid">
                <div class="premium-card">
                    <div class="brand-icon" style="margin-bottom: 1.5rem;">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3 style="margin-bottom: 1rem; font-size: 1.5rem;">Unbreakable Encryption</h3>
                    <p style="color: var(--text-mid);">Advanced cryptographic protocols ensure that your identity and selections remain strictly confidential and tamper-proof.</p>
                </div>

                <div class="premium-card">
                    <div class="brand-icon" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, var(--accent-green), #00A669); box-shadow: 0 8px 16px var(--accent-green-glow);">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 style="margin-bottom: 1rem; font-size: 1.5rem;">Instant Results</h3>
                    <p style="color: var(--text-mid);">Real-time tallying allows for immediate insight into election progress without the long wait times of traditional paper ballots.</p>
                </div>

                <div class="premium-card">
                    <div class="brand-icon" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #3B82F6, #1E40AF); box-shadow: 0 8px 16px rgba(59, 130, 246, 0.5);">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3 style="margin-bottom: 1rem; font-size: 1.5rem;">Inclusive Access</h3>
                    <p style="color: var(--text-mid);">Accessible from any device, anywhere. We break down physical barriers to participation in any community or organization.</p>
                </div>
            </div>
        </section>

        <!-- Login Selection -->
        <section id="login" style="padding: 6rem 0; background: rgba(255,255,255,0.02);">
            <div class="section-header container">
                <h2 class="section-title">Access Your Portal</h2>
                <p class="section-subtitle">Secure entrance for registered voters and administrators.</p>
            </div>
            <div class="login-grid">
                <div class="premium-card" style="text-align: center;">
                    <div style="width: 80px; height: 80px; background: rgba(0, 245, 155, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; color: var(--accent-green); font-size: 2rem;">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3 style="font-size: 1.8rem; margin-bottom: 1rem;">Voter Gateway</h3>
                    <p style="color: var(--text-mid); margin-bottom: 2rem;">Enter your secure credentials to view and participate in active elections assigned to you.</p>
                    <a href="voter/voterlogin.php" class="btn btn-secondary" style="width: 100%;">Access Ballot</a>
                </div>

                <div class="premium-card" style="text-align: center;">
                    <div style="width: 80px; height: 80px; background: rgba(255, 59, 59, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; color: var(--accent-red); font-size: 2rem;">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 style="font-size: 1.8rem; margin-bottom: 1rem;">Admin Console</h3>
                    <p style="color: var(--text-mid); margin-bottom: 2rem;">Authorized personnel access to manage candidates, positions, and track election integrity.</p>
                    <a href="admin/adminlogin.php" class="btn btn-primary" style="width: 100%;">Admin Login</a>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/site_footer.php'; ?>

    <script>
        // Smooth scroll for anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>