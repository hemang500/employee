<?php
header('Content-Type: application/json');

include 'backend/db.php';

if ($conn->connect_error) {
    echo json_encode(["error" => "Database conn failed"]);
    exit;
}

$ticketId = $_POST['id'] ?? '';

if (!$ticketId) {
    echo json_encode(["error" => "Ticket ID is required"]);
    exit;
}

$query = "SELECT id, title, description, status FROM tickets WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $ticketId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Ticket not found"]);
}

$stmt->close();
$conn->close();
?>
