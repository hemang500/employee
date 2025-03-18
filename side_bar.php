<?php 
include 'backend/db.php';
?>

<div style="text-align: center; margin: 15px auto; background: linear-gradient(135deg, #ff9966, #ff5e62); padding: 15px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); animation: fadeIn 1s ease-in, float 3s infinite;">
    <img src="images/logo.png" alt="Company Logo" style="width: 180px; transition: transform 0.3s ease; animation: pulse 2s infinite;">
</div>

<style>
/* Greeting Card */
.greeting-card {
    text-align: center;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    margin: 25px 15px;
    animation: fadeIn 1s ease-in-out, glow 2s infinite alternate;
}

.greeting-card h3 {
    font-size: 22px;
    margin-bottom: 10px;
    font-weight: bold;
}

.greeting-card p {
    font-size: 15px;
    margin-bottom: 10px;
    line-height: 1.5;
}

 

.slider img {
    width: 0%;
   
}

.slider img.active {
    opacity: 1;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes glow {
    from { box-shadow: 0 0 10px rgba(255, 255, 255, 0.3); }
    to { box-shadow: 0 0 20px rgba(255, 255, 255, 0.6); }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let slides = document.querySelectorAll(".slider img");
    let index = 0;

    function showNextSlide() {
        slides[index].classList.remove("active");
        index = (index + 1) % slides.length;
        slides[index].classList.add("active");
    }

    setInterval(showNextSlide, 4000); // Change slide every 4 seconds
});
</script>

<?php 
echo '<a href="index" class="'.((basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '').'"><i class="bi bi-speedometer2"></i> Dashboard</a>';
echo '<a href="chat" class="'.((basename($_SERVER['PHP_SELF']) == 'chat.php') ? 'active' : '').'"><i class="bi bi-chat"></i> Teams</a>';
echo '<a href="tickets" class="'.((basename($_SERVER['PHP_SELF']) == 'tickets.php') ? 'active' : '').'"><i class="bi bi-ticket-detailed"></i> Tickets</a>';
echo '<a href="auxs" class="'.((basename($_SERVER['PHP_SELF']) == 'attendance.php') ? 'active' : '').'"><i class="bi bi-clock"></i> Aux</a>';
echo '<a href="clients" class="'.((basename($_SERVER['PHP_SELF']) == 'clients.php') ? 'active' : '').'"><i class="bi bi-bar-chart-line"></i> Sales</a>';
echo '<a href="tools" class="'.((basename($_SERVER['PHP_SELF']) == 'tools.php') ? 'active' : '').'"><i class="bi bi-gear"></i> Tools</a>';
echo '<a href="profile" class="'.((basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active' : '').'"><i class="bi bi-person"></i> Profile</a>';

// Enhanced Greeting Card Section
echo '<div class="greeting-card">
    <h3>Welcome to MinitzGo</h3>
    <p>Hello, '.$_SESSION['full_name'].'!</p>
    <p>Let\'s make today productive and fulfilling.</p>
    
</div>';

// Logout Link
echo '<a href="logout.php" class="logout"><i class="bi bi-box-arrow-right"></i> Logout</a>';
?>
