<?php
include('config.php');
session_start();

// $id = $_GET['orderID'];

$userprofile = $_SESSION['user_name'];

if($userprofile == true){
    $query = "SELECT * FROM `order` ORDER BY  id DESC";
$data = mysqli_query($conn, $query);

error_reporting(0);

$total = mysqli_num_rows($data);
?>
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
    <link rel="stylesheet" href="style/orders.css">
    <title>Order Details</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <img src="images/assignmentqueries logo2 (1).png" alt="" class="logo-img">
            </div>
            <ul>
                <li><a href="">HOME</a></li>
                <li> <a href="" class="active">ORDERS</a> </li>
                <li> <a href="support.php">SUPPORTS</a> </li>
                <li> <a href="">NOTICE</a> </li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="main">
        <div class="head-section">
          <h1>Order Details</h1> 
          <!-- <p><?php echo "WelCome ".$_SESSION['user_name']; ?></p> -->
          <div class="search">
            <input class="search_box" name="search" type="text" placeholder="search">
            <button class="search_btn btn-sm" name="search">Search</button>
          </div>
        </div>
        <div class="center-div">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Price</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                
                    while ($result = mysqli_fetch_assoc($data)) {
                    $orderID = $result['orderID'];    
                    ?>    
                        <tr>
                            <td><?php echo $result["ID"]?></td>
                            <td><?php echo $result["orderID"] ?></td>
                            <td><?php echo $result["Fname"]?></td>
                            <td><?php echo $result["number"]?></td>
                            <td><?php echo $result["email"]?></td>
                            <td><?php echo $result["subject"]?></td>
                            <td><a href="controller/message-price-update.php?id=<?=$result['orderID']?>" onclick="return PriceChange()" class="btn btn-primary openPopup">View</a></td>
                            <td><?php echo $result["price"] ?>/-</td>
                            <?php
                                if($result["pay_status"]==0){
                            ?>
                                <td><a onclick="return ChangePayStatus()" class="btn btn-danger" href="controller/updatePayStatus.php?id=<?=$result['orderID']?>">UnPaid</a></td>        
                            <?php    
                            }else{
                            ?>
                                <td><a class="btn btn-success" onclick="return ChangePayStatus()" href="controller/updatePayStatus.php?id=<?=$result['orderID']?>">Paid</a></td>
                            <?php
                            };
                            
                            if($result["status"]==0){
                            ?>
                                <td><a class="btn btn-danger" onclick="return ChangeOrderStatus()" href="controller/updateOrderStatus.php?id=<?=$result['orderID']?>"> Pending</a></td>    
                            <?php
                            }else{
                            ?>
                                <td><a class="btn btn-success" onclick="return ChangeOrderStatus()" href="controller/updateOrderStatus.php?id=<?=$result['orderID']?>"> Delivered</a></td>    
                            <?php
                            }
                            ?>
                            <td class="delete"><a href="delete.php?id=<?=$result['orderID']?>"><i class="fa-solid fa-trash" onclick="return checkdelete()"></i></a></td>
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

    <!-- JAVASCRIPT -->

    <script>
        function checkdelete(){
            return confirm('Are You Sure You Want To Delete This Record?');
        }

        function ChangePayStatus(){
            return confirm('Are You Sure You Want To Change?')
        }
        function ChangeOrderStatus(){
            return confirm('Are You Sure You Want To Change?')
        }
        function PriceChange(){
            return confirm('Are You Sure You Want To Change')
        }
    </script>    

</body>


</html>