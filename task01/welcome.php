<?php 
//header('Location:login01.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">\
    <link rel="stylesheet" href="css01/welcome.css">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <div>
            <p>Your email is verified! You can login now!</p>
        </div>

        <div>
            <button onclick="closeDialog()">OK</button>
        </div>
    </div>

<script>
    function closeDialog() {
        window.location.href='login01.php'; 
    }

</script>
    
</body>
</html>