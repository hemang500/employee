<?php
include 'backend/db.php';

$sql = "SELECT * FROM employee_logins WHERE login_time > DATE_SUB(NOW(), INTERVAL 10 HOUR)";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='member'>
                <img src='https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png' alt=''> 
                " . htmlspecialchars($row['employee_name']) . " - " . htmlspecialchars($row['status']) . "
              </div>";
    }
} else {
    echo "<div class='member'>No active employees</div>";
}

$conn->close();
?>
