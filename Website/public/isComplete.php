<?php
  session_start();
  include('config.php');
  
  $listing_id = $_POST['listing_id'];
  
  $SQL = "SELECT status_id FROM Listing WHERE listing_id = '$listing_id'";
  $select = mysqli_query($conn, $SQL);
  $row = mysqli_fetch_assoc($select);
  
  $statusID = $row['status_id'];
  
  echo $statusID;
  

?>
  
  