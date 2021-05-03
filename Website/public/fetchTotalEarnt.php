<?php 
  session_start();
  include('config.php');
  
  $user_id = $_SESSION['u_id'];
  
  $sql = "SELECT SUM(bid_highest) as moneyEarnt FROM Listing WHERE seller_id = '$user_id' AND status_id = 3;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  
  echo $row['moneyEarnt']/100;
  
?>