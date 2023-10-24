<!DOCTYPE html>
<html>
    <title>
        OTP code
    </title>
    <head>
        
    </head>

    <body>
        <form action="otp.php" method="post">
            <h2>Enter the 6 digit OTP code</h>
            <input type="text" name="otp" maxlength="6" id="otp" pattern="\d{6}">
            <br>
            <input type="submit" name="submit" value="Confirm">
        </form>
    </body>
</html>

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
        #echo "OTP is valid.";
        header("Location: /task01/changePW.php"); 
    } else {
        $alertMessage = "Invalid OTP. Please try again.";
        echo "<script>alert('$alertMessage');</script>";
    }

}

?>