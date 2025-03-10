<?php
$conn = new mysqli("localhost", "root", "", "edashboard");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $employee_name = $_POST['employee_name'];
    $status = $_POST['status'];
    $break_reason = isset($_POST['break_reason']) ? $_POST['break_reason'] : NULL;
    $break_duration = isset($_POST['break_duration']) ? $_POST['break_duration'] : NULL;

    // Ensure at least 2 employees are online before allowing break
    if ($status == "Break") {
        $result = $conn->query("SELECT COUNT(*) AS online_count FROM employee_logins WHERE status = 'online' OR status = 'other tab'");
        $row = $result->fetch_assoc();
        if ($row['online_count'] < 3) {
            echo "Cannot take a break now. At least 2 employees must be working. pease report to your TL";
            exit;
        }
    }

    if ($status == "Login") {
        $sql = "INSERT INTO employee_logins (employee_id, employee_name, login_time, status) 
                VALUES ('$employee_id', '$employee_name', NOW(), 'online')";
    } elseif ($status == "Logout") {
        $sql = "UPDATE employee_logins 
                SET logout_time = NOW(), status = 'offline' 
                WHERE employee_id = '$employee_id' AND logout_time IS NULL 
                ORDER BY login_time DESC LIMIT 1";
    } elseif ($status == "Break") {
        $sql = "UPDATE employee_logins 
                SET status = 'away', break_reason = '$break_reason', break_duration = '$break_duration' 
                WHERE employee_id = '$employee_id' AND logout_time IS NULL 
                ORDER BY login_time DESC LIMIT 1";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Aux changed successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
