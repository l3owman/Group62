<?php
  session_start();
  include('config.php');
  
  $user_id = $_SESSION['u_id'];
  
  $isWallet = "SELECT EXISTS(SELECT 1 FROM Wallet WHERE wallet_id = '$user_id')";
  $sqlResult = mysqli_query($conn, $isWallet);
  $booleanVal = array();
  while($row =mysqli_fetch_assoc($sqlResult))
    {
        $booleanVal[] = $row;
    }
    
  $storeArray = (array_values($booleanVal[0]));
  
  if($storeArray == 0){
    $sql = "INSERT INTO Wallet (wallet_id, wallet_amount) VALUES ('$user_id', 0)";
    if ($conn->query($sql) === TRUE) {
        $updateSQL = "UPDATE User SET wallet_id = '$user_id' WHERE user_id = '$user_id'";
        if ($conn->query($updateSQL) === TRUE) {
          header('Location: index.php');
          exit;
        }
    }
  }else{
     header('Location: index.php');
     exit;
  }
?>