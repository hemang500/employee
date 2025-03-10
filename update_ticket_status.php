<?php
$conn = new mysqli("localhost", "root", "", "edashboard");

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed"]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ticket_id = $_POST["ticket_id"] ?? null;
    $status = $_POST["status"] ?? null;

    if ($ticket_id && $status) {
        $query = "UPDATE tickets SET status = ? WHERE ticket_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $ticket_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update ticket"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid input"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
