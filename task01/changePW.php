<?php
    session_start();

    //session management. Prevent accessing the changePW.php and changing password on demand. Execute if otp_verified == false, redirects to otp.php page
    if (!isset($_SESSION['otp_verified'])) {
        $alertMessage = "Session expired. Please enter the OTP again.";
        echo "<script>alert('$alertMessage'); window.location.href='/task01/otp.php';</script>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="css/otp.css"> 
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    

    
    </head>

    <body>
        <div class="wrapper">
            <form action="db_action/db_changePW.php" method="post" onsubmit="return validatePassword();">
                <h2>Enter Your New Password: </h>
                <div class="input-box">
                    <input type="password" id="password" name="password" required>
                </div>

               

                <div class="loginbtn">
                    <input type="submit" name="submit" value="Confirm">
                </div>
            </form>
        </div>
    </body>
</html>