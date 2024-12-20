<?php

include '../config/database.php';

if(isset($_POST['register'])){

    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $location = $_POST['location'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $status = "unverified";
    $otp = rand(100000,999999);

    $sql = "SELECT * FROM `Users` WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if($num > 0){
        header("location: ../views/user/userREGISTER.php?error=This email already exists!");
        exit();
    }else{
        if($password == $confirmpassword){

            //send otp
            include '../includes/sendOTP.php';
            sendOTP($email, $otp);

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `Users` (`username`, `first_name`, `last_name`, `phone_number`, `location`, `email`, `password`, `otp`, `status`) VALUES ('$username', '$first_name', '$last_name', '$phone_number', '$location', '$email', '$hash', '$otp', '$status')";
            $result = mysqli_query($conn, $sql);
            if($result){
                header("location: ../views/user/verifyACCOUNT.php?email=$email&Register=Success");
            }else{
                header("location: ../views/user/userREGISTER.php?Register=Failed");
            }
        }else{
            header("location: ../views/user/userREGISTER.php?error=Passwords do not match!");
            exit();
        }
    }
}
?>