<?php

include('config.php');

$id = $_GET['id'];

$query = "DELETE FROM `contact` WHERE ID = '$id' ";
$data = mysqli_query($conn, $query);

if($data){
    echo "<script> alert('Support Deleted')</script>";
    header('Location:support.php');
}else{
    echo "Some Thing Wrong";
}
?>