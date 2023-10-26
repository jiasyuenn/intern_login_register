<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="css/forgot.css"> 
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>
        <div class="wrapper">
            <form action="db_action/db_forgot.php" method="post">
                <h4>Reset Password</h4>
                <div class="input-box">
                    <input type="text" id="email" name="email" placeholder="Email" required>
                    <i class='bx bx-envelope'></i>
                </div>

                <div class="loginbtn">
                    <input type="submit" name="submit" value="Send Email">
                </div>

                <?php
                    session_start();

                    //Retrieves valid flag from DBforgot, (valid=false), means invalid email, display error message
                    if (isset($_SESSION['valid']) && $_SESSION['valid'] === false){
                        echo '<p class="error-message">Email could not be sent. Invalid Email.</p>';
                        $_SESSION['valid'] = null; // Reset flag
                    }
                ?>

                <div class="register">
                    <p>Don't have an account? <a href="register.php"> Sign in </a></p>
                </div>        
            </form>
        <div>
    </body>
</html>

