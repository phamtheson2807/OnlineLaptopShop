<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in first.'); window.location.href = '../loginPAGE.php';</script>";
    exit();
}

include '../../config/database.php';

// Handle password verification AJAX request
if (isset($_POST['verify_password'])) {
    $user_id = $_SESSION['user_id'];
    $password = $_POST['password'];

    $sql = "SELECT `password` FROM `users` WHERE `user_id`='$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
        $_SESSION['password_verified'] = true;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Incorrect password!']);
    }
    exit();
}

// Handle update profile
if (isset($_POST['update'])) {
    if (!isset($_SESSION['password_verified']) || !$_SESSION['password_verified']) {
        echo "<script>console.log('Password not verified');</script>";
        echo "<script>$('#passwordModal').modal('show');</script>";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $location = $_POST['location'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    $updates = [];
    if (!empty($username)) $updates[] = "`username`='$username'";
    if (!empty($first_name)) $updates[] = "`first_name`='$first_name'";
    if (!empty($last_name)) $updates[] = "`last_name`='$last_name'";
    if (!empty($phone_number)) $updates[] = "`phone_number`='$phone_number'";
    if (!empty($location)) $updates[] = "`location`='$location'";
    if (!empty($email)) $updates[] = "`email`='$email'";
    if (!empty($password) && $password == $confirmpassword) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $updates[] = "`password`='$hash'";
    }

    if (!empty($updates)) {
        $sql = "UPDATE `users` SET " . implode(", ", $updates) . " WHERE `user_id`='$user_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            unset($_SESSION['password_verified']);
            echo "<script>alert('Profile updated successfully.'); window.location.href = 'userPROFILE.php';</script>";
        } else {
            echo "<script>alert('Failed to update profile: " . mysqli_error($conn) . "'); window.location.href = 'userPROFILE.php';</script>";
        }
    } else {
        echo "<script>alert('No fields to update!'); window.location.href = 'userPROFILE.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Profile</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/userPROFILE.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <?php include 'userHEADER.php'; ?>
        
        <!-- Password Verification Modal -->
        <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Password Required</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="passwordVerificationForm">
                            <div class="form-group">
                                <label for="verifyPassword"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" id="verifyPassword" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="content p-4 d-flex justify-content-center align-items-center">
            <div class="background">
                <img src="../../assets/images/no-bg-images/laptop1.png" class="laptop-shape first-shape" alt="laptop">
                <img src="../../assets/images/no-bg-images/laptop2.png" class="laptop-shape second-shape" alt="laptop">
            </div>
            <div class="registration-container">
                <h3>Update Profile</h3>
                <form method="POST" action="userPROFILE.php" class="registration-form" id="updateForm">
                    <div class="form-group">
                        <label for="username"><i class="fas fa-user"></i> Username</label>
                        <input type="text" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="first_name"><i class="fas fa-user"></i> First Name</label>
                        <input type="text" id="first_name" name="first_name">
                    </div>
                    <div class="form-group">
                        <label for="last_name"><i class="fas fa-user"></i> Last Name</label>
                        <input type="text" id="last_name" name="last_name">
                    </div>
                    <div class="form-group">
                        <label for="phone_number"><i class="fas fa-phone"></i> Phone Number</label>
                        <input type="tel" id="phone_number" name="phone_number">
                    </div>
                    <div class="form-group">
                        <label for="location"><i class="fas fa-map-marker-alt"></i> Location</label>
                        <input type="text" id="location" name="location">
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirmpassword"><i class="fas fa-lock"></i> Confirm Password</label>
                        <input type="password" id="confirmpassword" name="confirmpassword">
                    </div>
                    <button type="submit" name="update" id="updateBtn">Update</button>
                </form>
            </div>
        </div>
    </div>
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/bootstrap.js"></script>
    <script>
    $(document).ready(function() {
        // Handle main form submission
        $('.registration-form').on('submit', function(e) {
            e.preventDefault();
            $('#passwordModal').modal('show');
        });

        // Handle password verification
        $('#passwordVerificationForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'userPROFILE.php',
                type: 'POST',
                data: {
                    verify_password: true,
                    password: $('#verifyPassword').val()
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#passwordModal').modal('hide');
                        // Get form data
                        var formData = $('.registration-form').serialize();
                        formData += '&update=true'; // Add update parameter
                        
                        // Submit form data
                        $.ajax({
                            url: 'userPROFILE.php',
                            type: 'POST',
                            data: formData,
                            success: function(updateResponse) {
                                if(response.success) {
                                    $('#passwordModal').modal('hide');
                                    updateUsername(); // Call directly instead of event
                                    alert('Profile updated successfully.');
                                }
                            },
                            error: function() {
                                alert('Failed to update profile.');
                            }
                        });
                    } else {
                        alert('Incorrect password!');
                    }
                },
                error: function() {
                    alert('Error during password verification.');
                }
            });
        });
    });
    </script>
</body>
</html>