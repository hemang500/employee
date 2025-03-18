<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['employee_id'])) {
    header("Location: login"); // Redirect to login page if not logged in
    exit();
} ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

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

/* Centered Signup Card */
.signup-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 90vh;
   
}

.signup-card {
    background: rgba(255, 255, 255, 0.1);
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

/* Signup Button */
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

/* Login Link */
p {
    margin-top: 15px;
    color: white;
}

p a {
    color: #00bfff;
    text-decoration: none;
    font-weight: bold;
}

p a:hover {
    text-decoration: underline;
}

        </style>
    <!-- Header Section -->
    <header class="header">
        <img src="https://minitzgo.com//assets/minitgo-DvgwwLax.png" alt="Logo" class="logo">
        
    </header>

    <!-- Signup Card -->
    <div class="signup-container">
        <div class="signup-card">
            <h2>welcome to minitzgo</h2>
            <p>Please fill out the onboarding form.</p>
            <form class="responsive-form">
                <div class="form-row">
                    <div class="input-group">
                        <i class="bi bi-person"></i>
                        <input type="text" placeholder="Full Name" required>
                    </div>
                    <div class="input-group">
                        <i class="bi bi-envelope"></i>
                        <input type="email" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <i class="bi bi-lock"></i>
                        <input type="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-group">
                        <i class="bi bi-phone"></i>
                        <input type="number" placeholder="Contact Number" required>
                    </div>
                    
                </div>
               
                
                <div class="input-group">
                    <i class="bi bi-people"></i>
                    <input type="text" placeholder="Role" >
                </div>
                
               
                
                <button type="submit">Submit Details</button>
                <p>Already registered? <a href="index.html">Login here</a></p>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

$(document).ready(function () {
        $(".responsive-form").on("submit", function (e) {
            e.preventDefault(); // Prevent default form submission

            var formData = {
                full_name: $("input[placeholder='Full Name']").val(),
                email: $("input[placeholder='Email']").val(),
                password: $("input[placeholder='Password']").val(),
                phone: $("input[placeholder='Contact Number']").val(),
                role: $("input[placeholder='Role']").val()
            };

            $.ajax({
                url: "signup_ftch.php",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    alert(response.message);
                    if (response.status === "success") {
                        window.location.href = "login.php"; // Redirect to login page
                    }
                },
                error: function () {
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });

    </script>

</body>
</html>
