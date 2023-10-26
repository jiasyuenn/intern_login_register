<?php

include '../db_action/sendOTP.php';
include '../db_action/db_connect.php';

session_start();

$email = $_SESSION['email'];

if(isset($_POST['submit'])){
    $_SESSION['email'] = $email;
    $otp= $_POST['otp'];
    verifyOTP($conn, $email, $otp);
}

if(isset($_POST['resubmit'])){
    $_SESSION['email'] = $email;
    $otp= $_POST['otp'];
    resendOTP($conn, $email);
    
}


function verifyOTP($conn, $email, $otp){

    $sql = "SELECT * FROM users WHERE email = '$email' AND otp = '$otp'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        //otp_verified = true (session management)
        $_SESSION['otp_verified'] = true;
        header("Location: /task01/changePW.php"); 
    } else {

        //OTP not verified (valid=false), redirects to otp.php again
        $_SESSION['valid'] = false;
        header("Location: /task01/otp.php"); 
    }

}

function resendOTP($conn, $email){
    if (findEmail($conn, $email)){
        if (generateOTP($conn, $email)){

            $alertMessage = "OTP sent.";
            echo "<script>alert('$alertMessage'); window.location.href='/task01/otp.php';</script>";
            #####ignore $_SESSION['email-exists'] = true;
            //header("Location: /task01/otp.php"); 

        } //if

        else{
            $alertMessage = "OTP not sent. Mailer error. Please try again later";
            echo "<script>alert('$alertMessage'); window.location.href='/task01/otp.php';</script>";
        } //else
    } //if

    else{
        $alertMessage = "OTP not sent. Please re-enter your email.";
        echo "<script>alert('$alertMessage'); window.location.href='/task01/forgot.php';</script>";
    }

} // funct


?>