<?php
    // Local XAMPP settings
    $host = 'localhost';
    $username = 'root';
    $password = '';  // XAMPP default has no password
    $database = 'if0_39681332_votesystem';  // Use same database name locally


$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>