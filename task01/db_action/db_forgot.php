<?php

include '../db_action/sendOTP.php';
include '../db_action/db_connect.php';
session_start();


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