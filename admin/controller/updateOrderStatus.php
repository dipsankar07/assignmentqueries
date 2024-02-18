<?php
session_start();
include('../config.php');
$id = $_GET['id'];

$sql = "SELECT status FROM `order` WHERE orderID = '$id'";
$result=$conn-> query($sql);
  //  echo $result;

$row=$result-> fetch_assoc();

if($row["status"]==0){
    $update = mysqli_query($conn,"UPDATE `order` SET status =1 where orderID='$id'");
}else if($row["status"]==1){
    $update = mysqli_query($conn,"UPDATE `order` SET status =0 where orderID='$id'");
}

if($update){
    echo "<script> alert('Change Success')</script>";
    header('Location:../orders.php');
  }
  else{
      echo"error";
  }
?>