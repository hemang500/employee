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
    <title>Analytics Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            background: rgba(235, 232, 232, 0.83);
            border-radius: 50%;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .card {
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    background: rgba(41, 1, 1, 0.1);
    backdrop-filter: blur(10px);
    color: rgb(0, 0, 0);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

        .card i {
            font-size: 30px;
            margin-bottom: 10px;
        }
        .card h4 {
            margin: 5px 0;
        }
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .active{
            background-color: rgba(255, 255, 255, 0.1);


        }

        .notification-bell { position: relative; cursor: pointer; }
.badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: red;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
}

.notification-user-status { position: relative; cursor: pointer; }
.badge-user {
    position: absolute;
    top: -9px;
    right: -5px;
     background: red;
    color: white;
    border-radius: 15%;
    padding: 2px 6px;
    font-size: 9px;
    opacity: 0.7;
}
.notification-dropdown {
    position: absolute;
    top: 60px;
    right: 20px;
    background: white;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    max-height: 300px;
    overflow-y: auto;
    z-index: 999999;
    width: 300px;
    position: fixed;
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
           
            <h2>Hello, <?php echo $_SESSION['full_name']; ?></h2>
           
            <div class="header-icons">
                <div class="icon notification-bell">
                    <i class="bi bi-bell"></i>
                    <span class="badge" id="notifications"></span>
                </div>
                <div class="icon"><i class="bi bi-envelope"></i></div>

                <div class="icon notification-user-status">
                    <i class="bi bi-person"></i>
                    <span class="badge-user" id="status">online</span>
                </div>

            </div>

         <div id="notification-dropdown" class="notification-dropdown" style="display: none; 
         background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
         border-radius: 8px;
         padding: 10px;
         max-height: 400px;
         overflow-y: auto;
         scrollbar-width: thin;
         scrollbar-color: #888 #f1f1f1;">
        <div class="notification">
            <div id="message" style="
                padding: 5px;
                margin-bottom: 5px;">
            </div>
        </div>
        <style>
            #notification-dropdown::-webkit-scrollbar {
                width: 5px;
            }
            #notification-dropdown::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 5px;
            }
            #notification-dropdown::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 5px;
            }
            .notification-item {
                background: rgba(255, 255, 255, 0.7);
                margin-bottom: 8px;
                border-radius: 6px;
                transition: transform 0.2s;
            }
            .notification-item:hover {
                transform: translateX(5px);
            }
        </style>
    </div>
 
