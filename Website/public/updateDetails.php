<?php 
  session_start();
  include('config.php');
  
  $user_id = $_SESSION['u_id'];
  
  $sql = "SELECT * FROM User WHERE user_id = '$user_id'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);


  $firstName = $_POST['firstname'];
  $lastName = $_POST['lastname'];
  $address = $_POST['address'];
  $postcode = $_POST['postcode'];
  
 
  if($firstName==null){
    $firstName = $row['forename'];
  }
  if($lastName==null){
    $lastName = $row['surname'];
  }
  if($address==null){
    $address = $row['address'];
  }
  if($postcode==null){
    $postcode = $row['postcode'];
  }

 $updateSQL = "UPDATE User SET forename = '$firstName', surname = '$lastName', address = '$address', postcode = '$postcode' WHERE user_id = '$user_id'";
 
 if ($conn->query($updateSQL) === TRUE) {
     $_SESSION['forename'] = $firstName;
     $_SESSION['surname'] = $lastName;
     
     header('Location: account.php');
  }
  

?>

