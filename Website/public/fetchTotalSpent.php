<?php 
  session_start();
  include('config.php');
  
  $user_id = $_SESSION['u_id'];
  
  $sql = "SELECT SUM(bid_highest) as moneySpent FROM Listing WHERE buyer_id = '$user_id' AND status_id = 3";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  
  $moneySpentLastWeek = "SELECT SUM(bid_highest) AS moneySpentWeek FROM Listing
                        WHERE end_time >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
                        AND end_time < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND buyer_id = '$user_id' AND status_id = 3";

  $SQLresult = mysqli_query($conn, $moneySpentLastWeek);
  $newRow = mysqli_fetch_assoc($SQLresult);
  
  $moneySpent = $row['moneySpent']/100;
  
  if($newRow['moneySpentWeek']==null){
    $response = array('totalSpent' => $moneySpent, 'percentChange' => 'N/A');
    echo json_encode($response);
  }else{
    $spentBeforeThisWeek = $row['moneySpent'] - $newRow['moneySpentWeek'];
    
    
    
    $decreaseValue = $row['moneySpent'] - $spentBeforeThisWeek;
    
    
     
    $perChange = ($decreaseValue / $spentBeforeThisWeek) * 100;
    $response = array('totalSpent' => $moneySpent, 'percentChange' => $perChange);
    
    echo json_encode($response);
    
  
  }
                        
  


?>