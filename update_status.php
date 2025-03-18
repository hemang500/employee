<?php
include 'backend/db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $status = $_POST['status'];

    $sql = "UPDATE employee_logins 
            SET status = '$status' 
            WHERE employee_id = '$employee_id' AND logout_time IS NULL 
            ORDER BY login_time DESC LIMIT 1";

    if ($conn->query($sql) === TRUE) {
        echo "Status updated to $status";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
