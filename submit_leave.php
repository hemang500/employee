<?php
session_start();
require 'backend/db.php';

header('Content-Type: application/json');

// Debugging: Log received data
file_put_contents("debug_log.txt", "Received POST data:\n" . print_r($_POST, true) . "\n", FILE_APPEND);


if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

// Get form values safely
$employeeId = $_POST['employeeId'] ?? null;
$leaveType = $_POST['leaveType'] ?? null;
$startDate = $_POST['startDate'] ?? null;
$endDate = $_POST['endDate'] ?? null;
$reason = $_POST['reason'] ?? null;

if (!$employeeId || !$leaveType || !$startDate || !$endDate || !$reason) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

// Debugging: Log received values
file_put_contents("debug_log.txt", "Form Values:\nEmployee ID: $employeeId\nLeave Type: $leaveType\nStart: $startDate\nEnd: $endDate\nReason: $reason\n", FILE_APPEND);

// Handle file upload
$documentPath = null;
if (isset($_FILES['documents']) && $_FILES['documents']['error'] == 0) {
    $uploadDir = "uploads/leave_docs";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES['documents']['name']);
    $targetFilePath = $uploadDir . $fileName;

    $allowedTypes = ["pdf", "doc", "docx", "jpg", "png"];
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    if (in_array($fileType, $allowedTypes) && move_uploaded_file($_FILES["documents"]["tmp_name"], $targetFilePath)) {
        $documentPath = $targetFilePath;
    }
}

// Debugging: Log file path
file_put_contents("debug_log.txt", "File Upload Path: " . ($documentPath ?? "No file uploaded") . "\n", FILE_APPEND);

// Insert into database using Prepared Statements
$stmt = $conn->prepare("INSERT INTO leave_applications (employee_id, leave_type, start_date, end_date, reason) VALUES (?, ?, ?, ?, ?)");

if (!$stmt) {
    file_put_contents("debug_log.txt", "SQL Preparation Error: " . $conn->error . "\n", FILE_APPEND);
    echo json_encode(["status" => "error", "message" => "SQL preparation failed"]);
    exit;
}

$stmt->bind_param("sssss", $employeeId, $leaveType, $startDate, $endDate, $reason);

if ($stmt->execute()) {
    file_put_contents("debug_log.txt", "SQL Insert Success\n", FILE_APPEND);
    echo json_encode(["status" => "success", "message" => "Leave application submitted successfully"]);
} else {
    file_put_contents("debug_log.txt", "SQL Execution Error: " . $stmt->error . "\n", FILE_APPEND);
    echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
