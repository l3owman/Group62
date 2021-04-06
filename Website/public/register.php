<?php

  include('config.php');
  // initializing variables
  $email    = "";
  $errors = array();

  // connect to the database

  // REGISTER USER
  if (isset($_POST['register'])) {
    // receive all input values from the form
    $forename = mysqli_real_escape_string($conn, $_POST['forename']);
    $surename = mysqli_real_escape_string($conn, $_POST['surename']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_dup']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $postcode = mysqli_real_escape_string($conn, $_POST['postcode']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($forename)) { array_push($errors, "Forename is required"); }
    if (empty($surename)) { array_push($errors, "Surename is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
  	array_push($errors, "The two passwords do not match");
    }
    if (empty($address)) { array_push($errors, "Address is required"); }
    if (empty($postcode)) { array_push($errors, "Postcode is required"); }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM User WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
      if ($user['email'] === $email) {
        array_push($errors, "Email already in use");
      }
    }


    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
    	$password = md5($password_1);//encrypt the password before saving in the database
      $date = date('d-m-y h:i:s');

    	$sql = "INSERT INTO User (forename, surename, email, password, date_created, address, postcode) VALUES ('$forename', '$surename', '$email', '$password', '$date', '$address', '$postcode')";
      if ($conn->query($sql) === TRUE) {
        header('Location: index.html');
        exit;
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }




  }else{
    echo (count($errors));
  }

 $conn->close();
}
