<link rel="stylesheet" href="../../assets/css/userHEADER.css">
<header class="header">
    <div class="d-flex justify-content-between align-items-center">
        <div class="user-info">
            <i class="fas fa-user-circle fa-2x"></i>
            <span>Welcome, <span id="username-display"><?php echo $_SESSION['username']; ?></span></span>
        </div>
        <!-- Add toggle button first -->
        <button class="btn btn-dark d-md-none position-relative" id="sidebar-toggle">
            <i class="fas fa-bars"></i>
            <span class="mobile-message-badge" style="
                width: 15px;
                height: 15px;
                position: absolute;
                right: 5px;
                top: 5px;
                display: none;
                background-color: #dc3545;
                border-radius: 50%;
                border: 2px solid #dc3545;
                z-index: 1000;
                animation: pulse 2s infinite;
            ">
                <i class="fas fa-envelope" style="
                    font-size: 10px; 
                    color: white;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                "></i>
            </span>
        </button>
    </div>
</header>

<style>
@keyframes pulse {
    0% {
        transform: scale(1.0);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
    }
    
    70% {
        transform: scale(1.95);
        box-shadow: 0 0 0 5px rgba(220, 53, 69, 0);
    }
    
    100% {
        transform: scale(1.0);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
    }
}
</style>

<script src="../../assets/js/jquery.js"></script>
<script src="../../assets/js/bootstrap.js"></script>
<script src="https://kit.fontawesome.com/your-code.js"></script>

<script>
function updateUsername() {
    $.ajax({
        url: 'get_username.php',
        type: 'GET',
        dataType: 'json',
        cache: false, // Prevent caching
        success: function(response) {
            if(response.success) {
                $('#username-display').text(response.username);
            }
        }
    });
}

// Call immediately when script loads
updateUsername();

// Still keep event listener for other components
$(document).on('profileUpdated', function() {
    updateUsername();
});
</script>
