<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="../../assets/css/loginPage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .otp-container {
            width: 400px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.13);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
        }

        .otp-container h3 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 30px;
        }

        .otp-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .otp-form input[type="text"] {
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

        .verify-button {
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

        .verify-button:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="background">
        <img src="../../assets/images/no-bg-images/laptop1.png" class="laptop-shape first-shape" alt="laptop">
        <img src="../../assets/images/no-bg-images/laptop2.png" class="laptop-shape second-shape" alt="laptop">
    </div>
    <div class="otp-container">
        <h3>Email Verification</h3>
        <form class="otp-form" action="../../backend/accountVERIFY.php" method="post">
            <input type="hidden" name="email" value="<?php if (isset($_GET['email'])) {echo $_GET['email']; } ?>">
            <div class="form-group">
                <label for="otp">
                    <i class="fas fa-key"></i> Enter OTP Code:
                </label>
                <input type="text" name="otp" id="otp" required>
            </div>
            <button type="submit" name="verify" class="verify-button">Verify</button>
        </form>
    </div>
</body>
</html>