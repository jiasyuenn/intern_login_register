<?php
    session_start();
    //import PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader?
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    include('db_action/db_connect.php'); //connect to database

    //email content
    $subject = "Email Address Verification";
    $message = "Please click on this <a href=http://localhost/task01/welcome.php>link</a> to verify your email address!";

    //back to login page
    if(isset($_POST['close'])){
        header("location: login.php");
    }

    if(isset($_POST['resend'])){
        if(isset($_SESSION['un'])){
            $username =  $_SESSION['un'];
            
            //check if the username alr exists in db
            $usernameInDb = "SELECT * FROM users WHERE username = '$username'";
            $result_username = mysqli_query($conn, $usernameInDb);

            if (mysqli_num_rows($result_username) > 0){
                echo 'get';
                $row=$result_username->fetch_assoc();
                $email = $row['email'];
                echo $email;

                //send verification email
                $mail = new PHPMailer(true);

                $mail -> isSMTP();
                $mail ->Host = 'smtp.gmail.com';
                $mail ->SMTPAuth = true;
                $mail->Username = 'team.koson@gmail.com'; // Your gmail
                $mail->Password = 'xzfeycurtrhoknwy'; // Your gmail app password
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('team.koson@gmail.com');
                
                $mail->addAddress($email);

                $mail->isHTML(true);

                $mail->Subject = $subject;
                $mail->Body = $message;

                if ($mail->send()) {

                    //session to be used in welcome.php
                    $_SESSION['email01'] = $email;

                    //session to be used in login.php
                    $_SESSION['success'] = "Registration successful! Please check your email.";

                    header('Location:login.php');
                } 
                else {
                    echo 'Email could not be sent.' . $mail->ErrorInfo;
                }
            }else{
                echo 'cannot get';
            }


        }else{
            echo 'not ok';
        }
    }

    



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/unverified.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper01">
        <form action="unverified.php" method="POST">
            <div>
                <p>Your email is unverified! Please verify you email!</p>
            </div>
            <div class="control">
                <input type="submit" name="close" value="Close">
                <input type="submit" name="resend" value="Resend email">
            </div>
        </form>
    </div> 
</body>
<!--<script>
    const wrapper01 = document.querySelector(".wrapper01");
    const closebutton = document.getElementById("close");
        

    closebutton.addEventListener("click", function() {
        window.location.href = "login01.php";
    });
</script>
</html>