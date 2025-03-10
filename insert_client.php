<?php
include 'backend/db.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // Ensure JSON response format

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die(json_encode(["status" => "error", "message" => "Invalid request method"]));
}

// Retrieve and sanitize inputs
$client_name = isset($_POST['client_name']) ? trim($_POST['client_name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';
$follow_up_date = isset($_POST['follow_up_date']) ? trim($_POST['follow_up_date']) : '';
$follow_up_time = isset($_POST['follow_up_time']) ? trim($_POST['follow_up_time']) : '';

// Validate required fields
if (empty($client_name) || empty($email) || empty($phone) || empty($follow_up_date) || empty($follow_up_time) || empty($notes) || empty($status)) {
    die(json_encode(["status" => "error", "message" => "All fields are required."]));
}

// Prepare SQL statement to insert data
$stmt = $conn->prepare("INSERT INTO clients_follow_up (client_name, email, phone, status, notes, follow_up_date, follow_up_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die(json_encode(["status" => "error", "message" => "Prepare statement failed: " . $conn->error]));
}

// Bind parameters
$stmt->bind_param("sssssss", $client_name, $email, $phone, $status, $notes, $follow_up_date, $follow_up_time);

// Execute query
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Client added successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
