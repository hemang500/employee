<?php
session_start();
include 'backend/db.php';

if (!isset($_SESSION['employee_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$eid = (int)$_SESSION['employee_id'];

// Get messages and count
$sql = "SELECT m.sender_name, m.message, m.created_at 
    FROM messages m 
    WHERE m.sender_id != $eid 
    ORDER BY m.created_at DESC";

$result = $conn->query($sql);

$notifications = 0;
$messages = [];

if ($result->num_rows > 0) {
    $notifications = $result->num_rows;
    while ($row = $result->fetch_assoc()) {
        $messages[] = [
             
            'message' => $row['message'],
            'sender_name' => $row['sender_name'],
            'created_at' => $row['created_at']
        ];
    }
}

echo json_encode([
    'notifications' => $notifications,
    'message' => $messages
]);

$conn->close();
?>
