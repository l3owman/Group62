<?php
session_start();
include('config.php');

$sql = "UPDATE Listing SET status_id = 2 WHERE listing_id =
 (SELECT listing_id FROM Complaints WHERE complaint_id = 
 ( SELECT Min(complaint_id) FROM Complaints WHERE active_comp = 0));";


if (mysqli_query($conn, $sql)) {
    $updateSQL = "UPDATE User set strikes = strikes+1 WHERE user_id =  (SELECT seller_id FROM Listing WHERE Listing.listing_id = (SELECT listing_id FROM Complaints WHERE complaint_id = 
     ( SELECT Min(complaint_id) FROM Complaints WHERE active_comp = 0)));";
    if (mysqli_query($conn, $updateSQL)) {
      $banAccount = "SELECT user_id, strikes FROM User Where user_id = (SELECT seller_id FROM Listing WHERE Listing.listing_id = (SELECT listing_id FROM Complaints WHERE complaint_id = 
 ( SELECT Min(complaint_id) FROM Complaints WHERE active_comp = 0)));";
      $result = mysqli_query($conn, $banAccount);
      $row = mysqli_fetch_assoc($result);
      
      if($row['strikes'] == 3){
        $userID = $row['user_id'];
        $updateRole = "UPDATE User SET role_id = 3 WHERE user_id = '$userID';";
        if (mysqli_query($conn, $updateRole)) {
           header('Location: admin.php');
        }
      
      }else{
        header('Location: admin.php');
      }
 
     
    
    }
} else {
    echo "Error Removing Listing : " . mysqli_error($conn);
}


?>
