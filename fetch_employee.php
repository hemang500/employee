<?php
session_start();
require_once 'backend/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['employee_id'])) {
    echo json_encode(["status" => "error", "message" => "Session expired. Please log in again."]);
    exit;
}

$employee_id = intval($_SESSION['employee_id']);

$query = "SELECT id, full_name AS name, email, phone, role, status, created_at AS joining_date FROM employees WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Database query preparation failed."]);
    exit;
}

$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {
    echo json_encode(["status" => "success", "data" => $data], JSON_PRETTY_PRINT);
} else {
    echo json_encode(["status" => "error", "message" => "Employee not found"]);
}

// Close database connections
$stmt->close();
$conn->close();
?>