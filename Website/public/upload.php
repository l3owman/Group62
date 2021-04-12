<?php
  include('config.php');
   session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    $listing_name = mysqli_real_escape_string($conn, $_POST['listingName']);
    $description = mysqli_real_escape_string($conn, $_POST['listingDesc']);
    $buy_now = mysqli_real_escape_string($conn, $_POST['buyNowCheck']);
    $buy_now_price = mysqli_real_escape_string($conn, $_POST['listingBuyPrice']);
    $seller_id = $_SESSION['u_id'];

    if(isset($conn, $_POST['buyNowCheck'])){
      $bool = 1;
    }else{
      $bool = 0;
    }

    if(isset($conn, $_POST['listingBuyPrice'])){
      $buyNow = $buy_now_price;
    }else{
      $buyNow = 0;
    }


    $buy_now_price = mysqli_real_escape_string($conn, $_POST['listingBuyPrice']);
    $bid_price = mysqli_real_escape_string($conn, $_POST['listingBidPrice']);
    $listingDuration = mysqli_real_escape_string($conn, $_POST['listingDuration']);
    $oldDate = date('y-m-d h:i:s');
    $bstDate = date('y-m-d h:i:s', strtotime($oldDate. " +1 hours"));
    $newDate = date('y-m-d h:i:s', strtotime($newDate. " + {$listingDuration} hours"));


    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];


        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");

        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");

        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){

            $sql = "INSERT INTO Listing (seller_id, listing_name, description, images, start_time, end_time, num_of_bids, bid_highest, buy_now, buy_now_price, start_price) VALUES ('$seller_id', '$listing_name', '$description', '$filename', '$bstDate', '$newDate', 0, 0, '$bool', '$buyNow', '$bid_price')";
            if ($conn->query($sql) === TRUE) {
              $selectSQL = "SELECT listing_id FROM Listing WHERE seller_id='$seller_id' LIMIT 1";
              $select = mysqli_query($conn, $selectSQL);
              $row = mysqli_fetch_assoc($select);


              $filepath = "users/$seller_id/listings/$row[listing_id]/images/$filename";

              $sqlUpdate = "UPDATE Listing SET images = '$filepath' WHERE images = '$filename'";

              if ($conn->query($sqlUpdate) === TRUE) {
                $directoryName = '$row[listing_id]';
                  //Check if the directory already exists.
                  if(!is_dir($directoryName)){
                      //Directory does not exist, so lets create it.
                      $target_file = "users/$seller_id/listings/$row[listing_id]/images/$filename";
                      mkdir("users/$seller_id/listings/$row[listing_id]/images", 0755, true);


                      move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
                      header('Location: mylistings.php');
                  }else{
                    echo 'This is already a listing';
                }
              }else{
                echo "Error: " . $sqlUpdate . "<br>" . $conn->error;
              }

            }else {

              echo "Error: " . $sql . "<br>" . $conn->error;
            }

        } else{
            echo "Error: There was a problem uploading your file. Please try again.";
        }
    } else{
        echo "Error: " . $_FILES["photo"]["error"];
    }
}
?>
