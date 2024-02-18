<?php

include('config.php');

if (isset($_POST['contactbutton'])) {

    $name = $_POST['Name'];
    $phone = $_POST['Phone'];
    $email = $_POST['Email'];
    $subject = $_POST['Subject'];
    $message = $_POST['Massage'];

    $query = "INSERT INTO `contact` (`name`, `number`, `email`, `subject`, `massage`) VALUES ('$name', '$phone', '$email', '$subject', '$message');";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $to = "admin@assignmentqueries.com";
        $subject = "Mail From website";
        $txt = "Name = " . $name . "\r\n Number = " . $phone. "\r\n  Email = " . $email . "\r\n Subject =" .$subject. "\r\n Message =" . $message;
        $headers = "From: noreply@assignmentqueries.com" . "\r\n" .
            "CC: assignmentqueries1@gmail.com";
        if ($email != NULL) {
            mail($to, $subject, $txt, $headers);
        }
        echo '<script type="text/javascript"> alert("REQUEST SUBMITED") </script>';
        // echo "Request Submited";
        header("Location:../pages/contact.html");
    }
}

?>
