<?php 
  session_start();
  include('config.php');

  $user_id = $_SESSION['u_id'];

  $sql = "SELECT email FROM User WHERE user_id = '$user_id'";
  $select = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($select);
    
  echo $row['email'];

?>