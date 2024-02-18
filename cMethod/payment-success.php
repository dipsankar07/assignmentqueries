<?php
session_start();
// db connection
include('config.php');
// payu payment
$status = $_POST["status"];
$firstname = $_POST["firstname"];
$amount = $_POST["amount"];
$txnid = $_POST["txnid"];
$posted_hash = $_POST["hash"];
$key = $_POST["key"];
$productinfo = $_POST["productinfo"];
$email = $_POST["email"];
$salt = "eXf8xJt5ifvM6pl2yjKW2vSxnP4ugES0";

// my code to change pay_status

$orderID = $_SESSION["orderID"];
$query = mysqli_query($conn, "SELECT * FROM `order` WHERE orderID='$orderID' ");
$row = mysqli_fetch_array($query);



if (isset($_POST["additionalCharges"])) {
  $additionalCharges = $_POST["additionalCharges"];
  $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
} else {
  $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
}
$hash = hash("sha512", $retHashSeq);
if ($hash != $posted_hash) {

  $InvalidMsg = "Invalid Transaction. Please try again";
} else {
  $SuccessMsg  = "Thank You. Your order status is $status ";
  $SuccesstxnidMsg = "Your Transaction ID for this transaction is $txnid ";
  $SuccessAmountMsg = "We have received a payment of Rs  $amount  Please go back and download your assignment.";


  // changing pay_status position

  if ($row["pay_status"] == 0) {
    $update = mysqli_query($conn, "UPDATE `order` SET pay_status=1 where orderID='$orderID'");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="../styles/payment-status.css">
  <title>Payment Success</title>
</head>

<body>
<div class="container">
   <div class="row">
      <div class="col-md-6 mx-auto mt-5">
         <div class="payment">
            <div class="payment_header">
               <div class="check"><i class="fa fa-check" aria-hidden="true"></i></div>
            </div>
            <div class="content">
               <h1>Payment Success !</h1>
               <p> <?php echo $SuccesstxnidMsg, $SuccessAmountMsg; ?> </p>
               <a href="https://assignmentqueries.com/pages/order-track.html">Go to Home</a>
            </div>
            
         </div>
      </div>
   </div>
</div>
</body>

</html>