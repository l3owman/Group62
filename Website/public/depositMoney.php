<?php 
  session_start();
  include('config.php');
  
  $depositValue = $_POST['deposit'];
  $depositValuePence = $depositValue*100;
  $user_id = $_SESSION['u_id'];
  $walletAmount = $_SESSION['walletAmount'];
  
  $newBalance = $walletAmount + $depositValuePence;
  
  
  $sql = "UPDATE Wallet SET wallet_amount = '$newBalance' WHERE wallet_id = '$user_id'";
  if ($conn->query($sql) === TRUE) {
     $_SESSION['walletAmount'] = $newBalance;
     echo $newBalance;
  }
  
?>