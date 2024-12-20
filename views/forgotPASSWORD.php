<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: rgba(255, 255, 255, 0.9); /* Make background more visible */
            color: #080710; /* Darker text color */
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            width: 300px;
        }
        .modal input {
            background: rgba(255, 255, 255, 0.8);
            color: #080710;
        }

        /* Add this to your existing style section */
        .modal-content {
            width: 400px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.13);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            color: #ffffff; /* Match text color */
        }

        .modal-content h4 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 30px;
        }

        .modal-content input {
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

        .modal-content label {
            color: #ffffff;
            display: block;
            margin-bottom: 10px;
        }

        .close-btn {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            color: #ffffff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            color: #f0f0f0;
        }

        .modal-content {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="background">
        <img src="../assets/images/no-bg-images/laptop1.png" class="laptop-shape first-shape" alt="laptop">
        <img src="../assets/images/no-bg-images/laptop2.png" class="laptop-shape second-shape" alt="laptop">
    </div>
    <div class="forgot-container">
        <h3>Password Recovery</h3>
        
        <?php if(isset($_SESSION['message'])): ?>
            <div class="<?php echo isset($_SESSION['error']) ? 'error-message' : 'success-message'; ?>">
                <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form class="forgot-form">
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Enter Your Email
                </label>
                <input type="email" id="email" name="email" required>
            </div>
            <input type="hidden" name="reset" value="1">
            <button type="submit" class="submit-button">Send Reset Code</button>
        </form>
    </div>

     <!-- OTP Modal -->
    <div id="otpModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h4>Enter OTP Code</h4>
            <form id="otpForm" action="../backend/accountPasswordRESET.php" method="post">
                <input type="hidden" name="email" id="modalEmail">
                <div class="form-group">
                    <label for="otp">Enter OTP sent to your email</label>
                    <input type="text" name="otp" id="otp" required>
                </div>
                <div style="margin-top: 20px;">
                    <button type="submit" name="verify_otp" class="submit-button btn-primary">Verify OTP</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelector('.forgot-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            // Debug form data
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            
            fetch('../includes/forgotPasswordOTP.php', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.text();
            })
            .then(text => {
                console.log('Raw response:', text);
                if (!text || text.trim() === '') {
                    throw new Error('Server returned empty response');
                }
                return JSON.parse(text);
            })
            .then(data => {
                if(data.success) {
                    document.getElementById('modalEmail').value = data.email;
                    document.getElementById('otpModal').style.display = 'flex';
                } else {
                    alert(data.message || 'Operation failed');
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                alert('Request failed: ' + error.message);
            });
        });

        document.querySelector('.close-btn').addEventListener('click', function() {
            document.getElementById('otpModal').style.display = 'none';
        });
    </script>
</body>
</html>