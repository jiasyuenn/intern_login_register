<?php
    //session_start();

    $host="localhost";
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
        $subject = "!Test: OTP Number!";
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