<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="css01/forgot.css"> 
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>
        <div class="wrapper">
            <form action="forgot.php" method="post">
                <h4>Reset Password</h4>
                <div class="input-box">
                    <input type="text" id="email" name="email" placeholder="Email" required>
                    <i class='bx bx-envelope'></i>
                </div>

                <div class="loginbtn">
                    <input type="submit" name="submit" value="Send Email">
                </div>

                <div class="register">
                    <p>Don't have an account? <a href="register01.php"> Sign in </a></p>
                </div>        
            </form>
        <div>
    </body>
</html>


<?php

//include 'conn.php'; // call database configure
//mysqli_set_charset($conn, 'utf8');
//session_start();

$host="localhost";
$username = "root";
$password = "";
$database = "db";

//connect to db, replace with actual username and password
$conn = new mysqli($host, $username, $password, $database);

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if (isset($_POST['submit'])){
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    if (findEmail($conn, $email)){
        if (generateOTP($conn, $email)){
            $alertMessage = "Email sent successfully.";
            echo "<script>alert('$alertMessage');</script>";
            header("Location: /task01/otp.php"); 

            exit();
        }
    
        else{
            $alertMessage = "Email could not be sent. Mailer Error.";
            echo "<script>alert('$alertMessage');</script>";
        }
    }
    
    else{
        $alertMessage = "Email could not be sent. Invalid Email.";
        echo "<script>alert('$alertMessage');</script>";
    }
    
    $conn->close();
}





############functions############
function findEmail($conn, $email){
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        return true;
    } else {
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
        } else {
            return false;
        }

        return true;
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
        //echo 'Email sent successfully';
        return true;
    } 
    else {
        //echo 'Email could not be sent.' . $mail->ErrorInfo;
        return false;
    }
}
?>


