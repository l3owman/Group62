<?php 
  session_start();
  include('config.php');
  
  $user_id = $_SESSION['u_id'];
   
  $SQL = "UPDATE User SET role_id = 4 WHERE user_id = '$user_id'";
  if ($conn->query($SQL) === TRUE) {
    $updateWallet = "UPDATE Wallet SET wallet_amount = 0 WHERE wallet_id = '$user_id'";
    if ($conn->query($updateWallet) === TRUE) {
      session_destroy();
      header('Location: index.php');
    }
  }
?>
   
   