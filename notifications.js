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
