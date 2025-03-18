<?php
session_start();
$error = ''; // Initialize error variable
include 'backend/db.php'; // Ensure this file correctly establishes $conn

//set session timeout when browser is closed
// session_set_cookie_params(0);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $email = trim(strtolower($_POST['username'])); // Convert username/email to lowercase
    $password = $_POST['password'];

    // Fetch user details including full_name, role, and status
    $stmt = $conn->prepare("SELECT id, full_name, email, phone, role, status, password, created_at FROM employees WHERE LOWER(email) = LOWER(?)");
    
    if (!$stmt) {
        die("Error in SQL: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Debugging logs
        error_log("Stored hash: " . $row['password']);
        error_log("Provided password: " . $password);
        error_log("Password verification result: " . (password_verify($password, $row['password']) ? 'true' : 'false'));

        if (strlen($row['password']) < 20) {
            // For non-hashed passwords
            if ($password === $row['password']) {
                // Store user data in session
                $_SESSION['employee_id'] = $row['id'];
                $_SESSION['full_name'] = $row['full_name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['phone'] = $row['phone'];
                $_SESSION['status'] = $row['status'];
                $_SESSION['created_at'] = $row['created_at'];

                header("Location: index");
                exit();
            } else {
                $error = "Wrong password. Please try again.";
                error_log("Login failed: Wrong password for user " . $email);
            }
        } elseif (password_verify($password, $row['password'])) {
            // Store user data in session
            $_SESSION['employee_id'] = $row['id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['status'] = $row['status'];
            $_SESSION['password'] = $row['password']; // Consider removing for security
            $_SESSION['created_at'] = $row['created_at'];

            header("Location: index.html");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Invalid email!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<style>
/* Full-page gradient background */
body {
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: radial-gradient(circle, rgba(135, 206, 235, 0.7), rgba(144, 238, 144, 0.7));
    font-family: Arial, sans-serif;
}
.footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 20px 0;
    text-align: center;
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.1);
}
.footer-content {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
}
.footer-links a {
    color: #333;
    text-decoration: none;
    margin: 0 15px;
    transition: color 0.3s ease;
}
.footer-links a:hover {
    color: #00bfff;
}
.social-icons i {
    font-size: 20px;
    margin: 0 10px;
    color: #333;
    transition: transform 0.3s ease;
}
.social-icons i:hover {
    transform: scale(1.2);
    color: #00bfff;
}
/* Transparent Header */
.header {
    position: absolute;
    top: 10px;
    left: 20px;
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.1);
    padding: 10px 20px;
    border-radius: 10px;
}
.logo {
    width: 120px;
}
/* Centered Login Card */
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100vh;
}
.login-card {
    background: rgba(41, 1, 1, 0.1);
    backdrop-filter: blur(15px);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
    width: 350px;
}
h2 {
    color: white;
    margin-bottom: 20px;
}
/* Input Fields */
.input-group {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.2);
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 15px;
}
.input-group i {
    margin-right: 10px;
    color: white;
}
.input-group input {
    border: none;
    background: transparent;
    outline: none;
    color: white;
    width: 100%;
}
::placeholder {
    color: rgba(255, 255, 255, 0.7);
}
/* Login Button */
button {
    background: #00bfff;
    border: none;
    padding: 10px 20px;
    color: white;
    font-size: 16px;
    border-radius: 10px;
    cursor: pointer;
    width: 100%;
}
button:hover {
    background: #008cba;
}
</style>

<!-- Header Section -->
<header class="header">
    <img src="https://minitzgo.com//assets/minitgo-DvgwwLax.png" alt="Logo" class="logo">
    <span style="font-family: 'Segoe UI', Arial, sans-serif; 
                 color: rgb(29, 6, 6); 
                 font-size: 14px; 
                 font-weight: 100;
                 margin-left: 15px; 
                 letter-spacing: 1px;">Employee Dashboard</span>
</header>

<!-- Login Card -->
<div class="login-container">
    <div class="login-card">
        <h2>Login</h2>
        <?php if ($error): ?>
            <p style="color:rgb(71, 68, 68); 
                  background-color: rgba(255, 107, 107, 0.1); 
                  padding: 10px; 
                  border-radius: 5px; 
                  margin: 10px 0; 
                  display: flex; 
                  align-items: center; 
                  font-family: 'Segoe UI', Arial, sans-serif;
                  font-size: 14px;">
            <i class="bi bi-exclamation-triangle-fill" style="margin-right: 15px; color: #ff6b6b;"></i>
            <?php echo $error; ?>
            </p>
        <?php endif; ?>
        <form method="POST">
            <div class="input-group">
                <i class="bi bi-person"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="bi bi-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</div>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-links">
            <a href="#">About</a>
            <a href="#">Contact</a>
            <a href="#">Help</a>
        </div>
        <div class="social-icons">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
        </div>
        <div>
            <p>&copy; 2025 minitzgo Employee Dashboard</p>
        </div>
    </div>
</footer>
 
</body>
