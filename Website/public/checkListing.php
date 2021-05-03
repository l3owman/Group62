<?php

    session_start();
   include('config.php');

   $user_id = $_SESSION['u_id'];
   $listing_id=$_POST['listing_id'];
   
                      
   $listingActive = "SELECT status_id FROM Listing WHERE listing_id = '$listing_id'";
   
   $select = mysqli_query($conn, $listingActive);
   $row = mysqli_fetch_assoc($select);
   
   if($row['status_id']==1&& $row['status_id']!==3){
     echo 'Active';
   }
   if($row['status_id']==2 && $row['status_id']!==3){
     $winningUserID = "SELECT buyer_id FROM Listing WHERE listing_id='$listing_id' AND status_id=2";
     $selectID = mysqli_query($conn, $winningUserID);
     $row = mysqli_fetch_assoc($selectID);
     if($row['buyer_id']==$user_id){
       $updateListing = "UPDATE Listing SET status_id = 3 WHERE listing_id = '$listing_id'";
        if ($conn->query($updateListing) === TRUE) {
          echo 'Success';
        } 
     }else{
       $amountBid = "SELECT bid_amount FROM Bids WHERE wallet_id='$user_id' and listing_id ='$listing_id' ORDER BY time_of_bid DESC LIMIT 1";
       $selectAmount = mysqli_query($conn, $amountBid);
       $row = mysqli_fetch_assoc($selectAmount);
       $returnToWallet = $row['bid_amount'];
       $updateWallet = "UPDATE Wallet SET wallet_amount = (wallet_amount + '$returnToWallet') WHERE wallet_id = '$user_id'";  
       if ($conn->query($updateWallet) === TRUE) {
         $updateListing = "UPDATE Listing SET status_id = 3 WHERE listing_id = '$listing_id'"; 
         if ($conn->query($updateListing) === TRUE) {
           $walletAmount = $_SESSION["walletAmount"] + $returnToWallet;
           $_SESSION["walletAmount"] = $walletAmount;
           $response = array('Response' => 'Unsuccessful', 'Content' => $walletAmount);
           echo json_encode($response);
         }
       }
     }
   }

?>