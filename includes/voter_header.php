<?php
// Start a session if one is not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../db_connect.php';

// Fetch election title from the database
$election_title_query = $conn->query("SELECT title FROM election_title WHERE id = 1");
$election_title = $election_title_query->fetch_assoc()['title'] ?? 'Online Voting System';

// Initialize voter information variables
$voter_name = "Guest";
$voter_photo = "default.jpg";

// Fetch voter information if a voter session exists
if (isset($_SESSION['voter'])) {
    $voter_id = $_SESSION['voter'];
    $voter_info_query = $conn->query("SELECT firstname, lastname, photo FROM voters WHERE voters_id = '$voter_id'");
    if ($voter_info_query && $voter_info_query->num_rows > 0) {
        $voter_info = $voter_info_query->fetch_assoc();
        $voter_name = htmlspecialchars($voter_info['firstname'] . ' ' . $voter_info['lastname']);
        $voter_photo = htmlspecialchars($voter_info['photo']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Voter Dashboard | VoteXpress</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="main-wrapper">
        <div class="voter-header">
            <div class="header-left">
                <img src="../assets/images/<?php echo $voter_photo; ?>" alt="<?php echo $voter_name; ?>" class="voter-photo">
                <span class="voter-name"><?php echo $voter_name; ?></span>
            </div>
            <div class="header-center">
                <h1 class="election-title"><?php echo $election_title; ?></h1>
            </div>
            <div class="header-right">
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
        <div class="voter-content">