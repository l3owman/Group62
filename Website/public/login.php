<?php
   include('config.php');
   if(isset($_POST['login'])){

    $uname = mysqli_real_escape_string($conn,$_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    if ($uname != "" && $password != ""){

        $sql_query = "select count(*) as cntUser from User where email='$uname' and password='$password'";
        $result = mysqli_query($conn,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if($count > 0){
            header('Location: index.html');
            exit;
        }else{
            echo "Invalid username and password";
        }

    }

}
?>
