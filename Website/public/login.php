<?php
   session_start();
   
   include('config.php');
   
   if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
   	
    if ($email != "" && $password != ""){
        $password = md5($password);

        $sql_query = "select count(*) as cntUser from User where email='$email' and password='$password'";
        $result = mysqli_query($conn,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];
        
        if($count > 0){
        
            $selectSQL = "SELECT * FROM User WHERE email='$email' LIMIT 1";
            $select = mysqli_query($conn, $selectSQL);
            $row = mysqli_fetch_assoc($select);
            
            
        
            $_SESSION['isLoggedOn'] = true;
            $_SESSION['u_id'] = $row['user_id'];
            $_SESSION['forename'] = $row['forename'];
            $_SESSION['surname'] = $row['surname'];
            $_SESSION['university'] = $row['university'];
            
            $selectSQL = "SELECT Wallet.wallet_amount FROM Wallet, User WHERE Wallet.wallet_id = User.wallet_id AND user_id = $_SESSION[u_id]";
            $select = mysqli_query($conn, $selectSQL);
            $row = mysqli_fetch_assoc($select);
            
            $_SESSION['walletAmount'] = $row['wallet_amount'];
            
            
            
            
            
            if($row['wallet_id']==null){
              header('Location: createWallet.php');
              exit();
            }else{
              header('Location: index.php');
              exit();
            }
        }else{
            echo "Invalid username and password";
        }

    }

}   
?>