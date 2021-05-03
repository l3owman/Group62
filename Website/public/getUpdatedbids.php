<?php
  session_start();
  include('config.php');
  

  $listing_id=$_POST['listing_id'];
	
	$sql="SELECT num_of_bids FROM Listing WHERE listing_id = '$listing_id'";
  $result = mysqli_query($conn, $sql);
  
  $listing_data = array();
  while($row =mysqli_fetch_assoc($result))
    {
        $listing_data[] = $row;
    }
  
  echo $listing_data[0]["num_of_bids"];
  
?>