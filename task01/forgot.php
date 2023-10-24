<!DOCTYPE html>
<html>
    <title>
        Reset Password
    </title>
    <head>
        Reset Password
    </head>

    <body>
        <br>
        <form action="forgot.php" method="post">
            <table>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="text" id="email" name="email" required></td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Send Email">
        </form>

        <br>
        <a href="login.php">
            <button>Login</button>
        </a>

        <a href="register.php">
            <button>Register</button>
        </a>
        
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


