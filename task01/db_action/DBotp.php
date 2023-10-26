<?php
session_start();

$host="localhost";
$username = "root";
$password = "";
$database = "db";

//connect to db, replace with actual username and password
$conn = new mysqli($host, $username, $password, $database);

$email = $_SESSION['email'];

if(isset($_POST['submit'])){
    $_SESSION['email'] = $email;
    $otp= $_POST['otp'];
    verifyOTP($conn, $email, $otp);
}

function verifyOTP($conn, $email, $otp){

    $sql = "SELECT * FROM users WHERE email = '$email' AND otp = '$otp'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        //otp_verified = true (session management)
        $_SESSION['otp_verified'] = true;
        header("Location: /task01/changePW.php"); 
    } else {

        //OTP not verified (valid=false), redirects to otp.php again
        $_SESSION['valid'] = false;
        header("Location: /task01/otp.php"); 
    }

}

?>