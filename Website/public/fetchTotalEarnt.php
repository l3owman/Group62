<?php 
  session_start();
  include('config.php');
  
  $user_id = $_SESSION['u_id'];
  
  $sql = "SELECT SUM(bid_highest) as moneyEarnt FROM Listing WHERE seller_id = '$user_id' AND status_id = 3;";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  

  
  
  $moneyEarntLastWeek = "SELECT SUM(bid_highest) AS moneyEarntWeek FROM Listing
                        WHERE end_time >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
                        AND end_time < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND seller_id = '$user_id' AND status_id = 3";

  $SQLresult = mysqli_query($conn, $moneyEarntLastWeek);
  $newRow = mysqli_fetch_assoc($SQLresult);
  
  $moneyEarnt = $row['moneyEarnt']/100;
  
  if($newRow['moneyEarntWeek']==null){
    $response = array('totalEarnt' => $moneyEarnt, 'percentChange' => 'N/A');
    echo json_encode($response);
  }else{
    $earntBeforeThisWeek = $row['moneyEarnt'] - $newRow['moneyEarntWeek'];

    $decreaseValue = $row['moneyEarnt'] - $earntBeforeThisWeek;
    
    
     
    $perChange = ($decreaseValue / $earntBeforeThisWeek) * 100;
    $response = array('totalEarnt' => $moneyEarnt, 'percentChange' => $perChange);
    
    echo json_encode($response);
    
  
  }
  
?>

