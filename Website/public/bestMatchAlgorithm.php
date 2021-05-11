<?php
  session_start();
  include('config.php');
  
 
  $numOfBids = mysqli_query($conn, "SELECT num_of_bids, num FROM Listings WHERE listing_id = 167");
  
  echo mysqli_num_rows($numOfBids);
  
?>