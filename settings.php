<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['employee_id'])) {
    header("Location: login"); // Redirect to login page if not logged in
    exit();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks - Analytics Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            background-color: black;
        }
        .sidebar {
            width: 20vw;
            background-color: black;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }
        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .main {
            flex: 1;
            padding: 20px;
            background: radial-gradient(circle, white, skyblue, lightgreen);
            border-radius: 15px;
            margin: 20px;
            display: flex;
            flex-direction: column;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .header-icons {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .header-icons .icon {
            background: white;
            border-radius: 50%;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <nav class="sidebar">
    <?php 
   include 'side_bar.php';
    ?>
    </nav>

    <!-- Main Section -->
    <main class="main">
        <div class="header">
            <h2>Tasks</h2>
            <div class="header-icons">
                <div class="icon"><i class="bi bi-bell"></i></div>
                <div class="icon"><i class="bi bi-envelope"></i></div>
                <div class="icon"><i class="bi bi-gear"></i></div>
            </div>
        </div>
        <!-- Empty main section for now -->
    </main>
</body>
</html>
