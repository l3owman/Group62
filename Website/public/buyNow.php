<?php
  session_start();
  include('config.php');
  
  $user_id = $_SESSION['u_id'];
  $listing_id=$_POST['listing_id'];
  $buyNow=$_POST['buyNowVal'];
  
  
  $walletAmount = $_SESSION["walletAmount"];
  $date = DateTime::createFromFormat('U.u', microtime(TRUE));
  $microTime = ($date->format('YmdHisu'));
  
  $previousBid = "SELECT bid_amount FROM Bids WHERE listing_id ='$listing_id' ORDER BY time_of_bid DESC LIMIT 1";
  $select = mysqli_query($conn, $previousBid);
  $row = mysqli_fetch_assoc($select);
  if($row['bid_amount']==null){
      $addBid = "INSERT INTO Bids (wallet_id, listing_id, bid_amount, time_of_bid) VALUES ('$user_id', '$listing_id', '$buyNow', '$microTime')";
      if ($conn->query($addBid) === TRUE) {
        $updateListing =  "UPDATE Listing SET buyer_id = '$user_id', bid_highest = '$buyNow', num_of_bids = (num_of_bids + 1), status_id = 3 WHERE listing_id = '$listing_id'";
        if ($conn->query($updateListing) === TRUE) {
          $updateWallet = "UPDATE Wallet SET wallet_amount = (wallet_amount - '$buyNow') WHERE wallet_id = '$user_id'";
           if ($conn->query($updateWallet) === TRUE) {
             $newWalletAmount = $walletAmount - $buyNow;
             $_SESSION['walletAmount'] = $newWalletAmount;
             
             echo $buyNow;
            
             
           }else{
              echo "Error: " . $updateWallet . "<br>" . $conn->error;
            }
        }else{
          echo "Error: " . $updateListing . "<br>" . $conn->error;
        }
      }else{
        echo "Error: " . $addBid . "<br>" . $conn->error;
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
     $addBid = "INSERT INTO Bids (wallet_id, listing_id, bid_amount, time_of_bid) VALUES ('$user_id', '$listing_id', '$buyNow', '$microTime')";
          if ($conn->query($addBid) === TRUE) {
            $updateListing =  "UPDATE Listing SET buyer_id = '$user_id', bid_highest = '$buyNow', num_of_bids = (num_of_bids + 1), status_id = 3 WHERE listing_id = '$listing_id'";
            if ($conn->query($updateListing) === TRUE) {
              $update = "UPDATE Wallet SET wallet_amount = (wallet_amount - '$buyNow') WHERE wallet_id = '$user_id'";
               if ($conn->query($update) === TRUE) {
                 $newWalletAmount = $walletAmount - $buyNow;
                 $_SESSION['walletAmount'] = $newWalletAmount;
                 echo $buyNow;
                 
               }
            }
        }
       
     }
  }
?>