<?php
include 'backend/db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$client_name = $_POST['client_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$follow_up_date = $_POST['follow_up_date'];
$follow_up_time = $_POST['follow_up_time'];

$sql = "INSERT INTO clients (client_name, email, phone, follow_up_date, follow_up_time) 
        VALUES ('$client_name', '$email', '$phone', '$follow_up_date', '$follow_up_time')";

if ($conn->query($sql) === TRUE) {
    echo "Client added successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
