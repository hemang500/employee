<?php
$conn = new mysqli("localhost", "root", "", "edashboard");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
