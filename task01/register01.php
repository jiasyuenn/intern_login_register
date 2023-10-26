<?php

    //to sent verification code to the email
    //import PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader?
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';
        

   include('config/db_connect.php'); //connect to database

    $username = $email = $password01 = $password02 =''; 
    $errors = array('username'=>'', 'email'=>'', 'password01'=>'', 'password02'=>''); //store error message

    //email content
    $subject = "Email Address Verification";
    $message = "Please click on this <a href=http://localhost/task01/welcome.php>link</a> to verify your email address!";


    if(isset($_POST['submit'])){
        //validate data
        if(empty($_POST['username'])){
            $errors['username'] = 'Please enter username !';
        }else{
            //more validation
            $username = $_POST['username'];
            if(!preg_match('/^[a-zA-Z0-9\s]+$/', $username)){
                $errors['username'] = 'Invalid username !';
            }
        }

        if(empty($_POST['email'])){
            $errors['email'] = 'Please enter email !';
        }else{
            $email = $_POST['email'];
            //echo $_POST['email'];
        }

        if(empty($_POST['password01'])){
            $errors['password01'] = 'Please enter password !';
        }else{
            // Check if the password is at least 8 characters long
            $password01 = $_POST['password01'];
            if (strlen($password01) < 8) {
                $errors['password01'] = 'Password minimum 8 characters ! ';
            }
        }

        if(empty($_POST['password02'])){
            $errors['password02'] = 'Please re-enter password !';
        }else{
            $password02 = $_POST['password02']; //?
        }

        // Compare password01 and password02
        if ($password01 !== $password02) {
            $errors['password02'] = 'Passwords not match!';
        } else {
            $password02 = $_POST['password02']; //?
        }

        //check errors
        if(array_filter($errors)){
            //echo 'error exist'; // do nothing
        }else{
            //read user input
            $username = mysqli_real_escape_string ($conn, $_POST['username']);
            $email = mysqli_real_escape_string ($conn, $_POST['email']);
            //$password01 = mysqli_real_escape_string ($conn, $_POST['password01']);
            $password02 = mysqli_real_escape_string ($conn, $_POST['password02']);

            //check if the username alr exists in db
            $usernameInDb = "SELECT * FROM users WHERE username = '$username'";
            $result_username = mysqli_query($conn, $usernameInDb);

            //check if email alr exist in db
            $emailInDb = "SELECT * FROM users WHERE email = '$email'";
            $result_email = mysqli_query($conn, $emailInDb);

            if (mysqli_num_rows($result_username) > 0){
                // Username alr exist
                $errors['username'] = 'Username is already in use !';
            } else if (mysqli_num_rows($result_email) > 0) {
                //email alr exist
                $errors['email'] = 'Email is already in use !';
            } else {
                //username & email not yet exist

                ##hashing##hashing##hashing##hashing##hashing##hashing##hashing##hashing##hashing##hashing##hashing##
                $hashed_password = password_hash($password02, PASSWORD_DEFAULT);

                //create sql
                $sql = "INSERT INTO users (username,email,password) VALUES('$username', '$email', '$hashed_password')";
            
                //save to database and check
                if(mysqli_query($conn, $sql)){
                   
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
                    $mail->addAddress($_POST['email']);
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body = $message;
                    if ($mail->send()) {
                        session_start();
                        //session to be used in welcome.php
                        $_SESSION['email01'] = $_POST['email'];

                        //session to be used in login01.php
                        $_SESSION['success'] = "Registration successful ! Please check your email !";

                        //success -> redirect
                        header('Location:login01.php');
                    } 
                    else {
                        echo 'Email could not be sent.' . $mail->ErrorInfo;
                    }
                    
                }else{
                    //error
                    echo 'query error ' . mysqli_error($conn);
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css01/Register01.css"> 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="register01.php" method="POST">
            <h4>Register</h4>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" value="<?php echo $username ?>">
                <i class='bx bx-user'></i>
                <div class="red-text"><?php echo $errors['username']; ?></div>
            </div>

            <div class="input-box">
                <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">
                <i class='bx bx-envelope'></i>
                <div class="red-text"><?php echo $errors['email']; ?></div>
            </div>

            <div class="input-box">
                <input type="password" name="password01" placeholder="Password" value="<?php echo $password01 ?>">
                <i class='bx bx-lock'></i>
                <div class="red-text"><?php echo $errors['password01']; ?></div>
            </div>

            <div class="input-box">
                <input type="password" name="password02" placeholder="Confirm password" value="<?php echo $password02 ?>">
                <i class='bx bx-lock'></i>
                <div class="red-text"><?php echo $errors['password02']; ?></div>
            </div>

            <div class="registerbtn">
                <input type="submit" name="submit" value="submit">
            </div>

            <div class="register">
                <p>Already have an account? <a href="login01.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>