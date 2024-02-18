<?php

include('config.php');
error_reporting(0);

if (isset($_POST['oderbutton'])) {

    
    $Fname = $_POST['Fname'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $order_date = date('Y-m-d H:i:s');
    $date = $_POST['date'];
    $number = $_POST['number'];
    $university = $_POST['university'];
    $description = $_POST['description'];
    $referral_code = strtoupper(bin2hex(random_bytes(4)));
    // $file = addslashes(file_get_contents($_FILES["file"]["tmp_name"]));
    // $file = $_FILES['file'];
    $folder = "../orders";
    $file = $number."-".$_FILES["file"]["name"];
    $tname = $_FILES["file"]["tmp_name"];

    move_uploaded_file($tname, $folder.'/'.$file);
    // check order id

    $checkuid = "SELECT * FROM `order` ORDER BY id DESC LIMIT 1";
    $checkresult = mysqli_query($conn, $checkuid);
    if (mysqli_num_rows($checkresult) > 0) {
        if ($row = mysqli_fetch_assoc($checkresult)) {
            $uid = $row['orderID'];
            $get_numbers = str_replace("SR", "", $uid);
            $id_increase = $get_numbers + 1;
            $get_string = str_pad($id_increase, 5, 0, STR_PAD_LEFT);
            $id = "SR" . $get_string;

            $query = "INSERT INTO  `order`(`orderID`,`Fname`, `email`, `subject`, `orderdate`, `date`, `number`, `university`, `description`, `referral`, `file`, `status`, `pay_status`) VALUES ('$id','$Fname', '$email', '$subject', '$order_date', '$date', '$number', '$university', '$description', '$referral_code','$file', '0', '0')";
            $query_run = mysqli_query($conn, $query);
            move_uploaded_file($file ,$folder);

            if ($query_run) {
                echo '<script type="text/javascript"> alert("Order Placed") </script>';

                // $query = "INSERT INTO `referral_details`(`referral_code`, `refer`,`referrer`) VALUES ('$referral_code', '$Fname', `0`)";
                // $query_run = mysqli_query($conn, $query);

                $to = "admin@assignmentqueries.com";
                $subject = "New Order";
                $txt = "Name = " . $Fname . "\r\n Number = " . $number . "\r\n  Email = " . $email . "\r\n Subject =" . $subject . "\r\n Message =" . $description;
                $headers = "From: noreply@assignmentqueries.com" . "\r\n" .
                    "CC: assignmentqueries1@gmail.com";
                if ($email != NULL) {
                    mail($to, $subject, $txt, $headers);
                }
                // header('Location:../pages/order-done.html');
            } else {
                echo '<script type="text/javascript"> alert("Failed") </script>';

                header('Location:../pages/order-failed.html');
            }
        }
    } else {

        $id = "SR00001";
        $query = "INSERT INTO  `order`(`orderID`,`Fname`, `email`, `subject`, `date`, `number`, `university`, `description`, `referral`, `file` `status`) VALUES ('$id','$Fname', '$email', '$subject', '$date', '$number', '$university', '$description', '$referral_code', '$file', 'Pending')";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo '<script type="text/javascript"> alert("Order Placed") </script>';

            // header('Location:../pages/order-done.html');
        } else {
            echo '<script type="text/javascript"> alert("Failed") </script>';

            header('Location:../pages/order-failed.html');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://kit.fontawesome.com/20e9fb8744.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/order-success.css">
    <link rel="stylesheet" href="../styles/media-query-order.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful</title>
</head>

<body>

    <header>
        <nav>
            <div class="logo">Assignment</div>
            <input type="checkbox" id="click" class="checkbox">
            <label for="click" class="menu-btn">
                <i class="fas fa-bars"></i>
            </label>
            <ul>
                <li><a class="active" href="https://assignmentqueries.com/">Home</a></li>
                <li><a href="#services-section">Services</a></li>
                <li><a href="#section-heading-long">Blogs</a></li>
                <li><a class="track-order" href="../pages/order-track.html">Track Order</a></li>
                <li><a href="../pages/contact.html">Contact US</a></li>
            </ul>
        </nav>
    </header>

    <?php

    $query = mysqli_query($conn, "SELECT * FROM `order` WHERE Fname='$Fname' ");
    $row = mysqli_fetch_array($query);

    ?>
    <main>
        <div class="upper-container">
            <div class="card">
                <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
                    <i class="checkmark">&#10004;</i>
                </div>
                <h1>Order Successful</h1>
                <p>We received your Assignment request; we'll be in touch shortly!</p>
                <p>Your order ID is <span class="order-id" id="orderId">
                        <p class="order-id" id="orderIdP"><?php echo $row["orderID"]; ?></p>
                    </span> Please note your order ID</p>
                <p>You can start chatting with our team on live chat. Or call <span class="help-line-number">9382820793</span></p>
                <div class="track-oder-div">
                    <form action="track-order.php" method="POST">
                        <input type="hidden" class="input" type="text" name="orderID" id="orderID" value="<?php echo $row["orderID"]; ?>" >
                        <button class="track-order-btn" type="submit" name="track-order-btn">Track Order</button>
                    </form>
                    
                </div>
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
                        <li><a href="#services-section">our services</a></li>
                        <li><a href="../pages/privacy-policy.html">privacy policy</a></li>
                        <li><a href="../pages/terms-and-conditions.html">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>get help</h4>
                    <ul>
                        <li><a href="../pages/faqs.html">FAQ</a></li>
                        <li><a href="#">Delhivery</a></li>
                        <li><a href="#">returns</a></li>
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

</body>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/636e7207daff0e1306d6f34a/1ghjmqrsa';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->

<!-- <script type="text/javascript">

    const orderId = document.getElementById("orderId");
    const orderIdP = document.getElementById("orderIdP");

    orderId.onclick = function(){

      orderId.select();

      document.execCommand("Copy");
    }

  </script> -->

</html>