<?php
// Correct path to the database connection file
include_once '../db_connect.php';

$election_title_query = $conn->query("SELECT title FROM election_title WHERE id = 1");
$election_title = $election_title_query->fetch_assoc()['title'] ?? 'Online Voting System';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../assets/images/logo.png" alt="Admin Logo" class="admin-logo">
                <h3 class="admin-title">VoteXpress</h3>
                <span class="admin-status"><i class="fa-solid fa-circle"></i> Online</span>
            </div>
            <ul class="sidebar-menu">
                <p class="menu-heading">REPORTS</p>
                <li><a href="dashboard.php" class="sidebar-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="votes.php" class="sidebar-link"><i class="fas fa-vote-yea"></i> Votes</a></li>
                <p class="menu-heading">MANAGE</p>
                <li><a href="voters.php" class="sidebar-link"><i class="fas fa-users"></i> Voters</a></li>
                <li><a href="positions.php" class="sidebar-link"><i class="fas fa-list-alt"></i> Positions</a></li>
                <li><a href="candidates.php" class="sidebar-link"><i class="fas fa-user-tie"></i> Candidates</a></li>
                <p class="menu-heading">SETTINGS</p>
                <li><a href="ballot_position.php" class="sidebar-link"><i class="fas fa-sort"></i> Ballot Position</a></li>
                <li><a href="election_title.php" class="sidebar-link"><i class="fas fa-cogs"></i> Election Title</a></li>
            </ul>
        </aside>
        <div class="main-content">
            <nav class="top-nav">
                <div class="nav-right">
                    <a href="dashboard.php" class="nav-link">Home</a>
                    <span class="nav-separator">/</span>
                    <a href="dashboard.php" class="nav-link">Dashboard</a>
                    <a href="logout.php" class="nav-link logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </nav>
            <div class="content-area">