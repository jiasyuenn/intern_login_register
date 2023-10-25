<!DOCTYPE html>
<html>
    <title>
        Change Password
    </title>
    <head>
        
    </head>

    <body>
        <form action="changePW.php" method="post">
            <h2>Enter Your New Password: </h>
            <input type="text" id="password" name="password" required>
            <br>
            <input type="submit" name="submit" value="Confirm">
        </form>
    </body>
</html>

<?php
session_start();
$email = $_SESSION['email'];

$host="localhost";
$username = "root";
$password = "";
$database = "db";

//connect to db, replace with actual username and password
$conn = new mysqli($host, $username, $password, $database);


$email = $_SESSION['email'];

if(isset($_POST['submit'])){
    $password = $_POST['password'];


    if (changePass($conn, $email, $password)) {
        $alertMessage = "Password Changed.";
        echo "<script>alert('$alertMessage'); window.location.href='/task01/login.php';</script>";
    }
    
    else{
        echo "Error";
    }
}

function changePass($conn, $email, $password){

    $sql = "UPDATE users SET password = '$password' WHERE email = '$email'";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }

    return true;

}

?>