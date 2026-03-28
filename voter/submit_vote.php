<?php
session_start();
include '../db_connect.php';

if (isset($_POST['submit_vote']) && isset($_SESSION['voter'])) {
    $voter_id = $_SESSION['voter'];

    $check_sql = "SELECT * FROM votes WHERE voters_id = '$voter_id'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        $_SESSION['error'] = 'Access Denied: Ballot already processed for this ID.';
        header('location: view_ballot.php');
        exit();
    }

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'candidate_') === 0 && !empty($value)) {
            $position_id = str_replace('candidate_', '', $key);
            $candidate_id = intval($value);

            $insert_sql = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('$voter_id', '$candidate_id', '$position_id')";
            $conn->query($insert_sql);
        }
    }

    $_SESSION['success'] = 'Ballot Successfully Encrypted and Processed.';
    header('location: view_ballot.php');
    exit();
}
