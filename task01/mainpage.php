<?php 

    if(isset($_POST["logout"])){
        header("Location:login.php");
    }else{
        echo "";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/mainpage.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="mainpage.php" method="post">
            <div class="input-box">
                <h4>Hello World !</h4>
                <input type="submit" name="logout" value="Log out" >
            </div>
        </form>
    </div>
</body>
</html>