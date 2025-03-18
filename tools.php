
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
    <title>Tools Page</title>
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
    background: radial-gradient(circle, rgba(135, 206, 235, 0.7), rgba(144, 238, 144, 0.7));
    font-family: Arial, sans-serif;
    display: flex;
}

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
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar a.logout {
            color: red;
            margin-top: auto;
        }
 
 
 
.active {
    background-color: rgba(255, 255, 255, 0.1);
}
.sidebar a.logout {
            color: red;
            margin-top: auto;
        }
/* Main Content */
.main-content {
    flex: 1;
    padding: 20px;
}

/* Header */
.header {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.1);
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.logo {
    width: 80px;
    margin-right: 15px;
}

h2 {
    color: white;
}

/* Tools Grid */
.tools-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 20px;
    width: 80%;
    max-width: 900px;
    margin: 0 auto 30px;
}

/* Tool Card */
.tool-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
    color: white;
    text-decoration: none;
}

.tool-card i {
    font-size: 30px;
    margin-bottom: 10px;
    display: block;
}

.tool-card h3 {
    font-size: 16px;
}

.tool-card:hover {
    transform: scale(1.05);
}

/* Software Request Form */
/* Request Form - Initially Small & Hidden */
.request-form {
    width: 200px;
    height: 50px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    text-align: center;
    color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: all 0.4s ease-in-out;
    overflow: hidden;
    position: fixed;
    bottom: 20px;
    right: 20px;
    cursor: pointer;
}

/* Hover Effect - Expands Form */
.request-form:hover {
    width: 300px;
    height: auto;
    padding: 20px;
}

/* Hide Form Fields Initially */
.request-form form {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, visibility 0.3s;
}

/* Show Fields on Hover */
.request-form:hover form {
    opacity: 1;
    visibility: visible;
}

/* Input Fields */
.request-form input, 
.request-form textarea, 
.request-form button {
    width: 100%;
    margin-bottom: 10px;
    padding: 10px;
    border: none;
    border-radius: 5px;
}

.request-form input, .request-form textarea {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.request-form button {
    background: skyblue;
    cursor: pointer;
}

.request-form button:hover {
    background: lightgreen;
}


.request-form h3 {
    margin-bottom: 15px;
}

.request-form input, 
.request-form textarea, 
.request-form button {
    width: 100%;
    margin-bottom: 10px;
    padding: 10px;
    border: none;
    border-radius: 5px;
}

.request-form input, .request-form textarea {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.request-form button {
    background: skyblue;
    cursor: pointer;
}

.request-form button:hover {
    background: lightgreen;
}

        </style>
    <!-- Sidebar -->
    <nav class="sidebar">
        <ul>
        <?php 
   include 'side_bar.php';
    ?>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
       
        <!-- Header -->
        <header class="header">
            <img src="https://minitzgo.com//assets/minitgo-DvgwwLax.png" alt="Logo" class="logo">
            <h2>Tools</h2>
        </header>

        <!-- Tools Grid -->
        <div class="tools-container">
            <a href="photoshop://open" class="tool-card">
                <i class="bi bi-brush"></i>
                <h3>Photoshop</h3>
            </a>
            <a href="illustrator://open" class="tool-card">
                <i class="bi bi-palette"></i>
                <h3>Illustrator</h3>
            </a>
            <a href="blender://open" class="tool-card">
                <i class="bi bi-box"></i>
                <h3>Blender 3D</h3>
            </a>
            <a href="vscode://open" class="tool-card">
                <i class="bi bi-code-slash"></i>
                <h3>VS Code</h3>
            </a>
            <a href="autocad://open" class="tool-card">
                <i class="bi bi-rulers"></i>
                <h3>AutoCAD</h3>
            </a>
            <a href="https://canva.com" target="_blank" class="tool-card">
                <i class="bi bi-card-image"></i>
                <h3>Canva</h3>
            </a>
            <a href="https://github.com" target="_blank" class="tool-card">
                <i class="bi bi-github"></i>
                <h3>GitHub</h3>
            </a>
            <a href="https://clickup.com" target="_blank" class="tool-card">
                <i class="bi bi-list-check"></i>
                <h3>ClickUp</h3>
            </a>
            <a href="https://jira.com" target="_blank" class="tool-card">
                <i class="bi bi-kanban"></i>
                <h3>Jira</h3>
            </a>
            <a href="https://eraser.io" target="_blank" class="tool-card">
                <i class="bi bi-diagram-3"></i>
                <h3>Eraser.io</h3>
            </a>
            <a href="https://www.usegalileo.ai/signup" target="_blank" class="tool-card">
                <i class="bi bi-robot"></i>
                <h3>usegalileo.ai</h3>
            </a>
            <a href="https://www.figma.com" target="_blank" class="tool-card">
                <i class="bi bi-vector-pen"></i>
                <h3>Figma</h3>
            </a>
            <a href="https://www.chatgpt.com" target="_blank" class="tool-card">
                <img src="https://www.edigitalagency.com.au/wp-content/uploads/ChatGPT-logo-PNG-large-size-white-green-background.png" style="width: 30px; height: 30px;">
                <h3>Chat GPT</h3>
            </a>
        </div>

        <!-- Software Request Form -->
     <!-- Software Request Form -->
<div class="request-form">
    <h3>Request Software</h3>
    <form>
        <input type="text" placeholder="Your Name" required>
        <input type="email" placeholder="Your Email" required>
        <input type="text" placeholder="Software Name" required>
        <textarea placeholder="Reason for Request" required></textarea>
        <button type="submit">Submit</button>
    </form>
</div>


    </div>

</body>
</html>
