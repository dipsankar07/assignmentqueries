<?php

include('config.php');

$id = $_GET['id'];

$query = "DELETE FROM `order` WHERE orderID = '$id' ";
$data = mysqli_query($conn, $query);

if($data){
    echo "<script> alert('Order Deleted')</script>";
    header('Location:orders.php');
}else{
    echo "Some Thing Wrong";
}
?>