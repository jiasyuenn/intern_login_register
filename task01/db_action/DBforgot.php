<?php

//include 'conn.php'; // call database configure
//mysqli_set_charset($conn, 'utf8');
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "db";

//connect to db, replace with actual username and password
$conn = new mysqli($host, $username, $password, $database);


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

if (isset($_POST['submit'])){
    $email = $_POST['email'];

    //retrieve the email from previous page
    $_SESSION['email'] = $email;

    //checks if email is registered in db
    if (findEmail($conn, $email)){
        if (generateOTP($conn, $email)){

            //valid=true, passes to otp.php
            $_SESSION['valid'] = true;

            #####ignore $_SESSION['email-exists'] = true;
            header("Location: /task01/otp.php"); 

        }
    
        else{

            //Invalid email. valid=false, passes to forgot.php, redirects to forgot.php
            $_SESSION['valid'] = false;
            header("Location: /task01/forgot.php"); 
        }
    }
    
    else{

        //Invalid email. valid=false, passes to forgot.php, redirects to forgot.php
        $_SESSION['valid'] = false;
        header("Location: /task01/forgot.php"); 
    }
    
    $conn->close();
}



############functions############
function findEmail($conn, $email){
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    //if email exists in db
    if ($result->num_rows == 1) {
        return true;
    } 
    
    else {
        return false;
    }
}

function generateOTP($conn, $email){
    $otp = mt_rand(100000, 999999);
    $subject = "Test: OTP Number!";
    $body = "OTP Number: " . $otp . "<br>Please avoid sharing your OTP number with anyone else to protect the security of your account.";

    //call send email function, pass in subject, and body
    if(sendEmail($email, $subject, $body)){

        ##save otp to db
        $sql = "UPDATE users SET otp = '$otp' WHERE email = '$email'";
        if ($conn->query($sql) === TRUE) {
            return true;
        } 
        
        else {
            return false;
        }
    }

    else
        return false;
}

function sendEmail($email, $subject, $body){

    //create phpmailer instance
    $mail = new PHPMailer();

    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'team.koson@gmail.com';
    $mail->Password = 'xzfeycurtrhoknwy';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender and recipient
    $mail->setFrom("team.koson@gmail.com", "Test");
    $mail->addAddress($email);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    if ($mail->send()) {
        return true;
    } 
    else {
        return false;
    }
}
?>