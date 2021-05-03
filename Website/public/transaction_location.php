<?php
session_start();
include('config.php');


    $_SESSION["location"] = $_POST["transactionLocation"];
    header('Location: specific_transaction.php');


?>