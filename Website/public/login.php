<?php

   include('config.php');
   session_start();
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

            $selectSQL = "SELECT user_id FROM User WHERE email='$email' LIMIT 1";
            $select = mysqli_query($conn, $selectSQL);
            $row = mysqli_fetch_assoc($select);

            $_SESSION['isLoggedOn'] = true;
            $_SESSION['u_id'] = $row[user_id];
            header('Location: index.php');
            exit;
        }else{
            echo "Invalid username and password";
        }

    }

}
?>
