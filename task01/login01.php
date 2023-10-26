<?php
session_start(); 
//session_start();   
$verify="";
$credential="";
//checks if http request is post (submit form)
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $host="localhost";
    $username = "root";
    $password = "";
    $database = "db";

    //connect to db, replace with actual username and password
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    #retrieves username and password from html login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    //session to be used in unverified.php
    $_SESSION['un'] = $_POST['username'];

    #find the user in db
    $sql = "SELECT * FROM users WHERE username='$username'";

    #execute sql and store in result
    $result = $conn -> query($sql);

    if($result -> num_rows > 0){
        while($row=$result->fetch_assoc())
        {
            $status = $row['status'];
            $username = $row['username'];
            $stored_hash = $row['password'];
        }

        //compare user entered password and hashed password using password_verify function
        if (password_verify($password, $stored_hash)){
            if($status == "unverified"){
                $verify="none";
            }

            else{
                header("location: mainpage.php");
            }
        }
    
    }else{
        $credential ='none';
    }


    $conn->close();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Form</title>
        <link rel="stylesheet" href="css01/login01.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>
        <div class="wrapper">
            <form action="login01.php" method="post">
                <h4>Login</h4>
                <?php
                    if (isset($_SESSION['success'])) {
                        echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
                        unset($_SESSION['success']); // Remove the success message from the session
                    }
                ?>
                   
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required>
                    <i class='bx bx-user'></i>
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bx-lock'></i>
                </div>

                <div class="forgot">
                    <label><input type="checkbox">  Remember me  </label>
                    <a href="forgot.php">Forget password?</a>
                </div>
                
                <div class="loginbtn">
                    <input type="submit" value="Login">
                </div>

                <div class="register">
                    <p>Don't have an account? <a href="register01.php"> Register </a></p>
                </div>

                <?php
                    if($verify == "none"){
                        header('Location:unverified.php');
                    }else{
                        echo "";
                    }

                    if($credential == "none"){
                        echo '<div class="red-text" >Username or password incorrect! Please try again !</div>';
                    }else{
                        echo '';
                    }
                ?>



            </form>
        </div>
        
        
    </body>
    
</html>


