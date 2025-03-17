<?php
session_start(); // Start the session
session_destroy(); // Destroy all session data
header("Location: login"); // Redirect to login.php
exit(); // Stop script execution
?>