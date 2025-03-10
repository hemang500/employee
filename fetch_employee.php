<?php
session_start();
include 'backend/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['employee_id'])) {
    echo json_encode(["status" => "error", "message" => "Session expired"]);
    exit;
}

$employee_id = $_SESSION['employee_id'];

$query = "SELECT id, name, email, phone, role, department, joining_date, profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {
    echo json_encode(["status" => "success"] + $data);
} else {
    echo json_encode(["status" => "error", "message" => "Employee not found"]);
}

$stmt->close();
$conn->close();
?>
