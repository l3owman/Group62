<?php  
session_destroy();
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css">
    <link href="bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

    <div class = "mt-5">
      <div class="container-fluid">
        <div class="row">
              <div class="container h-100">
                  <div class="row align-items-center h-100">
                      <div class="col-6 mx-auto">
                          <div class="card text-center">
                              <div class="card-header w-100">
                                  <h5><i data-feather="alert-circle" alt="alert-circle" style="width: 30px; height: 30px"></i> Your Account Has Been Banned </h5>
                              </div>
                              <div class="card-body">
                                  <p class="card-text">Sorry, you have received to many strikes against your account. Your Money has been
                                      refunded from your wallet.
                                  </p>
                                  <a href="logout.php" class="btn btn-primary">Return</a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
  
          </div>
      </div>
     </div>
  </body>
</html>