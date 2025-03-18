
 
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['employee_id'])) {
    header("Location: login"); // Redirect to login page if not logged in
    exit();
} 

// Fetch user session data
$user_id = $_SESSION['employee_id'];
$full_name = $_SESSION['full_name'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];
$status = $_SESSION['status'];
$created_at = $_SESSION['created_at'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUX Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
         .custom-select {
                    padding: 12px;
                    border-radius: 8px;
                    border: 2px solid #dee2e6;
                    background-color: rgba(255, 255, 255, 0.9);
                    transition: all 0.3s ease;
                    font-size: 1rem;
                }

                .custom-select:hover {
                    border-color: #80bdff;
                    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                }

                .custom-select:focus {
                    border-color: #80bdff;
                    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                    outline: none;
                }

                .custom-select option {
                    padding: 12px;
                    font-size: 1rem;
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
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        .sidebar a.logout {
            color: red;
            margin-top: auto;
        }
        .active{
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <nav class="sidebar">
    <?php 
   include 'side_bar.php';
    ?>
    </nav>

    <main class="main">
        <div class="header">
            <h2>AUX Dashboard <span class="text-muted">
                <?php
                    date_default_timezone_set('Asia/Kolkata'); // Set your timezone
                    $hour = (int)date('H'); // Get current hour in 24-hour format and convert to integer
                    $greeting = '';
                    if ($hour >= 5 && $hour < 12) {
                        $greeting = 'Good Morning';
                    } elseif ($hour >= 12 && $hour < 17) {
                        $greeting = 'Good Afternoon';
                    } else {
                        $greeting = 'Good Evening';
                    }
                    echo $greeting . ', ' . htmlspecialchars($full_name);

                    // Array of motivational quotes
                    $quotes = [
                        "Success is not final, failure is not fatal: it is the courage to continue that counts.",
                        "The only way to do great work is to love what you do.",
                        "Quality is not an act, it's a habit.",
                        "Your time is limited, don't waste it living someone else's life.",
                        "The future depends on what you do today.",
                        "Excellence is not a skill, it's an attitude."
                    ];
                    
                    // Get random quote
                    $randomQuote = $quotes[array_rand($quotes)];
                ?>     </span></h2>
            <p class="text-muted"><i>"<?php echo $randomQuote; ?>"</i></p>
        </div>
        <div class="form-container" style="width: 350px;">     <h4>AUX UPDATE</h4>     <form id="attendanceForm">
                <div class="mb-3"
                    <label for="employeeId" class="form-label">Employee ID</label>
                    <input type="text" class="form-control" id="employeeId" required>
                </div>
                <div class="mb-3">
                    <label for="employeeName" class="form-label">Employee Name</label>
                    <input type="text" class="form-control" id="employeeName" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label fw-bold">Status</label>
                    <select class="form-select form-select-lg custom-select" id="status" required>
                        <option value="" disabled selected>Select your status...</option>
                        <option value="Login">🟢 Login</option>
                        <option value="Logout">🔴 Logout</option>
                        <option value="Break">⏸️ Break</option>
                    </select>
                </div>

                    <!-- Break Reason (Hidden initially) -->
                <div class="mb-3 break-section" style="display: none;">
                    <label for="breakReason" class="form-label">Reason for Break</label>
                    <select class="form-control" id="breakReason">
                        <option value="Lunch">Lunch</option>
                        <option value="Tea/Coffee">Tea/Coffee</option>
                        <option value="Personal Work">Personal Work</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- Custom Reason for Break -->
                <div class="mb-3 break-section" id="customReasonDiv" style="display: none;">
                    <label for="customReason" class="form-label">Specify Reason</label>
                    <input type="text" class="form-control" id="customReason">
                </div>

                <!-- Break Duration -->
                <div class="mb-3 break-section" style="display: none;">
                    <label for="breakDuration" class="form-label">Break Duration (Minutes)</label>
                    <select class="form-control" id="breakDuration">
                        <option value="5">5 min</option>
                        <option value="10">10 min</option>
                        <option value="15">15 min</option>
                        <option value="30">30 min</option>
                        <option value="40">40 min</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">SET AUX</button>
            </form>
        </div>
    </main>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Pre-fill the form with session data
            $('#employeeId').val('<?php echo htmlspecialchars($_SESSION['employee_id'], ENT_QUOTES); ?>');
            $('#employeeName').val('<?php echo htmlspecialchars($_SESSION['full_name'], ENT_QUOTES); ?>');
            
            // Make fields readonly after pre-filling
            $('#employeeId, #employeeName').prop('readonly', true);

            $('#status').change(function() {
                if ($(this).val() === 'Break') {
                    $('.break-section').show();
                } else {
                    $('.break-section').hide();
                }
            });

            $('#breakReason').change(function() {
                if ($(this).val() === 'Other') {
                    $('#customReasonDiv').show();
                } else {
                    $('#customReasonDiv').hide();
                }
            });

            $('#attendanceForm').submit(function(event) {
                event.preventDefault();

                var employeeId = $('#employeeId').val();
                var employeeName = $('#employeeName').val();
                var sessionId = '<?php echo $_SESSION['employee_id']; ?>';
                var sessionName = '<?php echo $_SESSION['full_name']; ?>';

                // Validate employee ID and name
                if (employeeId !== sessionId || employeeName !== sessionName) {
                    alert('Invalid Employee ID or Name. Please use your correct credentials.');
                    return;
                }

                var status = $('#status').val();
                var breakReason = $('#breakReason').val();
                var customReason = $('#customReason').val();
                var breakDuration = $('#breakDuration').val();

                if (status === 'Break' && breakReason === 'Other') {
                    breakReason = customReason;
                }

                $.ajax({
                    url: 'save_attendance.php',
                    type: 'POST',
                    data: {
                        employee_id: employeeId,
                        employee_name: employeeName,
                        status: status,
                        break_reason: breakReason,
                        break_duration: breakDuration
                    },
                    success: function(response) {
                        alert(response);
                        $('.break-section').hide();
                    },
                    error: function() {
                        alert('Error saving attendance.');
                    }
                });
            });

            // Make the ID and name fields readonly
            $('#employeeId, #employeeName').prop('readonly', true);
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    <script>
        // mouse and keyboard activity capture code
        let inactivityTimer;
        let isInactive = false;
        const employeeId = <?php echo json_encode($_SESSION['employee_id']); ?>;
        
        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            if (isInactive) {
                updateStatus("online");
                isInactive = false;
            }
            inactivityTimer = setTimeout(() => {
                if (!isInactive) {
                    updateStatus("inactive");
                                        isInactive = true;
                                    }
                                }, 1800000); // 30 minutes inactivity timeout
                            }
                            
        function updateStatus(status) {
            if (!employeeId) return;
            
            $.ajax({
                url: "update_status.php",
                type: "POST",
                data: {
                    employee_id: employeeId,
                    status: status || "inactive"
                },
                success: function (response) {
                    console.log("Status updated:", status);
                },
                error: function () {
                    console.log("Error updating status");
                }
            });
        }

        // Handle page visibility changes
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Page is hidden (minimized or tab switched)
                clearTimeout(inactivityTimer);
                updateStatus("other tab");
            } else {
                // Page is visible again
                resetInactivityTimer();
                updateStatus("online");
            }
        });
        
        // Listen for mouse and keyboard activity
        window.addEventListener("mousemove", resetInactivityTimer);
        window.addEventListener("keydown", resetInactivityTimer);
        
        // Send periodic heartbeat to keep session alive
        setInterval(() => {
            if (!document.hidden) {
                resetInactivityTimer();
            }
        }, 30000); // Every 30 seconds

        // Start the inactivity timer initially
        resetInactivityTimer();
    </script>
    
</body>

</html>
