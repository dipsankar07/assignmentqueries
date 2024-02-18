<?php

    include_once "../config.php";

    session_start();
    $id = $_GET['id'];
    //echo $order_id;
    $sql = "SELECT pay_status from `order` where orderID='$id'"; 
    $result=$conn-> query($sql);
  //  echo $result;

    $row=$result-> fetch_assoc();
    
  //  echo $row["pay_status"];
    
    if($row["pay_status"]==0){
         $update = mysqli_query($conn,"UPDATE `order` SET pay_status =1 where orderID='$id'");
    }
    else if($row["pay_status"]==1){
         $update = mysqli_query($conn,"UPDATE `order` SET pay_status =0 where orderID='$id'");
    }
    
        
 
    if($update){
      echo "<script> alert('Change Success')</script>";
      header('Location:../orders.php');
    }
    else{
        echo"error";
    }
    
?>