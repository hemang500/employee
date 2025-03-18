<?php
// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Detect environment and set database credentials
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "edashboard";
} else {
    $db_host = "localhost";
    $db_user = "u473959262_dashboard";
    $db_pass = "9fCa4G@o";
    $db_name = "u473959262_edashboard";
}

// Establish database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check for connection error
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

// Optional: Set UTF-8 encoding
$conn->set_charset("utf8");

// Debugging output (remove in production)
// echo json_encode(["status" => "success", "message" => "Database connected."]);
?>
