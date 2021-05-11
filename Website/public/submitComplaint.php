<?php
  session_start();
  include('config.php');
  
  
  $listing_id=$_POST['listing_id'];
  $complaint=$_POST['complaint'];
  
  $SQL = "INSERT INTO Complaints (listing_id, complaint, active_comp) VALUES ('$listing_id', '$complaint', 0)";
  
  if ($conn->query($SQL) === TRUE) {
    echo 'Sucsess';
  
  }
  
?>
  