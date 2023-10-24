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
    $errors = array('username'=>'', 'email'=>'', 'password01'=>'', 'password02'=>'');
    $subject = "Email Address Verification";
    $message = "Please click on this <a href=http://localhost/task01/welcome.php>link</a> to verify your email address!";

    if(isset($_POST['submit'])){
        //validate data
        if(empty($_POST['username'])){
            $errors['username'] = 'Please enter username';
        }else{
            //more validation
            $username = $_POST['username'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $username)){
                $errors['username'] = 'Invalid username';
            }
        }

        if(empty($_POST['email'])){
            $errors['email'] = 'Please enter email';
        }else{
            $email = $_POST['email'];
            //echo $_POST['email'];
        }

        if(empty($_POST['password01'])){
            $errors['password01'] = 'Please enter password';
        }else{
            $password01 = $_POST['password01'];
            //echo $_POST['password01'];

            // Check if the password is at least 8 characters long
            if (strlen($password01) < 8) {
                $errors['password01'] = 'Password minimum 8 characters! ';
            }
        }

        if(empty($_POST['password02'])){
            $errors['password02'] = 'Please re-enter password';
        }else{
            $password02 = $_POST['password02'];
            //echo $_POST['password02'];
        }

        // Compare password01 and password02
        if ($password01 !== $password02) {
            $errors['password02'] = 'Passwords do not match!';
        } else {
            $password02 = $_POST['password02'];
        }

        //check errors
        if(array_filter($errors)){
            //echo 'error exist'; // do nothing
        }else{
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
                $errors['username'] = 'Username is already in use!';
            } else if (mysqli_num_rows($result_email) > 0) {
                //email alr exist
                $errors['email'] = 'Email is already in use!';
            } else {
                //username not yet exist
                //create sql
                $sql = "INSERT INTO users (username,email,password) VALUES('$username', '$email', '$password02')";
            
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
                        //success -> redirect
                
                        //code here? to display success message in login.php
                        session_start();

                        $_SESSION['success'] = "Registration successful! Please check your email.";

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
            //echo 'form valid';
            //header('Location:welcome.php');
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!--<style>
        body {
            background-color: #3c5077;
        }

        .container {
            width: 350px;
            height: 400px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #333;
            padding: 20px;
            border-radius: 3px;
            text-align: center;
        }

        .red-text {
            color: red;
            margin-left: 100px;
        }
        
        .form-field input[type="text"] {
            width: 20%;
            padding: 5px;
            margin-left: 20px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form-field input[type="email"]{
            width: 20%;
            padding: 5px;
            margin-left: 46px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .form-field input[type="password"]{
            width: 20%;
            padding: 5px;
            margin-left: 23px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .btn{
            padding: 10px 40px;
            background: #fff;
            border: 0;
            outline: none;
            cursor: pointer;
            font-size: 22px;
            font-weight: 500;
            border-radius: 50px;
            border: 1px solid #333;
        }
    </style> -->
</head>
<body>
    <section class="container">
        <h4 class="center">Register</h4>
        <form action="register01.php" method="POST">
            <div class="form-field">
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo $username ?>">
                <div class="red-text"><?php echo $errors['username']; ?></div>
            </div>

            <div class="form-field">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $email ?>">
                <div class="red-text"><?php echo $errors['email']; ?></div>
            </div>

                <div class="form-field">
                <label>Password:</label>
                <input type="password" name="password01" value="<?php echo $password01 ?>">
                <div class="red-text"><?php echo $errors['password01']; ?></div>
            </div>

            <div class="form-field">
                <label>Re-enter password:</label>
                <input type="password" name="password02" value="<?php echo $password02 ?>">
                <div class="red-text"><?php echo $errors['password02']; ?></div>
            </div>

            <input class="btn" type="submit" name="submit" value="submit">
            <p><a href="login01.php">Back to Login</a></p>
        </form>

    </section>
</body>
</html>