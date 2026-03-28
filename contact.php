<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - VoteXpress</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 3rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        @media (max-width: 900px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
        }

        .contact-info-card {
            background: var(--bg-surface);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            height: fit-content;
        }

        .info-item {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 59, 59, 0.1);
            color: var(--accent-red);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <div class="bg-glow glow-top-right"></div>
    <div class="bg-glow glow-bottom-left"></div>

    <?php include 'includes/navbar.php'; ?>

    <main style="padding: 10rem 2rem 6rem;">
        <div class="section-header container">
            <h1 class="about-title animate-up">Get in <span style="color: var(--accent-red);">Touch</span></h1>
            <p class="about-text animate-up" style="max-width: 600px; margin: 0;">Have questions about election security or platform deployment? Our specialists are standing by to assist you.</p>
        </div>

        <section class="contact-grid animate-up">
            <div class="contact-info-card">
                <h3 style="font-size: 1.5rem; margin-bottom: 2rem;">Contact Information</h3>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h4 style="margin-bottom: 0.2rem;">Official Mail</h4>
                        <p style="color: var(--text-mid);">manajit.mondal21@gmail.com</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <h4 style="margin-bottom: 0.2rem;">Support Line</h4>
                        <p style="color: var(--text-mid);">+91 73xxxxxxxx</p>
                    </div>
                </div>

                <div class="info-item">
                    <!-- <div class="info-icon"><i class="fas fa-location-dot"></i></div> -->
                    <div>
                        <h4 style="margin-bottom: 0.2rem;"></h4>
                        <p style="color: var(--text-mid);"></p>
                    </div>
                </div>
            </div>

            <div class="premium-card">
                <h3 style="font-size: 1.5rem; margin-bottom: 2rem;">Send us a Message</h3>
                <form action="#" method="POST">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-input" placeholder="John" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-input" placeholder="Doe" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Electronic Mail</label>
                        <input type="email" class="form-input" placeholder="john@example.com" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message Subject</label>
                        <select class="form-input">
                            <option>Technical Support</option>
                            <option>Partnership Inquiry</option>
                            <option>Media & Press</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Detailed Message</label>
                        <textarea class="form-input" style="min-height: 150px;" placeholder="How can we help you today?" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">Transmit Message</button>
                </form>
            </div>
        </section>
    </main>

    <?php include 'includes/site_footer.php'; ?>
</body>

</html>