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
    <title>Clients Follow-Up - Analytics Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Bundle (JS + Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        .table-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
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

    <main class="main">
        <div class="header">
            <h2>Clients Follow-Up</h2>
            <div style="position: relative;">
                <input type="text" id="searchInput" 
                    placeholder="Search Clients..." 
                    style="
                        background: rgba(255, 255, 255, 0.2);
                        border: none;
                        border-radius: 20px;
                        padding: 8px 35px 8px 15px;
                        color: black;
                        width: 250px;
                    ">
                <i class="bi bi-search" 
                    style="
                        position: absolute;
                        right: 12px;
                        top: 50%;
                        transform: translateY(-50%);
                        color: rgba(0,0,0,0.5);
                    "></i>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#clientModal">Add Client</button>
        </div>

        <div class="table-container">
            <h4 class="mb-3">Follow-Up List</h4>
            <div id="clientTable"></div>
        </div>
    </main>

    <!-- Add Client Modal -->
    <div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background: linear-gradient(to bottom right, #6c6d7c, #313241); color: white;">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientModalLabel">Add Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="clientForm">
                        <div class="mb-3">
                            <input type="text" id="client_name" class="form-control" placeholder="Client Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" id="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" id="phone" class="form-control" placeholder="Phone" required>
                        </div>
                        <div class="mb-3">
                            <select id="status" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="New">New</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Converted">Converted</option>
                                <option value="Lost">Lost</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="text" id="notes" class="form-control" placeholder="Notes" required>
                        </div>
                        <div class="mb-3">
                            <input type="date" id="follow_up_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <input type="time" id="follow_up_time" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-light text-dark">Add Client</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    $(document).ready(function () {
        fetchClientData();
    
        // Add search functionality
        $("#searchInput").on("keyup", function() {
            let searchText = $(this).val().toLowerCase();
            $("#clientTable tr:not(:first)").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
        });

        // Prevent form from submitting normally and handle it via AJAX
        $("#clientForm").on("submit", function (e) {
            e.preventDefault(); // Prevent default form submission
            let clientData = {
                client_name: $("#client_name").val(),
                email: $("#email").val(),
                phone: $("#phone").val(),
                status: $("#status").val(),
                notes: $("#notes").val(),
                follow_up_date: $("#follow_up_date").val(),
                follow_up_time: $("#follow_up_time").val()
            };
            
            $.ajax({
                url: "insert_client.php",
                type: "POST",
                data: clientData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        alert(response.message);
                        fetchClientData();
                        // Close modal and remove backdrop
                        const modal = bootstrap.Modal.getInstance($('#clientModal'));
                        modal.hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        // Reset form
                        $("#clientForm")[0].reset();
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function (xhr) {
                    alert("Error in AJAX request: " + xhr.responseText);
                }
            });
            return false; // Additional protection against form submission
        });
    
        function fetchClientData() {
            $.ajax({
                url: "fetch_clients.php",
                type: "GET",
                success: function (data) {
                    $("#clientTable").html(data);
                    // Reapply search filter after data refresh
                    $("#searchInput").trigger("keyup");
                },
                error: function () {
                    $("#clientTable").html("<p class='text-danger'>Failed to load data.</p>");
                }
            });
        }
    });
    </script>
</body>
</html>
