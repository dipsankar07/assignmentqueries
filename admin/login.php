<?php

include("config.php");

session_start();
if(isset($_POST['button'])){
    $usern = $_POST['username'];
    $pwd = $_POST['password'];

    $query = "SELECT * FROM `admin` WHERE username = '$usern' && password = '$pwd' ";

    $data = mysqli_query($conn, $query);

    $total = mysqli_num_rows($data);

    if($total == 1){
        $_SESSION['user_name'] = $usern;
        header("Location:orders.php");
    }else{
        echo "<script type='text/javascript'> alert('Login Failed') </script>";
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="images/icon.jpeg" type="image/jpeg">
    <title>Login Assignment Queries</title>
</head>
<body>
    <div class="center">
        <form action="" method="post">
            <div class="column">
                <label for="username">username</label>
                <input type="text" name="username">
            </div>
            <div class="column">
                <label for="password">password</label>
                <input type="password" name="password">
            </div>
            <div class="forgote-pass" onclick="message()">Forgote your Password?</div>
            <div class="button-div">
                <button class="button" type="submit" name="button">Login</button>
            </div>
        </form>
    </div>

    <script>
        function message(){
            alert("Password Mone Kor Bal")
        }
    </script>

</body>
</html>