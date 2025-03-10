<?php
session_start();
error_reporting(0);
// Database connection parameters
include 'db.php';

 
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get JSON data from POST request
        $json = file_get_contents('php://input');
        
        // Check if JSON input is empty
        if (empty($json)) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Empty request body']);
            exit;
        }
    
        $data = json_decode($json, true);
        $jsonError = json_last_error();
        
        if ($jsonError !== JSON_ERROR_NONE) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Invalid JSON: ' . json_last_error_msg()]);
            exit;
        }

    // Check for valid JSON
    if ($data === null) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
        exit;
    }

    // Get form data
    $title = $data['title'] ?? '';
    $description = $data['description'] ?? '';
    $raised_by = $_SESSION['user_id'] ?? 0; // Assuming you have user session
    $assigned_by = $data['assignee'] ?? '';
    $priority = $data['priority'] ?? '';

    // Prepare SQL statement to prevent SQL injection
    $sql = $conn->prepare("INSERT INTO tickets (title, description, raised_by, assigned_by, priority) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("ssiis", $title, $description, $raised_by, $assigned_by, $priority);

    // Execute query and check if successful
    header('Content-Type: application/json');
    if ($sql->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Ticket created successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $sql->error]);
    }

    // Close statement
    $sql->close();
}

// Close connection
$conn->close();
?>