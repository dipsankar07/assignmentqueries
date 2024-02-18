<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/icon.jpeg" type="image/jpeg">
    <script src="https://kit.fontawesome.com/20e9fb8744.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/support.css">
    <title>Contact Details</title>
</head>

<body>
<header>
        <nav>
            <div class="logo">
                <img src="images/assignmentqueries logo2 (1).png" alt="" class="logo-img">
            </div>
            <ul>
                <li><a href="orders.php">HOME</a></li>
                <li> <a href="orders.php">ORDERS</a> </li>
                <li> <a href="support.php" class="active">SUPPORTS</a> </li>
                <li> <a href="">NOTICE</a> </li>
            </ul>
        </nav>
    </header>
    <div class="main">
        <h1>Contact Support</h1>
        <div class="center-div">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Reply</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('config.php');
                    session_start();

                    $userprofile = $_SESSION['user_name'];

                    if($userprofile == true){
                        $query = "SELECT * FROM contact ORDER BY id DESC";
                    $data = mysqli_query($conn, $query);

                    error_reporting(0);

                    $total = mysqli_num_rows($data);


                    while ($result = mysqli_fetch_assoc($data)) {
                        $ID = $result['ID'];
                    ?>    
                        <tr>
                            <td><?php echo $result["ID"]?></td>
                            <td><?php echo $result["name"]?></td>
                            <td><?php echo $result["number"]?></td>
                            <td><?php echo $result["email"]?></td>
                            <td><?php echo $result["subject"]?></td>
                            <td><?php echo $result["massage"]?></td>
                            <td><i class="fa-solid fa-reply"></i></td>
                            <td><a href="delete-support.php?id=<?=$result["ID"]?>"><i class="fa-solid fa-trash" onclick="return checkdelete()"></i></a></td>
                        </tr>
                    <?php
                    
                    }
                    }else{
                        header('Location:login.php');
                    }

                    

                    ?>
                   
                    
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function checkdelete(){
            return confirm('Are You Sure You Want To Delete This Record?');
        }
    </script>
</body>

</html>