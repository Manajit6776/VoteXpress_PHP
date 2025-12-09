<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoteXpress Privacy Policy</title>
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
        <h1>VoteXpress Privacy Policy</h1>
        <p>Your privacy is a top priority for us. This policy outlines how we collect, use, and protect your information when you use the VoteXpress platform.</p>

        <h2>1. Information We Collect</h2>
        <p>To ensure the security and integrity of the voting process, we collect the following information:</p>
        <ul>
            <li><strong>User Information:</strong> Name, email address, and unique identifier (e.g., a voter ID) for authentication and verification purposes.</li>
            <li><strong>Vote Data:</strong> Your submitted ballot, which is anonymized and encrypted to ensure your vote remains private. We never link your identity to your vote.</li>
            <li><strong>Technical Data:</strong> IP address, browser type, and device information to monitor for security threats and ensure a smooth user experience.</li>
        </ul>

        <h2>2. How We Use Your Information</h2>
        <p>We use the information we collect for the following purposes:</p>
        <ul>
            <li><strong>Authentication:</strong> To verify your identity and ensure you are an eligible voter.</li>
            <li><strong>Security:</strong> To protect our platform from fraud, unauthorized access, and other security breaches.</li>
            <li><strong>Functionality:</strong> To provide access to the voting platform and its features.</li>
            <li><strong>Communication:</strong> To send you essential updates and notifications about elections you are participating in.</li>
        </ul>

        <h2>3. Data Security</h2>
        <p>We take the security of your data seriously. We use advanced encryption protocols and secure infrastructure to protect your personal information and voting data. All ballots are stored in an encrypted and anonymized state, making it impossible to connect a vote back to an individual.</p>

        <h2>4. Your Rights</h2>
        <p>You have the right to access, correct, or request the deletion of your personal information, subject to legal and security obligations. For any requests regarding your data, please contact us at <a href="mailto:privacy@voterxpress.com">privacy@voterxpress.com</a>.</p>
        <p><em>Please note: This is a simplified privacy policy for demonstration. For a real-world application, a full legal review would be necessary.</em></p>
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