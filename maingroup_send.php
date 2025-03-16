<?php
include 'backend/db.php';

// Get the JSON data from the POST request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($data) {
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO messages (sender_name, message, sender_id) VALUES (?, ?, ?)");
    
    // Assuming your messages table has these columns, adjust them according to your table structure
    $stmt->bind_param("ssi", $data['sender_name'], $data['message'], $data['sender_id']);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert data']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
}

$conn->close();
?>