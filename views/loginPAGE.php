<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../assets/css/loginPage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="background">
        <img src="../assets/images/no-bg-images/laptop1.png" class="laptop-shape first-shape" alt="laptop">
        <img src="../assets/images/no-bg-images/laptop2.png" class="laptop-shape second-shape" alt="laptop">
    </div>
    <div class="login-container">
        <h3>Welcome Back</h3>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form class="login-form" action="../backend/accountLOGIN.php" method="post">
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-user"></i> Email or Username
                </label>
                <input type="text" id="email" name="emailOrUsername" required>
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Password
                </label>
                <input type="password" id="password" name="password" required>
            </div>

            <input type="hidden" name="login" value="1">
            <button type="submit" class="login-button">Login</button>

            <div class="additional-links">
                <a href="forgotPASSWORD.php" class="forgot-password">Forgot Password?</a>
                <a href="user/userREGISTER.php" class="register">Create Account</a>
            </div>
        </form>
    </div>

    <script src="../assets/js/loginPage.js"></script>
</body>
</html>
