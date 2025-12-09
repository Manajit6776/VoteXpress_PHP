<?php
$conn = new mysqli(
    'sql108.infinityfree.com',
    'if0_39681332',
    'XqnuBJnUdAO',
    'if0_39681332_votesystem'
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>