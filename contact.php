<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact VoteXpress</title>
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

        /* Main content styling */
        .content-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        .content-container h1,
        .content-container h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .content-container p,
        .content-container ul {
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .content-container ul {
            padding-left: 20px;
        }

        .content-container li {
            margin-bottom: 0.5rem;
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
                    <a href="index.php#login" class="btn btn-primary">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="content-container">
        <h1>Contact VoteXpress</h1>
        <p>We're here to help! Whether you have a question about our platform, need technical support, or want to discuss a partnership, please don't hesitate to reach out.</p>

        <h2>Get in Touch</h2>
        <ul>
            <li><strong>General Inquiries:</strong> For general questions or feedback, please email us at <a href="mailto:info@voterxpress.com">info@voterxpress.com</a>.</li>
            <li><strong>Technical Support:</strong> If you're experiencing an issue with the platform, contact our support team at <a href="mailto:support@voterxpress.com">support@voterxpress.com</a>.</li>
            <li><strong>Press & Media:</strong> For all media-related inquiries, please reach out to <a href="mailto:media@voterxpress.com">media@voterxpress.com</a>.</li>
        </ul>

        <h2>Our Office</h2>
        <address>
            VoteXpress Headquarters<br>
            123 Election Street<br>
            Democracy City, State 12345<br>
            Country
        </address>
        <p>Thank you for your interest in VoteXpress. We look forward to hearing from you!</p>
    </main>

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