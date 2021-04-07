<?php
  include('config.php');


  $errors = array();

  if($_SERVER["REQUEST_METHOD"] == "POST"){

    //this is the new seciton for the sql stuff
    $listing_name = mysqli_real_escape_string($conn, $_POST['listingName']);
    $description = mysqli_real_escape_string($conn, $_POST['listingDesc']);
    $buy_now_price = mysqli_real_escape_string($conn, $_POST['listingBuyPrice']);
    $start_price = mysqli_real_escape_string($conn, $_POST['listingBidPrice']);
    $end_time = mysqli_real_escape_string($conn, $_POST['listingDuration']);
    $start_time = date('y-m-d h:i:s');
    $currentTime = time();
    $end_time = $currentTime + ($end_time *(60*60));
    $end_time = date('y-m-d h:i:s', $end_time);



    //
    // if (empty($listing_name)) { array_push($errors, "You are required to provide a Name"); }
    // if (empty($start_price)) { array_push($errors, "You must provide a Starting Price");}
    // if (empty($end_time)) { array_push($errors, "Please select one of the provided end times"); }
    //
    //
    //
    // //This Query needs checking that we are entering everything correctly
    // $sql = "INSERT INTO Listing (listing_name, description, buy_now_price, start_price, end_time, start_time, image) VALUES ('$start_price', '$description', '$buy_now_price', '$start_price', '$end_time', '$start_time')";
    //


    // here we need to retrieve the listing id that we have just created
    //ready to upload the file
    // we then need to make the listing Id as a directory in the users Directory




//then i think this code comes next for uploading the file where the
//path is the above directory
//instead of user



    // Check if file was uploaded without errors
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
            // Check whether file exists before uploading it
            if(file_exists("users/" . $filename)){
                echo $filename . " is already exists.";
            } else{
                move_uploaded_file($_FILES["photo"]["tmp_name"], "users/" . $filename);
                echo "Your file was uploaded successfully.";
                echo $start_time;
                echo $end_time;
            }
        } else{
            echo "Error: There was a problem uploading your file. Please try again.";
        }
    } else{
        echo "Error: " . $_FILES["photo"]["error"];
    }



}
?>
