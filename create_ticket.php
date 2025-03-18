<?php
session_start();
 
// Database connection parameters
include 'backend/db.php';

$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$status = 'Open'; // Default status for new tickets
$created_by = $_SESSION['full_name'];
$assigned_to = $_POST['assignee'];

$sql = "INSERT INTO tickets (title, description, priority, status, raised_by, assigned_to) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $title, $description, $priority, $status, $created_by, $assigned_to);

if ($stmt->execute()) {
    header("Location: tickets");
    exit();
} else {
    // Optional: Handle error case
    echo "Error creating ticket: " . $conn->error;
}
?>