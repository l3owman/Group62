<?php 
  session_start();
  include('config.php');
  
  $withdrawValue = $_POST['withdraw'];
  $withdrawValuePence = $withdrawValue*100;
  $user_id = $_SESSION['u_id'];
  $walletAmount = $_SESSION['walletAmount'];
  
  $newBalance = $walletAmount - $withdrawValuePence;
  
  
  $sql = "UPDATE Wallet SET wallet_amount = '$newBalance' WHERE wallet_id = '$user_id'";
  if ($conn->query($sql) === TRUE) {
     $_SESSION['walletAmount'] = $newBalance;
     echo $newBalance;
  }
  
?>