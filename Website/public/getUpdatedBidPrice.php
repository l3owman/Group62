<?php
  session_start();
  include('config.php');
  

  $listing_id=$_POST['listing_id'];
	
	$sql="SELECT bid_highest FROM Listing WHERE listing_id = '$listing_id'";
  $result = mysqli_query($conn, $sql);
  
  $listing_data = array();
  while($row =mysqli_fetch_assoc($result))
    {
        $listing_data[] = $row;
    }
  echo $listing_data[0]["bid_highest"];
  
?>