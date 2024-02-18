<?php
    session_start();
    include('../config.php');

    $id = $_GET['id'];

    error_reporting (0);

    $sql = "SELECT * FROM `order` WHERE orderID = '$id'";
    $result=$conn-> query($sql);
    //  echo $result;
    $row=$result-> fetch_assoc();

    $price = $_POST['priceInput'];

    if(isset($_POST['button'])){
            $update = mysqli_query($conn,"UPDATE `order` SET price = $price where orderID='$id'");
    }
    if($update){
        echo "<script> alert('Change Success')</script>";
        // header('Location:message-price-update.php');
    }

// Upload File    

    if(isset($_POST['file-button'])){

// Normal Method

        $number = '1234';
        $folder = "../../delivery";
        $file =$_FILES["file"]["name"];
        $tname = $_FILES["file"]["tmp_name"];

        if(move_uploaded_file($tname, $folder.'/'.$file)){
            echo '<script type="text/javascript"> alert("File Uploaded Successfully") </script>';
        }else{
            echo '<script type="text/javascript"> alert("File Not Uploaded") </script>';
        }


// Uploading File By changing it's Name

        // $newfilename= $id.str_replace(" ", "", basename($_FILES["file"]["name"]));

        // if(move_uploaded_file($_FILES["file"]["tmp_name"], "../../delivery/" . $newfilename)){
        //     echo "File Uploaded Successfully";
        // }else{
        //     echo "File Not Uploaded";
        // }
        
          
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon.jpeg" type="image/jpeg">
    <link rel="stylesheet" href="../style/message-update.css">
    <title>Message - Update</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../orders.php">HOME</a></li>
                <li><a href="../support.php">SUPPORTS</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="message-container">
            <h2>USER'S MESSAGE</h2>
            <p><?php echo $row["description"] ?></p>
        </div>
        <div class="price-container">
            <h2>Update Price</h2>
            <div class="imput-div">
                <form action="" method="POST">
                    <div class="column">
                        <input type="number" value="<?php echo $row['price']?>" name="priceInput">
                        <button type="submit" name="button">Update</button>
                    </div>
                    
                </form>
            
            </div>
        </div>
        <div class="upload-file">
            <h2>Upload Assignment</h2>
            <div class="input-div">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="column">
                        <input type="file" name="file">
                        <button type="submit" name="file-button">UPLOAD</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="upload-file">
            <h2>Download Assignment Problem</h2>
            <div class="input-div">
                <a class="assignmentBtn" download="<?php echo 'assignmentqueries.com'; ?>" href="../../orders/<?php echo $row['file']?>">DOWNLOAD</a>
            </div>
        </div>
    </div>
    
</body>
</html>