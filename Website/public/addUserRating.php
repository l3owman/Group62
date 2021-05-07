<?php
  session_start();
  include('config.php');
  
  
  $rating = $_POST['rating'];
  $user_id = $_SESSION['u_id'];
  $seller_id = $_POST['seller_id'];
  $listing_id = $_POST['listing_id'];
  $date = date('y-m-d H:i:s');
  
  $sql = "INSERT INTO Feedback (user_id, listing_id, rated_by, rating, date_created) VALUES ('$seller_id', '$listing_id', '$user_id', '$rating', '$date')";

  if ($conn->query($sql) === TRUE) {
     echo 'Success';
  }
  
  
  
  

?>