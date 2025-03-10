<?php
// Database Connection
include 'backend/db.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Data
$sql = "SELECT id, client_name, email, phone, follow_up_date, follow_up_time, status, notes FROM clients_follow_up ORDER BY follow_up_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table table-striped table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Follow-up Date</th>
                    <th>Follow-up Time</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>';
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['client_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['follow_up_date']}</td>
                <td>{$row['follow_up_time']}</td>
                <td><span class='badge bg-".getStatusClass($row['status'])."'>{$row['status']}</span></td>
                <td>{$row['notes']}</td>
              </tr>";
    }
    echo '</tbody></table>';
} else {
    echo "<p class='text-center text-danger'>No follow-ups found!</p>";
}

$conn->close();

// Function to Assign Status Color
function getStatusClass($status) {
    switch ($status) {
        case "Pending": return "warning";
        case "Completed": return "success";
        case "Cancelled": return "danger";
        default: return "secondary";
    }
}
?>
