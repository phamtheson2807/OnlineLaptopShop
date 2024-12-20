<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../assets/css/loginPage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .forgot-container {
            width: 400px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.13);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
        }

        .forgot-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .submit-button {
            width: 100%;
            padding: 15px 0;
            background-color: #ffffff;
            color: #080710;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .submit-button:hover {
            background-color: #f0f0f0;
        }

        .form-group input {
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            font-size: 14px;
            font-weight: 300;
            color: #ffffff;
            border: none;
        }

        .form-group label {
            color: #ffffff;
            display: block;
            margin-bottom: 10px;
        }

        h3 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php if(isset($_SESSION['message'])): ?>
        <script>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo $_SESSION['message']; ?>',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'loginPAGE.php';
                }
            });
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <div class="background">
        <img src="../assets/images/no-bg-images/laptop1.png" class="laptop-shape first-shape" alt="laptop">
        <img src="../assets/images/no-bg-images/laptop2.png" class="laptop-shape second-shape" alt="laptop">
    </div>
    <div class="forgot-container">
        <h3>Reset Password</h3>
        <form class="forgot-form" action="../backend/accountPasswordRESET.php" method="post">
            <input type="hidden" name="email" value="<?php echo $_GET['email'] ?? ''; ?>">
            <div class="form-group">
                <label for="new_password">
                    <i class="fas fa-lock"></i> New Password
                </label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">
                    <i class="fas fa-lock"></i> Confirm Password
                </label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="update_password" class="submit-button">Update Password</button>
        </form>
    </div>
</body>
</html>