<?php 
echo '<div   style="text-align: center; margin-top: 10px; margin-bottom: 10px; background-color:rgb(157, 158, 160); padding: 10px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); animation: fadeIn 1s ease-in, float 3s ease-in-out 1;">
    <img src="images/logo.png" alt="Logo" style="width: 200px; transition: transform 0.3s ease; animation: pulse 2s 1;">
</div>
<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>';
echo '<a href="index" class="'.((basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '').'"><i class="bi bi-speedometer2"></i> Dashboard</a>';

echo '<a href="chat" class="'.((basename($_SERVER['PHP_SELF']) == 'chat.php') ? 'active' : '').'"><i class="bi bi-chat"></i> Teams</a>';

echo '<a href="tickets" class="'.((basename($_SERVER['PHP_SELF']) == 'tickets.php') ? 'active' : '').'"><i class="bi bi-ticket-detailed"></i> Tickets</a>';

echo '<a href="auxs" class="'.((basename($_SERVER['PHP_SELF']) == 'attendance.php') ? 'active' : '').'"><i class="bi bi-clock"></i> Aux</a>';

echo '<a href="clients" class="'.((basename($_SERVER['PHP_SELF']) == 'clients.php') ? 'active' : '').'"><i class="bi bi-bar-chart-line"></i> Sales</a>';

echo '<a href="tools" class="'.((basename($_SERVER['PHP_SELF']) == 'tools.php') ? 'active' : '').'"><i class="bi bi-gear"></i> Tools</a>';

echo '<a href="profile" class="'.((basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active' : '').'"><i class="bi bi-person"></i> Profile</a>';

echo '<a href="logout.php" class="logout"><i class="bi bi-box-arrow-right"></i> Logout</a>';
?>