<?php  session_destroy();?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css">
    <link href="bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

  <div class = "topMargin">
    <div class="container-fluid">
      <div class="row">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-6 mx-auto">
                        <div class="card text-center">
                            <div class="card-header w-100">
                                <h5><i data-feather="alert-circle" alt="alert-circle" style="width: 30px; height: 30px"></i>Unsuccessful Login Attempt</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Sorry, you have entered the wrong login details please press return to try again.
                                </p>
                                <a href="login.php" class="btn btn-primary">Return</a>
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