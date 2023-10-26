
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP code</title>
    <link rel="stylesheet" href="css/otp.css"> 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
    <body>
        <div class="wrapper">
            <form action="db_action/db_otp.php" method="post">
                <h2>Enter the 6 digit OTP code</h2>

                <div class="input-box">
                    <input type="text" name="otp" maxlength="6" id="otp" pattern="\d{6}" placeholder="OTP code">
                </div>

                <div class="loginbtn">
                    <input type="submit" name="submit" value="Confirm">
                </div>

                <div class="loginbtn">
                    <input type="submit" name="resubmit" value="Re-send OTP">
                </div>

                <?php

                    //Retrieves flag from DBopt.php, (valid=false), means OTP not verified, display message. Reset flag
                    session_start();
                    if (isset($_SESSION['valid']) && $_SESSION['valid'] === false){
                        echo '<p class="error-message">Invalid OTP. Please try again.</p>';
                        $_SESSION['valid'] = null;
                    }
                ?>

            </form>
        </div>
    </body>
</html>