<?php
  session_start();
  include('config.php');
  
  $user_id = $_SESSION['u_id'];
  $listing_id= $_POST['listing_id'];
  
  $previousBid = "SELECT bid_amount FROM Bids WHERE listing_id ='$listing_id' ORDER BY time_of_bid DESC LIMIT 1";
  $select = mysqli_query($conn, $previousBid);
  $row = mysqli_fetch_assoc($select);
  
  if($row['bid_amount']==null){
    $SQL = "UPDATE Listing SET status_id = 2 WHERE listing_id = '$listing_id'";
    if ($conn->query($SQL) === TRUE) {
      header('Location: mylistings.php');
    }
  }else{
  
    $refundData = "SELECT * FROM refundWallet WHERE listing_id = '$listing_id' ORDER BY maxBid DESC LIMIT 1";
    $selectPreviousUser = mysqli_query($conn, $refundData);
    $rowData = mysqli_fetch_assoc($selectPreviousUser);
    $walletAmount = $rowData['wallet_amount'];
    $maxBid = $rowData['maxBid'];
    $userWalletID = $rowData['wallet_id'];
    
    $updateUserWallet = "UPDATE Wallet SET wallet_amount = ('$walletAmount'+'$maxBid') WHERE wallet_id ='$userWalletID'";
     if ($conn->query($updateUserWallet) === TRUE) {
       $SQLNEW = "UPDATE Listing SET status_id = 2 WHERE listing_id = '$listing_id'";
       if ($conn->query($SQLNEW) === TRUE) {
        header('Location: mylistings.php');
      }
  }
}
  
 
?>