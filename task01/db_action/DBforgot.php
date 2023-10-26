<?php

include '../db_action/sendOTP.php';
//include 'conn.php'; // call database configure
//mysqli_set_charset($conn, 'utf8');
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "db";

//connect to db, replace with actual username and password
$conn = new mysqli($host, $username, $password, $database);


if (isset($_POST['submit'])){
    $email = $_POST['email'];

    //retrieve the email from previous page
    $_SESSION['email'] = $email;

    //checks if email is registered in db
    if (findEmail($conn, $email)){
        if (generateOTP($conn, $email)){

            //valid=true, passes to otp.php
            $_SESSION['valid'] = true;

            #####ignore $_SESSION['email-exists'] = true;
            header("Location: /task01/otp.php"); 

        }
    
        else{

            //Invalid email. valid=false, passes to forgot.php, redirects to forgot.php
            $_SESSION['valid'] = false;
            header("Location: /task01/forgot.php"); 
        }
    }
    
    else{

        //Invalid email. valid=false, passes to forgot.php, redirects to forgot.php
        $_SESSION['valid'] = false;
        header("Location: /task01/forgot.php"); 
    }
    
    $conn->close();
}

?>