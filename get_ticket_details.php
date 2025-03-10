<?php
header('Content-Type: application/json');

$connection = new mysqli("localhost", "root", "", "your_database");

if ($connection->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$ticketId = $_POST['id'] ?? '';

if (!$ticketId) {
    echo json_encode(["error" => "Ticket ID is required"]);
    exit;
}

$query = "SELECT id, title, description, status FROM tickets WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $ticketId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Ticket not found"]);
}

$stmt->close();
$connection->close();
?>
