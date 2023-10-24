<?php
session_start();
?>

<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Form</title>
        <style>
            .success-message {
                color: red;
            }

        </style>
    </head>

    <body>
        <h4>Login</h4>
        <form action="login01.php" method="post">
            <table>
                <?php
                    if (isset($_SESSION['success'])) {
                        echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
                        unset($_SESSION['success']); // Remove the success message from the session
                    }
                ?>
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input type="text" id="username" name="username" required></td>
                </tr>

                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="text" id="password" name="password" required></br></td>
                </tr>
            </table>
            <br>
            <input type="submit" value="Submit">
            <input type="submit" value="Forgot Password">
            <input type="submit" value="Register">
        </form>
    </body>
</html>


<?php  
//session_start();   //start of php


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

    #find the user in db
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    
    #execute sql and store in result
    $result = $conn -> query($sql);

    if($result -> num_rows == 1){
        header("location: welcome.php");
    }

    else
        #$login_error = "Login failed. Please enter the correct login credentials.";

        $alertMessage = "Login failed. Please enter the correct login credentials.";
        echo "<script>alert('$alertMessage');</script>";

    $conn->close();
}

?>