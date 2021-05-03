<?php
  session_start();
  include('config.php');
  $user_id = $_SESSION['u_id'];
  
 	$sql="SELECT COUNT(listing_id) AS numOfListings FROM Listing WHERE seller_id = '$user_id' AND status_id=1";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  
 
  echo $row['numOfListings'];
  
  
?>
  
  