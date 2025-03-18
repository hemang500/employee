<?php
header('Content-Type: application/json');

include 'backend/db.php';

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$ticketId = $_POST['id'] ?? '';
$assignTo = $_POST['assignTo'] ?? '';

if (!$ticketId || !$assignTo) {
    echo json_encode(["error" => "Missing parameters"]);
    exit;
}

$query = "UPDATE tickets SET assigned_to = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $assignTo, $ticketId);
$success = $stmt->execute();

if ($success) {
    echo json_encode(["message" => "Ticket assigned successfully"]);
} else {
    echo json_encode(["error" => "Failed to assign ticket"]);
}

$stmt->close();
$conn->close();
?>
