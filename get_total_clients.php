<?php
$conn = new mysqli("localhost", "root", "", "edashboard");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS total_clients FROM clients_follow_up";
$result = $conn->query($sql);

$total_clients = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_clients = $row['total_clients'];
}

echo json_encode(['total_clients' => $total_clients]);

$conn->close();
?>
