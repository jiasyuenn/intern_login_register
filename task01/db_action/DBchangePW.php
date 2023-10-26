<?php
session_start();

$host="localhost";
$username = "root";
$password = "";
$database = "db";

//connect to db
$conn = new mysqli($host, $username, $password, $database);

//session management. Prevent accessing the changePW.php and changing password on demand. Execute if otp_verified == false, redirects to otp.php page
if (!isset($_SESSION['otp_verified'])) {
    header("Location: /task01/otp.php");
    exit;
}

//retrieves email from previous page
$email = $_SESSION['email'];

if(isset($_POST['submit'])){
    $password = $_POST['password'];

    if (strlen($password) < 8) {
        $alertMessage = "Password must be at least 8 characters long.";
        echo "<script>alert('$alertMessage'); window.location.href='/task01/changePW.php';</script>";
        exit;
    }

    //password changed successfully
    if (changePass($conn, $email, $password)) {
        $alertMessage = "Password Changed.";

        //remove flag so that it wont interfere the next password reset process
        unset($_SESSION['otp_verified']);
        echo "<script>alert('$alertMessage'); window.location.href='/task01/login01.php';</script>";
        
    }
    
    else{
        echo "Error";
    }
}

function changePass($conn, $email, $password){

    //password hashing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //update password
    $sql = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

?>