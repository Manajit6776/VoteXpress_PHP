<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - VoteXpress</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .about-hero {
            padding: 10rem 2rem 6rem;
            text-align: center;
            background: radial-gradient(circle at top, rgba(255, 59, 59, 0.1) 0%, transparent 70%);
        }
        
        .content-section {
            max-width: 900px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        .about-card {
            background: var(--bg-surface);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-lg);
            padding: 3rem;
            margin-bottom: 2rem;
        }

        .section-tag {
            display: inline-block;
            padding: 0.4rem 1rem;
            background: rgba(0, 245, 155, 0.1);
            color: var(--accent-green);
            border-radius: var(--radius-full);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .about-title {
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }

        .about-text {
            color: var(--text-mid);
            font-size: 1.15rem;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .highlight-red { color: var(--accent-red); font-weight: 700; }
    </style>
</head>

<body>
    <div class="bg-glow glow-top-right"></div>
    <div class="bg-glow glow-bottom-left"></div>

    <?php include 'includes/navbar.php'; ?>

    <main>
        <section class="about-hero animate-up">
            <span class="section-tag">Our Legacy</span>
            <h1 class="about-title">About <span class="highlight-red">VoteXpress</span></h1>
            <p class="about-text" style="max-width: 700px; margin-inline: auto;">Welcome to the next generation of democratic participation. We've built more than a software; we've built a trust-engine for the future of elective processes.</p>
        </section>

        <section class="content-section">
            <div class="about-card animate-up">
                <h2 style="font-size: 2rem; margin-bottom: 1.5rem;">The Mission</h2>
                <p class="about-text">Our mission is simple yet profound: To modernize and secure the global voting process. By combining cutting-edge encryption with an intuitive, human-centered interface, we empower organizations and communities to conduct elections that are beyond reproach.</p>
                <p class="about-text">We believe in a world where physical distance or technical barriers should never prevent a legitimate voice from being heard. VoteXpress is the bridge between traditional integrity and modern accessibility.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                <div class="premium-card">
                    <h3 style="color: var(--accent-red); margin-bottom: 1rem;"><i class="fas fa-shield-halved" style="margin-right: 10px;"></i> Integrity</h3>
                    <p style="color: var(--text-mid);">A commitment to the absolute sanctity of every ballot. Our transparent protocols ensure that results are verifiable by all stakeholders, reducing disputes and building communal trust.</p>
                </div>
                <div class="premium-card">
                    <h3 style="color: var(--accent-green); margin-bottom: 1rem;"><i class="fas fa-universal-access" style="margin-right: 10px;"></i> Accessibility</h3>
                    <p style="color: var(--text-mid);">Democracy is at its best when it's frictionless. Our mobile-ready platform ensures that voting is as easy as sending a message, without compromising on any security aspect.</p>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/site_footer.php'; ?>
</body>

</html>
