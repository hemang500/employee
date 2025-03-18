<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require 'backend/db.php'; // Ensure this file is in the correct location

$response = ["status" => "error", "message" => "Something went wrong!"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $phone = trim($_POST["phone"]);
    $role = trim($_POST["role"]);

    // ✅ Fixed: Variable mismatch (changed "contact" to "phone")
    if (empty($full_name) || empty($email) || empty($password) || empty($phone)) { 
        $response["message"] = "All fields are required!";
        echo json_encode($response);
        exit;
    }

    // ✅ Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["message"] = "Invalid email format!";
        echo json_encode($response);
        exit;
    }

    // ✅ Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM employees WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $response["message"] = "Email already exists!";
        echo json_encode($response);
        exit;
    }
    $stmt->close();

    // ✅ Securely hash the password
    $hashed_password = $password; // Replace this with password_hash($password, PASSWORD_DEFAULT);

    // ✅ Insert into database
    $stmt = $conn->prepare("INSERT INTO employees (full_name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $email, $hashed_password, $phone, $role);

    if ($stmt->execute()) {
        $response = ["status" => "success", "message" => "Registration successful!"];
    } else {
        $response["message"] = "Database error: " . $stmt->error; // ✅ Debugging database error
    }
    $stmt->close();
}

echo json_encode($response);
?>