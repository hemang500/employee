<!DOCTYPE html>
<html lang="en">

<?php 
session_start();
$_SESSION['employee_id'];

?>


 

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile - Analytics Dashboard</title>
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
            align-items: center;
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
            width: 100%;
        }
        .profile-card {
            border-radius: 15px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 400px;
            text-align: center;
        }
        .profile-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .profile-card h3 {
            margin-bottom: 5px;
        }
        .profile-card p {
            margin: 5px 0;
            color: #555;
        }
        .info-section {
            margin-top: 15px;
            text-align: left;
        }
        .info-section strong {
            display: block;
            margin-top: 5px;
        }
        .leave-calendar {
            
           border-radius: 10px;
            padding: 20px;
            width: 50%;
            max-width: 600px;
            margin-top: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2); b
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
    <nav class="sidebar">
        <a href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="#"><i class="bi bi-people"></i> Users</a>
        <a href="#" class="active"><i class="bi bi-person"></i> Profile</a>
        <a href="#"><i class="bi bi-ticket-detailed"></i> Tickets</a>
        <a href="#"><i class="bi bi-bar-chart-line"></i> Reports</a>
        <a href="#"><i class="bi bi-gear"></i> Settings</a>
        <a href="#" class="logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </nav>

    <main class="main">
        <div class="header">
            <h2>Employee Profile</h2>
            <div class="header-icons">
                <div class="icon"><i class="bi bi-bell"></i></div>
                <div class="icon"><i class="bi bi-envelope"></i></div>
                <div class="icon"><i class="bi bi-gear"></i></div>
            </div>
        </div>

        <div class="profile-card" id="profileCard">
            <img id="profilePic" src="default.jpg" alt="Employee Picture">
            <h3 id="employeeName"></h3>
            <p>ID: <span id="employeeID"></span></p>
            <p>Role: <span id="employeeRole"></span></p>
            
            <div class="info-section">
                <strong>Email:</strong> <span id="employeeEmail"></span>
                <strong>Phone:</strong> <span id="employeePhone"></span>
                <strong>Department:</strong> <span id="employeeDepartment"></span>
                <strong>Joining Date:</strong> <span id="employeeJoiningDate"></span>
            </div>
        </div>
        
        <div class="leave-calendar">
            <h4>Leave Application</h4>
            <form>
                <div class="mb-3">
                    <label for="leave_start" class="form-label">Start Date:</label>
                    <input type="date" id="leave_start" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="leave_end" class="form-label">End Date:</label>
                    <input type="date" id="leave_end" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="leave_reason" class="form-label">Reason:</label>
                    <textarea id="leave_reason" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Apply for Leave</button>
            </form>
        </div>
    </main>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let employeeId = '<?php echo $employee_id; ?>'; // Get employee ID from PHP session
        if (!employeeId) {
            alert("Employee ID not found in session.");
            return;
        }
        fetchEmployeeData(employeeId);
    });
    
    function fetchEmployeeData(employeeId) {
        $.ajax({
            url: 'fetch_employee.php',
            type: 'POST',
            data: { employee_id: employeeId },
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    $('#profilePic').attr('src', data.profile_pic || 'default.jpg');
                    $('#employeeName').text(data.name);
                    $('#employeeID').text(data.id);
                    $('#employeeRole').text(data.role);
                    $('#employeeEmail').text(data.email);
                    $('#employeePhone').text(data.phone);
                    $('#employeeDepartment').text(data.department);
                    $('#employeeJoiningDate').text(data.joining_date);
                } else {
                    alert('Failed to fetch employee data');
                }
            },
            error: function () {
                alert('Error fetching employee data');
            }
        });
    }
</script>

</body>

</html>