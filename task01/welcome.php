<?php 
    
    include('config/db_connect.php'); //connect to database

    if(isset($_POST['submit'])){
        session_start();
        $status = 'verified';

        if (isset($_SESSION['email01'])) {
            
            $email = $_SESSION['email01'];

            $sql = "UPDATE users SET status = '$status' WHERE email = '$email'";

            if (mysqli_query($conn, $sql)) {
                // Status updated successfully
                header('Location: login01.php');
            } else {
                // Error updating the status
                echo "Error updating status:" . mysqli_error($conn);
            }
        }else{
            echo "<script>alert('not ok');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">\
    <link rel="stylesheet" href="css01/Welcome.css">
</head>
<body>
    <div class="wrapper">
        <form action="welcome.php" method="POST">
            <div>
                <p>Your email is verified! You can login now!</p>
            </div>

            <div>
                <input type="submit" name="submit" value="submit">
            </div>
        </form>
    </div> 
</body>
</html>