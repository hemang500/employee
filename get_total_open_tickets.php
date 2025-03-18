<?php
include 'backend/db.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS total_tickets FROM tickets WHERE status = 'open'";
$result = $conn->query($sql);

$total_clients = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_clients = $row['total_tickets'];
}

echo json_encode(['total_tickets' => $total_clients]);

$conn->close();
?>
