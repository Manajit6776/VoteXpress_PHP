<?php
session_start();
include '../db_connect.php';

if (isset($_POST['submit_vote']) && isset($_SESSION['voter'])) {
    $voter_id = $_SESSION['voter'];

    $check_sql = "SELECT * FROM votes WHERE voters_id = '$voter_id'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        $_SESSION['error'] = 'You have already voted.';
        header('location: home.php');
        exit();
    }

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'position_') === 0) {
            $position_id = str_replace('position_', '', $key);
            $candidate_id = $value;

            $insert_sql = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('$voter_id', '$candidate_id', '$position_id')";
            $conn->query($insert_sql);
        }
    }

    $_SESSION['success'] = 'Ballot Submitted';
    header('location: voter_receipt.php');
    exit();
}
