<?php
session_start();
include('config.php');

// Pay payment mode

// $MERCHANT_KEY = "gtKFFx";
// $SALT = "eCwWELxi";

$MERCHANT_KEY = "SIm4xe";
$SALT = "eXf8xJt5ifvM6pl2yjKW2vSxnP4ugES0";

// Merchant Key and Salt as provided by Payu.

// $PAYU_BASE_URL = "https://test.payu.in";		// For Sandbox Mode
$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
// $hashSequence = "key|txnid|amount|productinfo|firstname|email|||||||||||SALT";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['productinfo'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} 
elseif(!empty($posted['hash'])) 
{
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}

// include_once "config.php";

if (isset($_POST['trackbutton'])) {

    $orderID = $_POST["orderID"];
    $query = mysqli_query($conn, "SELECT * FROM `order` WHERE orderID='$orderID'  OR number='$orderID' ");
    $rowcount = mysqli_fetch_array($query);

    if (is_array($rowcount)) {

        $_SESSION["orderID"] = $rowcount['orderID'];
        // $_SESSION["firstname"] = $rowcount['Fname'];
        // header("Location:../pages/order-status.html");

    } else {
        //echo '<script type="text/javascript"> alert("No Order Found") </script>';
        echo "<script> window.location.replace('../pages/error-page.html')</script>";
    }
}

// track form order done page

