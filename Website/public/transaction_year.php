<?php
session_start();
include('config.php');


    $_SESSION["year"] = $_POST["transactionYear"];
    header('Location: transaction.php');


?>