</div>
 


        </div>
        <br>
        <br>
        <br>
       
        <div class="summary-cards">
            <div class="card">
                <i class="bi bi-person-badge"></i>
                <h4>Total Employees</h4>
                <p>150</p>
            </div>
            <div class="card">
                <i class="bi bi-briefcase"></i>
                <h4>Total Clients</h4>
                <p id="totalClients">Loading...</p>
            </div>
            <div class="card">
                <i class="bi bi-list-check"></i>
                <h4>Working Tickets</h4>
                <p id="total_tickets">Loading...</p>
            </div>
            <div class="card">
                <i class="bi bi-exclamation-circle"></i>
                <h4>Open Tickets</h4>
                <p id="total_open_tickets">10</p>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="analyticsChart"></canvas>
        </div>
    </main>
    <script>
        let analyticsChart;

        function updateChart(totalClients, total_working_tickets, total_open_tickets) {
            const ctx = document.getElementById('analyticsChart').getContext('2d');
            if (analyticsChart) {
                analyticsChart.destroy();
            }
            analyticsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Employees', 'Clients', 'Working Tickets', 'Open Tickets'],
                    datasets: [{
                        label: 'Statistics',
                        data: [150, totalClients, total_working_tickets, total_open_tickets],
                        borderColor: '#4CAF50',
                        backgroundColor: 'rgba(76, 175, 80, 0.2)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
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
                    updateStatus("offline");
                                        isInactive = true;
                                    }
                                }, 1200000); // 20 minutes inactivity timeout
                            }
                            
        function updateStatus(status) {
            if (!employeeId) return;
            
            $.ajax({
                url: "update_status.php",
                type: "POST",
                data: {
                    employee_id: employeeId,
                    status: status || "offline"
                },
                success: function (response) {
                    console.log("Status updated:", status);
                    $("#status").text(status); // Update the status badge text
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
<script>
   let lastClearTime = localStorage.getItem('lastClearTime') ? new Date(localStorage.getItem('lastClearTime')) : new Date();
let lastNotificationId = localStorage.getItem('lastNotificationId') || 0;

// Request notification permission when page loads
if ("Notification" in window) {
    Notification.requestPermission();
}

function showNotification(message, sender) {
    if ("Notification" in window && Notification.permission === "granted") {
        new Notification(`New Message from ${sender}`, {
            body: message,
            icon: '/path/to/icon.png' // Add your notification icon path
        });
    }
}

function fetchNotifications() {
    $.ajax({
        url: "notifications.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
            let dropdown = $("#notification-dropdown");
            let messageContainer = $("#message");
            let notificationBadge = $("#notifications");

            // Filter messages based on lastClearTime
            let messages = response.message.filter(msg => new Date(msg.created_at) > lastClearTime);

            // Check for new notifications
            let newMessages = messages.filter(msg => msg.id > lastNotificationId);
            newMessages.forEach(msg => {
                showNotification(msg.message, msg.sender_name);
                lastNotificationId = msg.id;
            });

            // Update localStorage for last notification ID
            if (newMessages.length > 0) {
                localStorage.setItem('lastNotificationId', lastNotificationId);
            }

            // Update notification count badge
            notificationBadge.text(messages.length > 0 ? messages.length : "");

            // Clear previous messages and update dropdown content
            messageContainer.empty();

            if (messages.length === 0) {
                messageContainer.append(`<p class="text-center">No new notifications</p>`);
            } else {
                // Add "Clear All" button
                messageContainer.append(`
                    <button id="clearAll" class="btn btn-danger btn-sm w-100 mb-2">
                        Clear All Notifications
                    </button>
                `);

                // Display notifications
                messages.forEach(msg => {
                    messageContainer.append(`
                        <div class="notification-item" style="padding: 10px; border-bottom: 1px solid #eee;">
                            <strong>${msg.sender_name}</strong>
                            <p>${msg.message}</p>
                            <small style="color: #666;">${msg.created_at}</small>
                        </div>
                    `);
                });
                sendNotification()
            }
        },
        error: function() {
            $("#notifications").text("!");
            $("#message").html("<p class='text-danger text-center'>Error fetching notifications</p>");
        }
    });
}

// Notification dropdown toggle
$(".notification-bell").on("click", function(event) {
    event.stopPropagation();
    $("#notification-dropdown").toggle();
});

// Periodically fetch notifications
$(document).ready(function() {
    fetchNotifications();
    setInterval(fetchNotifications, 7500);

    // Clear all notifications handler
    $(document).on("click", "#clearAll", function() {
        lastClearTime = new Date();
        localStorage.setItem('lastClearTime', lastClearTime.toISOString());
        fetchNotifications();
    });

    // Close dropdown when clicking outside
    $(document).click(function(event) {
        if (!$(event.target).closest('.notification-bell, #notification-dropdown').length) {
            $('#notification-dropdown').hide();
        }
    });
});

</script>
</script>
    <script>
        function fetchTotalClients() {
            $.ajax({
                url: "get_total_clients.php",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $("#totalClients").text(response.total_clients);
                    updateChart(response.total_clients, $("#total_tickets").text(), $("#total_open_tickets").text());
                },
                error: function() {
                    $("#totalClients").text("Error fetching data");
                }
            });
        }

        // Fetch total clients when the page loads
        $(document).ready(function() {
            fetchTotalClients();

            // Auto-refresh the count every 10 seconds
            setInterval(fetchTotalClients, 10000);
        });

//total tickets counr;

function fetchTotalTickets() {
            $.ajax({
                url: "get_total_working_tickets.php",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $("#total_tickets").text(response.total_tickets);
                    updateChart($("#totalClients").text(), response.total_tickets, $("#total_open_tickets").text());
                },
                error: function() {
                    $("#total_tickets").text("Error fetching data");
                }
            });
        }

        // Fetch total clients when the page loads
        $(document).ready(function() {
            fetchTotalTickets();

            // Auto-refresh the count every 10 seconds
            setInterval(fetchTotalTickets, 10000);
        });

        //total open tickets
        function fetchTotalOpenTickets() {
            $.ajax({
                url: "get_total_open_tickets.php",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $("#total_open_tickets").text(response.total_tickets);
                    updateChart($("#totalClients").text(), $("#total_tickets").text(), response.total_tickets);
                },
                error: function() {
                    $("#total_open_tickets").text("Error fetching data");
                }
            });
        }

        // Fetch total clients when the page loads
        $(document).ready(function() {
            fetchTotalOpenTickets();

            // Auto-refresh the count every 10 seconds
            setInterval(fetchTotalOpenTickets, 10000);
        });

    </script>
</script>
<script>

    //windows notifications
        function sendNotification() {
            // Check if the browser supports notifications
            if (!("Notification" in window)) {
                alert("This browser does not support desktop notifications.");
                return;
            }

            // Ask for permission if not granted
            if (Notification.permission === "granted") {
                showNotification();
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        showNotification();
                    }
                });
            }
        }

        function showNotification() {
            const notification = new Notification("minitzgo", {
                body: "Checkout you have a new Notification.",
                icon: "images/dlogo.png" // Change to your preferred icon
            });

            // Optional: Add a click event to open a URL
            notification.onclick = function() {
                window.open("https:www.minitzgo.com/edashboard/index");
            };
            
        }
        
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 /*   let inactivityTimer;
    let isInactive = false;
    const employeeId = localStorage.getItem("employee_id"); // Assuming employee ID is stored

    function resetInactivityTimer() {
        clearTimeout(inactivityTimer);
        if (isInactive) {
            updateStatus("online");
            isInactive = false;
        }
        inactivityTimer = setTimeout(() => {
            updateStatus("inactive");
            isInactive = true;
        }, 5000); // 5 seconds inactivity timeout
    }

    function updateStatus(status) {
        $.ajax({
            url: "update_status.php",
            type: "POST",
            data: { employee_id: employeeId, status: status },
            success: function (response) {
                console.log(response);
            },
            error: function () {
                console.log("Error updating status");
            }
        });
    }

    // Listen for mouse and keyboard activity
    document.addEventListener("mousemove", resetInactivityTimer);
    document.addEventListener("keydown", resetInactivityTimer);

    // Start the inactivity timer initially
    resetInactivityTimer();*/
</script>

</body>
</html>