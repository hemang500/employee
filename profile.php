<?php 
session_start();

require_once 'backend/db.php';

// Redirect if no employee session exists
if (!isset($_SESSION['employee_id'])) {
header("Location: login");
exit;
}


$employee_id = $_SESSION['employee_id'];
?>

<!DOCTYPE html>
<html lang="en">
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
        border-radius: 10%;
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
    .sidebar a.logout {
            color: red;
            margin-top: auto;
        }
</style>
</head>
<body>
<nav class="sidebar">
<?php 
   include 'side_bar.php';
    ?>
</nav>

<main class="main" style="overflow-y: auto; max-height: calc(100vh - 40px); padding: 20px;">
    <div class="header">
        <h2>Employee Profile</h2>
        <div class="header-icons">
            <div class="icon"><i class="bi bi-bell"></i></div>
            <div class="icon"><i class="bi bi-envelope"></i></div>
            <div class="icon"><i class="bi bi-gear"></i></div>
        </div>
    </div>

    <div style="display: flex; gap: 30px; width: 100%; justify-content: space-between;">
        <!-- Left Side - ID Card -->
        <div class="profile-card" style="
        background: linear-gradient(135deg, #2c3e50, #3498db);
        color: white;
        width: 420px;
        height: 250px;
        border-radius: 12px;
        padding: 15px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,1);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255,255,255,0.1);
        ">
        <!-- Company Logo -->
        <div style="position: absolute; top: 10px; right: 10px; font-size: 12px; opacity: 0.8;">
            MINITZGO
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 15px;">
            <div style="display: flex; gap: 12px;">
            <img id="profilePic" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="Employee Picture" style="
                width: 60px;
                height: 60px;
                border-radius: 8px;
                border: 2px solid rgba(255,255,255,0.2);
            ">
            <div>
                <h3 id="employeeName" style="margin: 0; font-size: 16px;"></h3>
                <p style="margin: 10px; font-size: 11px; opacity: 0.8; color: #fff">ID: <span id="employeeID"> <?php 
                echo $_SESSION['employee_id'];
                ?> </span></p>
                <p style="margin: 0px; font-size: 11px; opacity: 0.8; color: #fff">Role: <span id="employeeRole">
                    <?php 
                echo $_SESSION['role'];
                ?> </span></p>
            </div>
            </div>
        </div>

        <div class="info-section" style="
            margin-top: 12px;
            font-size: 11px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        ">
            <div><strong style="opacity: 0.7;">Dept:</strong> 
                <span id="employeeDepartment" style="
                animation: dissolve 2s infinite;
                background-image: linear-gradient(to right, #fff, rgba(255,255,255,0.1));
                -webkit-background-clip: text;
                color: #fff;
                ">
                <?php 
                echo $_SESSION['role'];
                ?>    
            </span>
            </div>
            <div><strong style="opacity: 0.7;">Join Date:</strong> 
                <span id="employeeJoiningDate" style="
                    animation: dissolve 2s infinite;
                    -webkit-background-clip: text;
                    background-image: linear-gradient(to right, #fff, rgba(255,255,255,0.1));
                    color: #fff;
                ">
                <?php 
                echo $_SESSION['created_at'];
                ?></span>
            </div>
            <div><strong style="opacity: 0.7;">Email:</strong> 
                <span id="employeeEmail" style="
                    animation: dissolve 2s infinite;
                    -webkit-background-clip: text;
                    background-image: linear-gradient(to right, #fff, rgba(255,255,255,0.1));
                    color: #fff;
                ">
                <?php 
                echo $_SESSION['email'];
                ?></span>
            </div>
            <div><strong style="opacity: 0.7;">Phone:</strong> 
                <span id="employeePhone" style="
                    animation: dissolve 2s infinite;
                    -webkit-background-clip: text;
                    background-image: linear-gradient(to right, #fff, rgba(255,255,255,0.1));
                    color: #fff;
                "><?php 
                echo $_SESSION['phone'];
                ?></span>
            </div>
        </div>
        <style>
            @keyframes dissolve {
                0% { opacity: 1; }
                50% { opacity: 0.3; }
                100% { opacity: 1; }
            }
        </style>

        <!-- QR Code in bottom right -->
        <div id="qrcode" style="
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: x;
            height: 30px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 5px;
        "></div>

        <!-- Holographic Effect -->
        <div style="
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(125deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 30%, rgba(255,255,255,0) 60%);
            pointer-events: none;
        "></div>
        </div>

        <!-- Right Side - Calendar -->
        <div class="performance-container" style="
            width: 75%;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        ">
            <!-- Tickets Card -->
            <div class="metric-card" style="
                flex: 1;
                min-width: 300px;
                background: white;
                border-radius: 15px;
                padding: 20px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            ">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                <h5>Tickets Solved</h5>
                                <div style="text-align: right;">
                                    <h3 style="color: #4CAF50; margin: 0;">77</h3>
                                    <small style="color: #4CAF50;">↑ 12% this week</small>
                                </div>
                            </div>
                            <div style="height: 200px;">
                                <canvas id="ticketsChart"></canvas>
                            </div>
                        </div>

                        <!-- Hours Card -->
                        <div class="metric-card" style="
                            flex: 1;
                            min-width: 300px;
                            max-width: calc(33.33% - 20px);
                            background: white;
                            border-radius: 15px;
                            padding: 20px;
                            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                        ">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                <h5>Working Hours</h5>
                                <div style="text-align: right;">
                                    <h3 style="color: #2196F3; margin: 0;">39h</h3>
                                    <small style="color: #2196F3;">↑ 5% vs target</small>
                                </div>
                            </div>
                            <div style="height: 200px;">
                                <canvas id="hoursChart"></canvas>
                            </div>
                        </div>
                        <!-- Error Rate Card -->
                        <div class="metric-card" style="
                            flex: 1;
                            min-width: 300px;
                            max-width: calc(33.33% - 20px);
                            background: white;
                            border-radius: 15px;
                            padding: 20px;
                            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                        ">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                <h5>Error Rate</h5>
                                <div style="text-align: right;">
                                    <h3 style="color: #FF5722; margin: 0;">15%</h3>
                                    <small style="color: #FF5722;">↓ 3% improvement</small>
                                </div>
                            </div>
                            <div style="height: 200px;">
                                <canvas id="errorChart"></canvas>
                            </div>
                        </div>

                        <!-- Leave Calendar and Time Card -->
                        <div class="metric-card" style="
                            flex: 1;
                            min-width: 300px;
                            max-width: calc(33.33% - 20px);
                            background: white;
                            border-radius: 15px;
                            padding: 20px;
                            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                        ">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 1px;">
                                <h5>Leave Management</h5>
                                
                            </div>
                            <div id="currentDateTime" style="padding:10px; color: #666; font-size: 0.9em; background-color:#9C27B0; border-radius:10px; color:white; margin-bottom:10px"></div>

                            <div class="leave-status" style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span>Annual Leave</span>
                                    <span>0/20 days</span>
                                </div>
                                <div style="background: #eee; height: 10px; border-radius: 5px;">
                                    <div style="width: 0%; background: #9C27B0; height: 100%; border-radius: 5px;"></div>
                                </div>
                            </div>
                            
                            <div class="upcoming-leaves">
                                <h6>Leaves Status</h6>
                                <div style="background: #f5f5f5; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                                    <p style="margin: 0;"><small style="color: #fff; background-color:red; padding:5px; border-radius:15px; font-size:12px">Approved</small></p>
                                    <small style="color: #666;">No leaves pending</small>
                                    
                                </div>
                                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#leaveModal">
                                    Apply for Leave
                                </button>
                            </div>
                        </div>

                        <!-- Leave Application Modal -->
                        <div class="modal fade" id="leaveModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Leave Application</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form id="leaveForm" enctype="multipart/form-data" class="needs-validation" novalidate>
                                    <div class="modal-body">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-calendar-check me-2"></i> Employee ID*
                                            </label>
                                            <input type="text" class="form-control form-control-lg shadow-sm" required name="employeeId" placeholder="Enter your ID">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold"><i class="bi bi-calendar-check me-2"></i> Leave Type *</label>
                                            <select class="form-select form-select-lg shadow-sm" required name="leaveType">
                                                <option value="">Select Leave Type</option>
                                                <option value="annual">🌴 Annual Leave</option>
                                                <option value="sick">🏥 Sick Leave</option>
                                                <option value="personal">👤 Personal Leave</option>
                                            </select>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold"><i class="bi bi-calendar-plus me-2"></i> Start Date *</label>
                                                <input type="date" class="form-control form-control-lg shadow-sm" required name="startDate">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold"><i class="bi bi-calendar-minus me-2"></i> End Date *</label>
                                                <input type="date" class="form-control form-control-lg shadow-sm" required name="endDate">
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold"><i class="bi bi-chat-text me-2"></i> Reason *</label>
                                            <textarea class="form-control shadow-sm" rows="4" required name="reason"></textarea>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold"><i class="bi bi-paperclip me-2"></i> Supporting Documents</label>
                                            <input type="file" class="form-control form-control-lg shadow-sm" name="documents" accept=".pdf,.doc,.docx,.jpg,.png">
                                        </div>
                                    </div>

                                    <div class="modal-footer border-top-0">
                                        <button type="button" class="btn btn-light btn-lg px-4" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-lg px-4">Submit</button>
                                    </div>
                                </form>

                                    <style>
                                    .modal-content {
                                        border-radius: 20px;
                                        border: none;
                                    }
                                    .modal-header {
                                        background: #f8f9fa;
                                        border-radius: 20px 20px 0 0;
                                    }
                                    .form-control, .form-select {
                                        border-radius: 10px;
                                        border: 1px solid #dee2e6;
                                        padding: 12px;
                                    }
                                    .form-control:focus, .form-select:focus {
                                        border-color: #86b7fe;
                                        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
                                    }
                                    .btn {
                                        border-radius: 10px;
                                        padding: 10px 20px;
                                        transition: all 0.3s;
                                    }
                                    .btn:hover {
                                        transform: translateY(-2px);
                                    }
                                    </style>
                                </div>
                            </div>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>

                        <script>
                            $(document).ready(function() {
                                $("#leaveForm").on("submit", function(event) {
                                    event.preventDefault();
                                    var formData = new FormData(this);

                                    $.ajax({
                                        url: 'submit_leave.php',
                                        type: 'POST',
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        dataType: 'json',
                                        success: function(response) {
                                            if (response.status === "success") {
                                                alert("✅ Leave request submitted successfully.");
                                                $("#leaveModal").modal("hide");
                                                $("#leaveForm")[0].reset();
                                            } else {
                                                alert("❌ Error: " + response.message);
                                            }
                                        },
                                        error: function() {
                                            alert("⚠️ Error submitting leave request.");
                                        }
                                    });
                                });
                            });
                        </script>


                            <script>
                            // Update current date and time
                            function updateDateTime() {
                                const now = new Date();
                                const options = { 
                                    weekday: 'long', 
                                    year: 'numeric', 
                                    month: 'long', 
                                    day: 'numeric',
                                    hour: '2-digit', 
                                    minute: '2-digit', 
                                    second: '2-digit'
                                };
                                document.getElementById('currentDateTime').textContent = now.toLocaleDateString('en-US', options);
                            }
                            updateDateTime();
                            setInterval(updateDateTime, 1000);

                            // Handle leave form submission
                            function submitLeaveForm(event) {
                                event.preventDefault();
                                const formData = new FormData(event.target);
                                // Add your form submission logic here
                                alert('Leave application submitted successfully!');
                                $('#leaveModal').modal('hide');
                                event.target.reset();
                            }
                            </script>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                        // Charts configuration
                        const chartOptions = {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        };

                        // Tickets Chart
                        new Chart(document.getElementById('ticketsChart'), {
                            type: 'line',
                            data: {
                                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                                datasets: [{
                                    label: 'Tickets Solved',
                                    data: [12, 19, 15, 17, 14],
                                    borderColor: 'rgb(75, 192, 192)',
                                    tension: 0.1
                                }]
                            },
                            options: chartOptions
                        });

                        // Working Hours Chart
                        new Chart(document.getElementById('hoursChart'), {
                            type: 'bar',
                            data: {
                                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                                datasets: [{
                                    label: 'Working Hours',
                                    data: [8, 7.5, 8, 8.5, 7],
                                    backgroundColor: 'rgba(54, 162, 235, 0.5)'
                                }]
                            },
                            options: chartOptions
                        });

                        // Error Rate Chart
                        new Chart(document.getElementById('errorChart'), {
                            type: 'doughnut',
                            data: {
                                labels: ['Successful', 'Errors'],
                                datasets: [{
                                    data: [85, 15],
                                    backgroundColor: [
                                        'rgba(75, 192, 192, 0.5)',
                                        'rgba(255, 99, 132, 0.5)'
                                    ]
                                }]
                            },
                            options: chartOptions
                        });
                        </script>
    </div>
    </main>
    
    <script>
    function generateQRCode(data) {
        var qr = qrcode(0, 'M');
        var qrData = {
        name: data.name,
        id: data.id,
        role: data.role,
        email: data.email,
        department: data.department
        };
        qr.addData(JSON.stringify(qrData));
        qr.make();
        var qrImg = qr.createImgTag(2, 0); // Reduced size from 2 to 1
        document.getElementById('qrcode').innerHTML = qrImg;
        // Add CSS to further control the size
        var qrElement = document.getElementById('qrcode').querySelector('img');
        qrElement.style.width = '35px';
        qrElement.style.height = '35px';
    }

    // Update the fetchEmployeeData success callback
    function fetchEmployeeData(employeeId) {
        $.ajax({
        url: 'fetch_employee.php',
        type: 'POST',
        data: { employee_id: employeeId },
        dataType: 'json',
        success: function(data) {
            if (data.status === 'success') {
            $('#profilePic').attr('src', data.profile_pic || 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png');
            $('#employeeName').text(data.name);
            $('#employeeID').text(data.id);
            $('#employeeRole').text(data.role);
            $('#employeeEmail').text(data.email);
            $('#employeePhone').text(data.phone);
            $('#employeeDepartment').text(data.department);
            $('#employeeJoiningDate').text(data.joining_date);
            generateQRCode(data);
            } else {
            alert('Failed to fetch employee data');
            }
        },
        error: function() {
            alert('Error fetching employee data');
        }
        });
    }
    </script>

<script>
$(document).ready(function () {
    let employeeId = "<?php echo isset($_SESSION['employee_id']) ? $_SESSION['employee_id'] : ''; ?>"; // Get employee ID from PHP session
    if (!employeeId) {
        alert("Employee ID not found in session.");
        return;
    }
    fetchEmployeeData(employeeId);
});


</script>

</body>

</html>
