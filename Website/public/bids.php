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
              <li class="nav-item">
                <a class="nav-link" href="index.html">
                  <span data-feather="home"></span>
                  Browse <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="mylistings.php">
                  <span data-feather="file"></span>
                  My Listings
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="shopping-cart"></span>
                  Won Auctions
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="bids.php">
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
         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
           <h1 class="h2">Bids</h1>
           <div class="btn-toolbar mb-2 mb-md-0">
           </div>
         </div>
         <p><?php echo("{$_SESSION['u_id']}"."<br />");?></p>
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
          feather.replace()
        </script>
      </body>
</html>
