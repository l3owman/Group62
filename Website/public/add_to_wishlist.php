<?php
  session_start();
  include('config.php');
  
  $user_id = $_SESSION['u_id'];
  $listing_id=$_POST['listing_id'];
	
	$sql="INSERT INTO Wishlist (user_id, listing_id) VALUES ('$user_id', '$listing_id')";
  if ($conn->query($sql) === TRUE) {
      echo json_encode(array("statusCode"=>200));
  }
  else 
  {
      echo json_encode(array("statusCode"=>201));
  }
?>