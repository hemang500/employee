
<?php
    session_start();
  
      $eid =  $_SESSION['employee_id'];
      $name =  $_SESSION['full_name'];
      $role =  $_SESSION['role'];
         
         
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Analytics Dashboard</title>
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
            flex-direction: column;
            height: 100vh;
            background-color: black;
        }
        .navbar {
            width: 100%;
            background-color: black;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        .navbar .icons {
            display: flex;
            gap: 15px;
            font-size: 20px;
            cursor: pointer;
        }
        .sidebar {
            width: 20vw;
            background-color: black;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
            overflow-y: auto;
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
            background-color: rgba(211, 195, 195, 0.1);
        }
        .chat-sidebar {
            flex: 0.3;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            color: white;
            overflow-y: auto;
        }
        .chat-sidebar .member {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }
        .chat-sidebar .member:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .chat-sidebar .member img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
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
        .chat-box {
            flex: 1;
 
            border-radius: 10px;
            padding: 15px;
            overflow-y: auto;
            
            
        }
        .chat-message {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .chat-message img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .message-content {
            background-color: white;
            padding: 10px;
            border-radius: 10px;
            max-width: 60%;
        }
        .message-input {
            display: flex;
            align-items: center;
            padding: 10px;
            background: rgba(160, 151, 151, 0.34);
            border-radius: 25px;
            margin-top: 20px;
        }
        .message-input input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 25px;
        }
        .message-input .icon {
            cursor: pointer;
            margin-left: 10px;
            font-size: 20px;
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
        .chat-message .details {
            font-size: 12px;
            color: gray;
            margin-top: 2px;
        }

        .sends:hover {
            transform: scale(1.2);
            transition: transform 0.2s ease;
            cursor: pointer;
        }

        .active-chat {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;    
        }
         /* Hide scrollbar by default */
         .chat-container::-webkit-scrollbar {
                    width: 8px;
                    display: none;
                }

                /* Show scrollbar on hover */
                .chat-container:hover::-webkit-scrollbar {
                    display: block;
                }

                .chat-container::-webkit-scrollbar-track {
                    background: rgba(0,0,0,0.1);
                    border-radius: 4px;
                }

                .chat-container::-webkit-scrollbar-thumb {
                    background: rgba(0,0,0,0.2);
                    border-radius: 4px;
                }

                .sidebar a.logout {
            color: red;
            margin-top: auto;
        }
    </style>
</head>
<body>
   

    <div style="display: flex; flex: 1;">
        <nav class="sidebar">
        <?php 
   include 'side_bar.php';
    ?>
        </nav>

        <aside class="chat-sidebar" style="overflow-y: auto; scrollbar-width: thin;">
                    <h4>Team Members</h4>
                    <div class="member active-chat"><img src="images/dev.webp" alt=""> Dev Intern's</div><br>
                    <div class="member"><img src="images/ui.jpg" alt=""> UX/UI Team</div><hr><span style="opacity:0.6;">Management  </span>
                    <span style="opacity:0.4; padding:10px"> No access</span>
                    <div class="member"><img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt=""> Production</div>
                    <div class="member"><img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt=""> Deployment</div>
                    <div class="member"><img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt=""> Seniors Team</div>
                    <div class="member"><img src="https://www.shutterstock.com/image-vector/blazer-icon-vector-glyph-style-260nw-1182172069.jpg" alt=""> BDM Team</div>
                    <div class="member"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRcRBoorAOVAOqotm-7CX878D0HMg1QtbIkordKUJRlSmEj0n8FN8Gclz7EV-kr0tw_3Q&usqp=CAU" alt=""> Sales Team</div>
                    <div class="member"><img src="https://cdn2.vectorstock.com/i/1000x1000/84/71/neon-glowing-star-vector-13368471.jpg" alt=""> Marketing Team</div>
                </aside>

                <!-- Main chat Area -->
                <main class="main">
                    <div class="header">
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <h2>minitZgo</h2>
                            <div style="position: relative;">
                                <input type="text" id="searchChat" 
                                    placeholder="Search messages..." 
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
                        </div>
                        <div class="header-icons">
                            <div class="icon"><i class="bi bi-bell"></i></div>
                            <div class="icon"><i class="bi bi-envelope"></i></div>
                            <div class="icon"><i class="bi bi-gear"></i></div>
                        </div>
                    </div>
                    <div class="chat-container" style="height: calc(100vh - 250px); overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none;"> 
                        <div class="chat-box" id="chatBox" style="scrollbar-width: thin;">
                            <div class="chat-message">
                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="">    
                                <div class="chatBox">  <br>  <span style="opacity: 0.7; font-size: 13.5px; ">Alice <span div class="details">10:30 AM, Monday</span></span>  </div>   
                            </div>
                        </div>
                    </div>

                    <script>
                    // Function to scroll to bottom
                    function scrollToBottom() {
                        const chatContainer = document.querySelector('.chat-container');
                        if (chatContainer) {
                            chatContainer.scrollTop = chatContainer.scrollHeight;
                        }
                    }

                    // Initial scroll on page load
                    document.addEventListener('DOMContentLoaded', scrollToBottom);

                    let lastMessageCount = 0;
                    let isUserScrolling = false;
                    const chatContainer = document.querySelector('.chat-container');

                    // Track user scrolling
                    chatContainer.addEventListener('scroll', () => {
                        const isAtBottom = Math.abs(chatContainer.scrollHeight - chatContainer.clientHeight - chatContainer.scrollTop) < 50;
                        isUserScrolling = !isAtBottom;
                    });

                    async function fetchMessages() {
                        try {
                            const response = await fetch('maingroup.php');
                            const data = await response.json();
                            const chatBox = document.getElementById('chatBox');
                            
                            if (chatBox && data.length !== lastMessageCount) {
                                chatBox.innerHTML = ''; // Clear existing messages
                                const currentUser = '<?php echo $name; ?>';
                                const currentUserId = '<?php echo $eid; ?>';
                                
                                data.forEach(message => {
                                    // Your existing message rendering logic here
                                    // This will be handled by your other fetchMessages implementation
                                });

                                lastMessageCount = data.length;

                                // Only scroll to bottom if user isn't manually scrolling
                                // or if it's a new message from the current user
                                if (!isUserScrolling || data[data.length - 1]?.sender_id === currentUserId) {
                                    setTimeout(scrollToBottom, 100); // Small delay to ensure content is rendered
                                }
                            }
                        } catch (error) {
                            console.error('Error:', error);
                        }
                    }

                    // Call fetchMessages initially and set up interval
                    fetchMessages();
                    setInterval(fetchMessages, 500);
                    </script>
                    
<div class="message-input" style="position: sticky; bottom: 0; width: 100%; margin: 10px 0; display: flex; flex-wrap: nowrap; align-items: center;">
                        <input type="text" id="messageInput" placeholder="Type a message..." style="flex: 1; min-width: 0; padding: 10px;" 
                            onkeypress="if(event.key === 'Enter') { 
                                document.getElementById('sendButton').click();
                                this.value = '';
                                return false;
                            }" 
                            onclick="if(this.value === this.defaultValue) { this.value = ''; }">
                        <div style="display: flex; gap: 10px; flex-shrink: 0;">
                            <div class="emoji-wrapper" style="position: relative;">
                                <i class="bi bi-emoji-smile icon sends" id="emojiButton"></i>
                                <div id="emojiPicker" style="display: none; position: absolute; bottom: 40px; right: 0; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 250px; width: 90vw;">
                                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(30px, 1fr)); gap: 5px;">
                                        <?php
                                        $emojis = ['😀', '😂', '😊', '😍', '😎', '😢', '😡', '🎉', '❤️', '👍', '👋', '🙏', '🔥', '⭐', '💡', '💪'];
                                        foreach ($emojis as $emoji) {
                                            echo "<span class='emoji' style='cursor: pointer; text-align: center;'>$emoji</span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Meet Scheduler Button -->
                            <i class="bi bi-calendar-plus icon sends" id="meetSchedulerBtn" onclick="showMeetScheduler()"></i>
                            
                            <!-- File Share Button -->
                            <i class="bi bi-file-earmark-arrow-up icon sends" onclick="showFileShare()"></i>
                            
                            <i class="bi bi-send icon sends" id="sendButton" style="margin-right:30px" onclick="sendMessage()"></i>
                        <!-- File Share Modal -->
                        <div id="fileShareModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); padding: 20px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.2); z-index: 1000;">
                            <h3>Share File's</h3>
                            <form id="fileShareForm">
                                <input type="text" class="rounded-pill" id="fileTitle" placeholder="File Title" required><br>
                                <input type="url" class="rounded-pill" id="fileLink" placeholder="WeTransfer/Drive Link" required><br>
                                <textarea id="fileDescription" class="rounded" placeholder="Brief description" rows="3"></textarea><br>
                                <button type="submit" class="btn btn-primary rounded-pill">Share</button>
                                <button type="button" class="btn btn-secondary rounded-pill" onclick="closeModals()">Cancel</button>
                            </form>
                        </div>

                    
                    </div>
                     

                    <!-- Meet Scheduler Modal -->
                    <div id="meetSchedulerModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); padding: 20px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.2); z-index: 1000;">
                        <h3>Schedule A Meet</h3>
                        <form id="meetSchedulerForm">
                            <input type="text" class="rounded-pill" id="meetTitle" placeholder="Meeting Title" required><br>
                            <input type="datetime-local" class="rounded-pill" id="meetDateTime" required><br>
                            <input type="text" class="rounded-pill" id="meetLink" placeholder="Meet Link" required><br>
                            <button type="submit" class="btn btn-primary rounded-pill">Schedule Meeting</button>
                            <button type="button" class="btn btn-secondary rounded-pill" onclick="closeModals()">Cancel</button>
                        </form>
                    </div>

                    <script>
                        let currentOpenModal = null;

                        function closeModals() {
                            document.getElementById('fileShareModal').style.display = 'none';
                            document.getElementById('meetSchedulerModal').style.display = 'none';
                            currentOpenModal = null;
                        }

                        function toggleModal(modalId) {
                            const modal = document.getElementById(modalId);
                            
                            // If there's a currently open modal, close it
                            if (currentOpenModal && currentOpenModal !== modalId) {
                                document.getElementById(currentOpenModal).style.display = 'none';
                            }

                            // Toggle the clicked modal
                            if (modal.style.display === 'none') {
                                modal.style.display = 'block';
                                currentOpenModal = modalId;
                            } else {
                                modal.style.display = 'none';
                                currentOpenModal = null;
                            }
                        }

                        function showFileShare() {
                            toggleModal('fileShareModal');
                        }

                        function showMeetScheduler() {
                            toggleModal('meetSchedulerModal');
                        }
                    </script>
                    <script>
                        function showFileShare() {
                            document.getElementById('fileShareModal').style.display = 'block';
                        }

                        function closeFileShare() {
                            document.getElementById('fileShareModal').style.display = 'none';
                        }

                        document.getElementById('fileShareForm').addEventListener('submit', function(e) {
                            e.preventDefault();
                            const title = document.getElementById('fileTitle').value;
                            const link = document.getElementById('fileLink').value;
                            const description = document.getElementById('fileDescription').value;
                            
                            // Format file share message
                            const fileMessage = `📎 Shared File:\n
                                📑 ${title}\n
                                📝 ${description}\n
                                🔗 ${link}`;
                            
                            // Send to chat
                            fetch('maingroup_send.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({
                                    sender_id: '<?php echo $eid; ?>',
                                    sender_name: '<?php echo $name; ?>',
                                    message: fileMessage
                                })
                            });

                            closeFileShare();
                        });
                        </script>

                        <style>
                        #fileShareModal input, #fileShareModal textarea {
                            margin: 10px 0;
                            padding: 8px;
                            width: 100%;
                            border: 1px solid #ddd;
                        }
                        #fileShareModal button {
                            margin: 10px 5px;
                            padding: 8px 15px;
                        }
                        </style>
                    <script>
                    function showMeetScheduler() {
                        document.getElementById('meetSchedulerModal').style.display = 'block';
                    }

                    function closeMeetScheduler() {
                        document.getElementById('meetSchedulerModal').style.display = 'none';
                    }

                    document.getElementById('meetSchedulerForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const title = document.getElementById('meetTitle').value;
                        const dateTime = new Date(document.getElementById('meetDateTime').value);
                        const link = document.getElementById('meetLink').value;
                        
                        // Schedule meeting
                        scheduleMeet(title, dateTime, link);
                        
                        // Post meeting announcement
                        const announcement = `🎯 New Meeting Scheduled!\n
                            📌 ${title}\n
                            🕒 ${dateTime.toLocaleString()}\n
                            🔗 ${link}`;
                        
                        // Send to chat
                        fetch('maingroup_send.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                sender_id: '<?php echo $eid; ?>',
                                sender_name: '<?php echo $name; ?>',
                                message: announcement
                            })
                        });

                        // Set reminder
                        const reminderTime = new Date(dateTime.getTime() - 3 * 60000); // 3 minutes before
                        const currentTime = new Date();
                        
                        // Only set reminder if meeting is in the future
                        if (reminderTime > currentTime) {
                            const timeoutDuration = reminderTime.getTime() - currentTime.getTime();
                            const timerId = setTimeout(() => {
                                const reminder = `⚠️ Reminder: Meeting "${title}" starts in 3 minutes!\n🔗 ${link}`;
                                fetch('maingroup_send.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({
                                        sender_id: '<?php echo $eid; ?>',
                                        sender_name: '<?php echo $name; ?>',
                                        message: reminder
                                    })
                                });
                            }, timeoutDuration);

                            // Store timeout ID with meeting details
                            const reminderData = { timerId, title, dateTime: reminderTime.toISOString() };
                            localStorage.setItem(`reminder_${title}`, JSON.stringify(reminderData));
                        }

                        closeMeetScheduler();
                    });

                    function scheduleMeet(title, dateTime, link) {
                        // Store meeting details in localStorage
                        const meetings = JSON.parse(localStorage.getItem('scheduledMeetings') || '[]');
                        meetings.push({ title, dateTime, link });
                        localStorage.setItem('scheduledMeetings', JSON.stringify(meetings));
                    }
                    </script>

                    <style>
                    #meetSchedulerModal input {
                        margin: 10px 0;
                        padding: 8px;
                        width: 100%;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                    }
                    #meetSchedulerModal button {
                        margin: 10px 5px;
                        padding: 8px 15px;
                    }
                    </style>

                    <script>
                    document.getElementById('emojiButton').addEventListener('click', function() {
                        const picker = document.getElementById('emojiPicker');
                        picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
                    });

                    document.querySelectorAll('.emoji').forEach(emoji => {
                        emoji.addEventListener('click', function() {
                            const input = document.getElementById('messageInput');
                            input.value += this.textContent;
                            document.getElementById('emojiPicker').style.display = 'none';
                        });
                    });

                    // Close emoji picker when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!e.target.closest('.emoji-wrapper')) {
                            document.getElementById('emojiPicker').style.display = 'none';
                        }
                    });
                    </script>
                </main>
                </div>

                <script>
                const searchInput = document.getElementById('searchChat');
                let currentSearchTerm = '';

                function performSearch() {
                    currentSearchTerm = searchInput.value.toLowerCase();
                    const messages = document.querySelectorAll('.chat-message');
                    let foundMessages = false;
                    
                    messages.forEach(message => {
                        const messageText = message.textContent.toLowerCase();
                        if (currentSearchTerm === '') {
                            message.style.display = 'flex';
                            foundMessages = true;
                        } else {
                            const isVisible = messageText.includes(currentSearchTerm);
                            message.style.display = isVisible ? 'flex' : 'none';
                            if (isVisible) foundMessages = true;
                        }
                    });

                    return foundMessages;
                }

                function handleSearch(e) {
                    if (e) e.preventDefault();
                    performSearch();
                }

                searchInput.addEventListener('input', handleSearch);
                searchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        handleSearch();
                    }
                });

                // Update search results when new messages are fetched
                const originalFetchMessages = window.fetchMessages;
                window.fetchMessages = async function() {
                    const response = await fetch('maingroup.php');
                    const data = await response.json();
                    await originalFetchMessages();
                    if (currentSearchTerm) {
                        performSearch();
                    }
                };
                </script>


            <script>
                function fetchMessages() {
                    fetch('maingroup.php')
                        .then(response => response.json())
                        .then(data => {
                            const chatBox = document.getElementById('chatBox');
                            chatBox.innerHTML = '';
                            const currentUser = '<?php echo $name; ?>';
                            const currentUserId = '<?php echo $eid; ?>';
                            
                            data.forEach(message => {
                                const isSelf = message.sender_name === currentUser && message.sender_id === currentUserId;
                                
                                // Format date
                                const messageDate = new Date(message.created_at);
                                const today = new Date();
                                const diffDays = Math.floor((today - messageDate) / (1000 * 60 * 60 * 24));
                                
                                let formattedDate;
                                if (diffDays === 0) {
                                    formattedDate = 'Today ' + messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                                } else if (diffDays === 1) {
                                    formattedDate = 'Yesterday ' + messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                                } else if (diffDays <= 3) {
                                    formattedDate = messageDate.toLocaleDateString('en-US', { weekday: 'long' }) + 
                                               ' ' + messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                                } else {
                                    formattedDate = messageDate.toLocaleDateString('en-US', { 
                                        month: 'short', 
                                        day: 'numeric',
                                        year: 'numeric'
                                    }) + ' ' + messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                                }

                                const messageHtml = isSelf ? `
                                    <div class="chat-message self" style="justify-content: flex-end;">
                                        <div class="message-content" style="background: lightgreen;">
                                            ${message.message}<br>
                                            <span style="opacity: 0.7; font-size: 13.5px;">
                                                ${message.sender_name} 
                                                <span class="details">${formattedDate}</span>
                                            </span>
                                        </div>
                                        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="">
                                    </div>
                                ` : `
                                    <div class="chat-message">
                                        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="">
                                        <div class="message-content">
                                            ${message.message}<br>
                                            <span style="opacity: 0.7; font-size: 13.5px;">
                                                ${message.sender_name} 
                                                <span class="details">${formattedDate}</span>
                                            </span>
                                        </div>
                                    </div>
                                `;
                                chatBox.innerHTML += messageHtml;
                            });
                        })
                        .catch(error => console.error('Error:', error));
                }

                // Fetch messages initially
                fetchMessages();

                // Refresh messages every 5 seconds
                setInterval(fetchMessages, 500);
            </script>

            <script> 
            document.getElementById('sendButton').addEventListener('click', function() {
                const messageInput = document.getElementById('messageInput');
                const message = messageInput.value.trim();

                if (message !== '') {
                    fetch('maingroup_send.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            sender_id: '<?php echo $eid; ?>',
                            sender_name: '<?php echo $name; ?>',
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            messageInput.value = '';
                            fetchMessages(); // Refresh messages immediately
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
            </script>

            </body>
</html>
