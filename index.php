<?php 
session_start();
  
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
                <div class="icon"><i class="bi bi-bell"></i></div>
                <div class="icon"><i class="bi bi-envelope"></i></div>
                <div class="icon"><i class="bi bi-gear"></i></div>
            </div>
        </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let inactivityTimer;
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
    resetInactivityTimer();
</script>

</body>
</html>