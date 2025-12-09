<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['admin'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['order'])) {
    $order = $data['order'];
    $conn->begin_transaction();
    $success = true;

    foreach ($order as $index => $id) {
        $id = intval($id);
        $priority = $index + 1;
        $sql = "UPDATE positions SET priority = $priority WHERE id = $id";
        if (!$conn->query($sql)) {
            $success = false;
            break;
        }
    }

    if ($success) {
        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => 'Order updated successfully.']);
    } else {
        $conn->rollback();
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid data received.']);
}

$conn->close();
