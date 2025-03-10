<?php
$conn = new mysqli("localhost", "root", "", "edashboard");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Modified query to order by created_at in descending order (newest first)
$query = "SELECT ticket_id, title, description, status, created_at, assigned_to, raised_by, priority, updated_at
          FROM tickets 
          ORDER BY created_at DESC"; 

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$tickets = '';
while ($row = mysqli_fetch_assoc($result)) {
    $title = htmlspecialchars($row['title']);
    $description = htmlspecialchars($row['description']);
    $status = htmlspecialchars($row['status']);
    $priority = htmlspecialchars($row['priority']);
    
    // Prevent warnings using null coalescing operator
    $created_by = htmlspecialchars($row['raised_by'] ?? 'Unknown');
    $updated_at = htmlspecialchars($row['updated_at'] ?? 'Unknown');
    $assigned = htmlspecialchars($row['assigned_to'] ?? 'Uncategorized');

    $tickets .= "
        <div class='ticket-item card mb-3 shadow-sm' data-id='{$row['ticket_id']}'>
            <div class='card-body'>
            <div class='d-flex justify-content-between align-items-center'>
            <h5 class='card-title mb-2 text-primary'>#ID {$row['ticket_id']} - $title</h5>
            <div>
            <span class='badge bg-" . ($priority == 'High' ? 'danger' : ($priority == 'Medium' ? 'warning' : 'info')) . " me-2'>$priority</span>
            <span class='badge bg-" . ($status == 'Open' ? 'success' : ($status == 'In Progress' ? 'warning' : 'secondary')) . "'>$status</span>
            </div>
            </div>
            <div class='mb-3'>
            <p class='card-text text-muted' id='description-{$row['ticket_id']}'>$description</p>
            </div>
            <div class='ticket-meta d-flex justify-content-between align-items-center flex-wrap'>
            <div class='text-muted small'>
            <span class='me-3'><i class='fas fa-user me-1'></i> Created By: $created_by</span>
            <span class='me-3'><i class='fas fa-folder me-1'></i> Assigned To: $assigned</span>
            <span class='me-2'><i class='fas fa-calendar me-1'></i> Created: 
                <span class='bg-primary text-light rounded-pill px-2 py-1' style='font-size: 0.9em'>" . date('M j, Y g:i A', strtotime($row['created_at'])) . "</span>
            </span>
            <span><i class='fas fa-clock me-1'></i> Updated: 
                <span class='bg-success text-light rounded-pill px-2 py-1' style='font-size: 0.9em'>" . date('M j, Y g:i A', strtotime($row['updated_at'])) . "</span>
            </span>
            </div>
            <div class='d-flex align-items-center gap-2'>
            <button class='btn btn-light btn-sm rounded-pill' 
                onclick='copyDescription({$row['ticket_id']})'>
                <i class='fas fa-copy me-1'></i> Copy Description
            </button>
            <select class='form-select form-select-sm rounded-pill status-select' style='width: auto; border: none; background-color:rgba(181, 204, 204, 0.52)' data-ticket-id='{$row['ticket_id']}'>
            <option value='Open'" . ($status == 'Open' ? ' selected' : '') . ">Open</option>
            <option value='In Progress'" . ($status == 'In Progress' ? ' selected' : '') . ">In Progress</option>
            <option value='Closed'" . ($status == 'Closed' ? ' selected' : '') . ">Closed</option>
            </select>
            </div>
            </div>
            </div>
            <script>
            function copyDescription(id) {
            const text = document.getElementById('description-' + id).innerText;
            navigator.clipboard.writeText(text).then(() => {
                alert('Description copied to clipboard!');
            });
            }
            </script>
        </div>
        <script>
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                const ticketId = this.dataset.ticketId;
                const newStatus = this.value;
                const ticketCard = this.closest('.ticket-item');
                const statusBadge = ticketCard.querySelector('.badge:nth-child(2)');
                
                fetch('update_ticket_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'ticket_id=' + ticketId + '&status=' + newStatus
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the status badge color and text
                        statusBadge.className = 'badge ' + (
                            newStatus == 'Open' ? 'bg-success' :
                            newStatus == 'In Progress' ? 'bg-warning' : 'bg-secondary'
                        );
                        statusBadge.textContent = newStatus;
                    } else {
                        alert('Failed to update status');
                    }
                });
            });
        });
        </script>";
}

echo json_encode(['tickets' => $tickets]);
?>
