<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css">
    <link href="bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.html">UniBid</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <?php if( $_SESSION['isLoggedOn']): ?>
             <a class="nav-link" href="logout.php">Log Out</a>
          <?php else: ?>
              <a class="nav-link" href="login.html">Sign In</a>
          <?php endif; ?>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <?php if( $_SESSION['isLoggedOn']): ?>
                <h5 class="text-center"><?php
                    echo $_SESSION["forename"];
                    echo " ";
                    echo $_SESSION["surname"];
                  ?></h5>
                <h7 class="text-center"><?php
                    echo $_SESSION["university"];
                  ?></h7>
                <div class="border-top my-4"></div>
              <?php endif; ?>
              <li class="nav-item">
                <a class="nav-link" href="index.html">
                  <span data-feather="home"></span>
                  Browse
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="mylistings.php">
                  <span data-feather="file"></span>
                  My Listings <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="shopping-cart"></span>
                  Won Auctions
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="bids.php">
                  <span data-feather="layers"></span>
                  Bids
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="bar-chart-2"></span>
                  Wishlist
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="users"></span>
                  Account
                </a>
              </li>
            </ul>
          </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php if( $_SESSION['isLoggedOn']): ?>
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
             <h1 class="h2">My Listings</h1>
             <div class="btn-toolbar mb-2 mb-md-0">
             </div>
           </div>
            <ul class="nav nav-tabs nav-justified mb-3">
              <li class="nav-item">
                <a class="nav-link active" href="mylistings.php">Active Listings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Previous Listings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="create_listing.php">Create Listing</a>
              </li>
            </ul>

           <div class="card" style="max-height: 32rem">
             <div class="card-header w-100">
                <h5>Kettle</h5>
              </div>
              <div class="row no-gutters">
                <div class="col-auto">
                    <img src="test.png" class="img-fluid" alt="" width="200" height="90">
                </div>
                <div class="col">
                    <div class="card-block px-2">
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                        </div>
                        <div class="card-block text-center px-2">
                          <p class="card-text">Highest Bid: </p>
                          <p class="card-text">Number of Bids: </p>
                          <p class="card-text">Time Remaining: </p>
                          <a href="#" class="btn btn-primary">Edit Listing</a>
                          <a href="#" class="btn btn-primary">Remove Listing</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer w-100 text-muted">
                Listing Created at:
            </div>
         </div>
        <?php else: ?>
           <div class="container h-100">
              <div class="row align-items-center h-100">
                  <div class="col-6 mx-auto">
                      <div class="card text-center">
                          <div class="card-header w-100">
                            <h5><i data-feather="alert-circle" alt="alert-circle" style="width: 30px; height: 30px"></i> Unauthorised Access </h5>
                          </div>
                          <div class="card-body">
                            <p class="card-text">Sorry, you do not have access to this page. To view, please log in below.</p>
                            <a href="login.html" class="btn btn-primary">Login</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        <?php endif; ?>
        </div>
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
          feather.replace()
        </script>
      </body>
</html>
