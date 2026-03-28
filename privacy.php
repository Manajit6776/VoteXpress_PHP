<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Protocol - VoteXpress</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .privacy-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 4rem 2rem;
            background: var(--bg-surface);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-lg);
        }
        
        .privacy-content h2 {
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            color: var(--accent-red);
            font-size: 1.5rem;
        }

        .privacy-content p, .privacy-content li {
            color: var(--text-mid);
            margin-bottom: 1.2rem;
            line-height: 1.8;
        }

        .privacy-content ul {
            padding-left: 1.5rem;
            list-style-type: square;
        }
    </style>
</head>

<body>
    <div class="bg-glow glow-top-right"></div>
    <div class="bg-glow glow-bottom-left"></div>

    <?php include 'includes/navbar.php'; ?>

    <main style="padding: 10rem 2rem 6rem;">
        <div class="section-header container" style="display: flex; gap: 70px">
            <h1 class="about-title animate-up">Privacy <span style="color: var(--accent-green);">Protocols</span></h1>
            <p class="about-text animate-up" style="max-width: 650px; margin: 10px 10px 10px 10px;">How we protect your identity and secure your digital ballot through advanced cryptography.</p>
        </div>

        <section class="privacy-content animate-up">
            <p>At VoteXpress, privacy isn't just a policy—it's woven into our binary. Our platform is architected around the principle of Zero-Knowledge Proofs where possible, ensuring that your individual vote can never be traced back to your identity.</p>

            <h2>1. Data Neutralization</h2>
            <p>When you cast a vote, the following happens instantly:</p>
            <ul>
                <li>Your identity is verified against the registry.</li>
                <li>Your ballot is decoupled from your user ID.</li>
                <li>The ballot is encrypted with a multi-layered hash.</li>
                <li>The hash is added to the finalized tally.</li>
            </ul>

            <h2>2. Information Collection</h2>
            <p>We only collect essential metadata required for election integrity:</p>
            <ul>
                <li><strong>Cryptographic Identifiers:</strong> To prevent double-voting.</li>
                <li><strong>Session Metadata:</strong> IP and browser fingerprinting for anti-fraud detection.</li>
                <li><strong>Voter Credentials:</strong> Encrypted hashes of your login data.</li>
            </ul>

            <h2>3. Third-Party Disclosure</h2>
            <p>VoteXpress does not sell, trade, or otherwise transfer your personally identifiable information to outside parties. Your data exists solely for the duration of the election lifecycle and is handled with military-grade discretion.</p>

            <h2>4. Secure Storage</h2>
            <p>All data is maintained behind secured networks and is only accessible by a limited number of persons who have special access rights to such systems, and are required to keep the information confidential.</p>
        </section>
    </main>

    <?php include 'includes/site_footer.php'; ?>
</body>

</html>