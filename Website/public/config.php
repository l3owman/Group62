<?php
  $servername = "studdb:3306";
  $database = "sgcdeega";
  $username = "sgcdeega";
  $password = "group62pass";
    
    // Create connection
  $conn = mysqli_connect($servername,$username,$password,$database);

  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }


?>
