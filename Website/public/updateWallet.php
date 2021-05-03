<?php
   session_start();
   include('config.php');
   
   $user_id = $_SESSION['u_id'];
   
   $newwalletAmount = "SELECT wallet_amount FROM Wallet WHERE wallet_id='$user_id'";
   $select = mysqli_query($conn, $newwalletAmount);
   $row = mysqli_fetch_assoc($select);

   $_SESSION['walletAmount'] = $row['wallet_amount'];
   echo $_SESSION['walletAmount'];
   
?>