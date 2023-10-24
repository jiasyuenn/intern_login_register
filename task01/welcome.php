<?php 
//header('Location:login01.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .dialog {    
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #333;
            padding: 20px;
            text-align: center;
        }       

        #dialogMessage {
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div id="customDialog" class="dialog">
        <p id="dialogMessage">Your email is verified! You can login now!</p>
        <button onclick="closeDialog()">OK</button>
    </div>

<script>
    function closeDialog() {
        window.location.href='login01.php'; 
    }

</script>
    
</body>
</html>