if (isset($_POST['track-order-btn'])) {

    $orderID = $_POST["orderID"];
    $query = mysqli_query($conn, "SELECT * FROM `order` WHERE orderID='$orderID'  OR number='$orderID' ");
    $rowcount = mysqli_fetch_array($query);

    if (is_array($rowcount)) {

        $_SESSION["orderID"] = $rowcount['orderID'];
        // $_SESSION["firstname"] = $rowcount['Fname'];
        // header("Location:../pages/order-status.html");

    } else {
        //echo '<script type="text/javascript"> alert("No Order Found") </script>';
        echo "<script> window.location.replace('../pages/error-page.html')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Pay U -->

    <script>
        var hash = '<?php echo $hash ?>';
        function submitPayuForm() {
          if(hash == '') {
            return;
          }
          var payuForm = document.forms.payuForm;
          payuForm.submit();
        }
    </script>

    

    <script src="https://kit.fontawesome.com/20e9fb8744.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/order-status.css">
    <title>Order Status</title>
</head>

<body>

        <!-- <?php if($formError) { ?>
		    <tr><td><span style="color:red">Please fill all mandatory fields.</span></td></tr>
		    <br/>
		    <br/>
		<?php } ?> -->

    <!-- nav bar -->
    <header>
        <nav>
        <div><a href="https://assignmentqueries.com"><img class="logo" src="../images/assignmentqueries logo.png" alt=""></a></div>
            <input type="checkbox" id="click" class="checkbox">
            <label for="click" class="menu-btn">
                <i class="fas fa-bars"></i>
            </label>
            <ul>
                <li><a class="active" href="https://assignmentqueries.com/">Home</a></li>
                <li><a href="https://assignmentqueries.com#services-section">Services</a></li>
                <li><a href="https://blog.assignmentqueries.com">Blogs</a></li>
                <li><a href="https://assignmentqueries.com">New Order</a></li>
                <li><a href="../pages/contact.html">Contact US</a></li>
            </ul>
        </nav>
    </header>

    <main>

        <?php
        $orderID = $_SESSION["orderID"];
        $query = mysqli_query($conn, "SELECT * FROM `order` WHERE orderID='$orderID' ");
        $row = mysqli_fetch_array($query);


        ?>

        <div class="container">

            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Deliver Date</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th>Payment</th>
                        <th>Download Assignment</th>
                        </tr>
                </thead> 
                <tbody>
                    <tr>
                        <td data-lable="Name"><?php echo $row["Fname"] ?></td>
                        <td data-lable="Order ID"><?php echo $row["orderID"] ?></td>
                        <td data-lable="Order Date"><?php echo $row["orderdate"] ?></td>
                        <td data-lable="Deliver Date"><?php echo $row["date"] ?></td>
                        <td data-lable="Status"><?php if($row["status"]==0) {echo "Pending";} else if($row["status"] == 1){ echo "Complete";}else{ echo "Delivered";} ?></td>
                        <td data-lable="Price"><?php echo $row["price"]?>/-</td>
                        <td data-lable="Payment">
                            <?php
                                if( $row["pay_status"]==0){
                            ?>
                            
                            <form action="<?php echo $action; ?>" method="post" name="payuForm">
                            <!-- <input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" /> -->
		                    <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
		                    <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
		                    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                            <input type="hidden" class="form-group" name="firstname" readonly="readonly" id="firstname" value="<?php echo $row["Fname"] ?>" />
                            <input type="hidden" class="form-group" name="email" readonly="readonly" id="email" value="<?php  echo $row["email"] ?>" />
                            <input type="hidden" name="serial" id="serial" value="<?php  echo $_SESSION["orderID"] ?>" />
                            <input type="hidden" class="form-group"  name="phone" readonly="readonly" value="<?php echo $row["number"] ?>" />
                            <input type="hidden" class="form-group" name="amount" readonly="readonly" value="<?php echo $row["price"] ?>" />
                            <input type="hidden" name="serial" value="serial_no"/>
                            <input type="hidden" name="productinfo" value="admission_form"/>
                            <input type="hidden" name="surl" value="http://192.168.0.105/business/cMethod/payment-success.php" size="64" />
                            <input type="hidden" name="furl" value="http://192.168.0.105/business/cMethod/payment-failed.php" size="64" />
                            <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
                            <input type="submit" value="Pay Now" class="pay-button">
                            </from>
                            
                            <?php
                                }else{echo "Done";}
                            ?> 
                        </td>
                        <?php
                        $deliver = 'delivery/'.$row["orderID"];
                         if($row["pay_status"]==0){
                        ?>
                            <td>Please Pay The Amount</td>
                        <?php
                        }else{
                        ?>
                            <td><a download="<?php echo 'assignmentqueries.com'; ?>" href="../delivery/<?php echo $row['orderID'].'.pdf' ?>">Download</a></td>
                        <?php
                        }
                        ?>
                    </tr>
                </tbody>   
                
                
            </table>

        </div>
        <!-- Worning Message Section -->
        <div class="second-section">
            <div class="worning">
                <p class="worning-p-tag">If you have any issue regurding your Order you can contact us, by calling +91 9382820793</p>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-row">
                <div class="footer-col">
                    <h4>company</h4>
                    <ul>
                        <li><a href="../pages/about-us.html">about us</a></li>
                        <li><a href="https://assignmentqueries.com#services-section">our services</a></li>
                        <li><a href="../pages/privacy-policy.html">privacy policy</a></li>
                        <li><a href="../pages/terms-and-conditions.html">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>get help</h4>
                    <ul>
                        <li><a href="../pages/faqs.html">FAQ</a></li>
                        <!-- <li><a href="#">Delhivery</a></li> -->
                        <li><a href="../pages/rewrite-refund-policy.html">returns & Refund policy</a></li>
                        <li><a href="../pages/order-track.html">order status</a></li>
                        <!-- <li><a href="#">payment options</a></li> -->
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Payment Options</h4>
                    <ul>
                        <li><a href="#">Paypal</a></li>
                        <li><a href="#">Upay</a></li>
                        <!-- <li><a href="#">shoes</a></li>
                <li><a href="#">dress</a></li> -->
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
      var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
      (function () {
        var s1 = document.createElement("script"),
          s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = "https://embed.tawk.to/636e7207daff0e1306d6f34a/1ghjmqrsa";
        s1.charset = "UTF-8";
        s1.setAttribute("crossorigin", "*");
        s0.parentNode.insertBefore(s1, s0);
      })();
    </script>
    <!--End of Tawk.to Script-->

</body>

</html>