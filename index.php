<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoteXpress - Secure Online Voting</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #D32F2F;
            --secondary-color: #4CAF50;
            --dark-bg: #1A1A1A;
            --dark-bg-secondary: #212121;
            --text-light: #E0E0E0;
            --text-muted: #9E9E9E;
            --border-color: #383838;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--dark-bg);
            color: var(--text-light);
            line-height: 1.6;
        }

        /* Header Styles */
        header {
            background-color: var(--dark-bg-secondary);
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border-color);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo img {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            border: 2px solid var(--primary-color);
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }


        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .auth-buttons .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #b71c1c;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                url('assets/images/back1.jpeg') center / cover no-repeat;
            height: 88vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .hero-content {
            max-width: 800px;
            padding: 2rem;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-title {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 0 0 10px rgba(211, 47, 47, 0.8),
                0 0 20px rgba(211, 47, 47, 0.5),
                0 0 30px rgba(211, 47, 47, 0.3);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: var(--text-light);
        }

        /* Services Section */
        .services-section {
            padding: 4rem 2rem;
            background-color: var(--dark-bg-secondary);
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: var(--primary-color);
            text-shadow: 0 0 8px rgba(211, 47, 47, 0.6),
                0 0 15px rgba(211, 47, 47, 0.4);
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-card {
            background: var(--dark-bg);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s;
            border: 1px solid var(--border-color);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .service-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .service-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .service-description {
            color: var(--text-muted);
        }

        /* Login Options */
        .login-section {
            padding: 4rem 2rem;
            background-color: var(--dark-bg);
        }

        .login-options {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            max-width: 1000px;
            margin: 0 auto;
        }

        .login-card {
            background: var(--dark-bg-secondary);
            border-radius: 10px;
            padding: 2rem;
            width: 300px;
            text-align: center;
            transition: transform 0.3s;
            border: 1px solid var(--border-color);
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .login-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }

        .voter-icon {
            color: var(--primary-color);
        }

        .admin-icon {
            color: var(--secondary-color);
        }

        .login-btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 1.5rem;
            transition: all 0.3s;
        }

        .voter-btn {
            background-color: var(--primary-color);
            color: white;
        }

        .admin-btn {
            background-color: var(--secondary-color);
            color: white;
        }

        /* Footer */
        footer {
            background-color: var(--dark-bg-secondary);
            padding: 2rem;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .social-icons {
            margin-bottom: 1.5rem;
        }

        .social-icons a {
            color: var(--text-muted);
            margin: 0 0.5rem;
            font-size: 1.5rem;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: var(--primary-color);
        }

        .copyright {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <a href="index.php" class="logo">
                <img src="assets/images/logo.png" alt="VoteXpress Logo">
                <span class="logo-text">VoteXpress</span>
            </a>

            <nav class="nav-links">
                <a href="about.php">About Us</a>
                <a href="contact.php">Contact</a>
                <a href="privacy.php">Privacy Policy</a>
            </nav>

            <div class="auth-buttons">
                <?php if (isset($_SESSION['admin']) || isset($_SESSION['voter'])): ?>
                    <a href="<?php echo isset($_SESSION['admin']) ? 'admin/dashboard.php' : 'voter/ballot.php'; ?>"
                        class="btn btn-primary">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="#login" class="btn btn-primary">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <section class="hero-section">
        <div class="hero-content">

        </div>
    </section>

    <section class="services-section">
        <h2 class="section-title">Our Features</h2>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="service-title">Secure Voting</h3>
                <p class="service-description">
                    Military-grade encryption ensures your vote is safe and tamper-proof.
                </p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="service-title">Accessible Anywhere</h3>
                <p class="service-description">
                    Vote from any device with internet access during the voting period.
                </p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3 class="service-title">Real-time Results</h3>
                <p class="service-description">
                    View election results in real-time as soon as voting concludes.
                </p>
            </div>
        </div>
    </section>

    <section class="login-section" id="login">
        <h2 class="section-title">Choose Your Login</h2>
        <div class="login-options">
            <div class="login-card">
                <div class="login-icon voter-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h3>Voter Login</h3>
                <p>Access your voting ballot to participate in ongoing elections.</p>
                <a href="voter/voterlogin.php" class="login-btn voter-btn">Voter Login</a>
            </div>

            <div class="login-card">
                <div class="login-icon admin-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3>Admin Login</h3>
                <p>Manage elections, candidates, and voting results.</p>
                <a href="admin/adminlogin.php" class="login-btn admin-btn">Admin Login</a>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-links">
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="privacy.php">Privacy</a>
            <a href="terms.php">Terms</a>
        </div>

        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-github"></i></a>
        </div>

        <p class="copyright">
            &copy; <?php echo date('Y'); ?> VoteXpress. All rights reserved.
        </p>
    </footer>
</body>

</html>