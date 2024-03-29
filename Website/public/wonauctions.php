<?php
  session_start();

  include('config.php');
  $user_id = $_SESSION['u_id'];

  $sql = "SELECT Listing.listing_id, category_id, condition_id, status_id, seller_id, Listing.buyer_id, listing_name, description, images, start_time, end_time, num_of_bids, bid_highest, buy_now, buy_now_price, start_price, User.user_id, wallet_id, role_id, forename, surname, email, password, university, address, postcode, strikes, (SELECT count(Feedback.feedback_id) FROM Feedback WHERE rated_by = '$user_id' AND Listing.listing_id = Feedback.listing_id) as numberOfReviewForListing FROM Listing, Feedback JOIN User WHERE status_id='3' AND buyer_id='$user_id' AND Listing.seller_id = User.user_id GROUP BY User.user_id, Listing.listing_id, Listing.seller_id ORDER BY end_time DESC";
  $result = mysqli_query($conn, $sql);
  
  $listing_data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $listing_data[] = $row;
    }
    
    
   
   $json = json_encode($listing_data, JSON_PRETTY_PRINT);
   
   $file_name = 'InactiveListings-'. ($_SESSION['u_id']) . '.json';
   file_put_contents("users/{$_SESSION['u_id']}/$file_name", $json);
   
   $decoded_array = json_decode($json, true);
?>

<?php function createCard(array $jsonArr) { ?>
        <?php 
        $firstFile = scandir($jsonArr["images"], SCANDIR_SORT_ASCENDING)[2];
        $date = date_create($jsonArr["end_time"]);
        $formatedDate = date_format($date,"l jS \of F Y");
        
      
        
        
         ?>
        
         <div class="card w-100 align-item-center mb-4" style="max-height: 25rem;">
             <div class="card-header w-100">
                <h5><?= $jsonArr["listing_name"] ?></h5>
              </div>
              <div class="row no-gutters">
                <div class="col-2">
                    <img src="<?= $jsonArr["images"] ?>/<?= $firstFile?>" class="img-fluid" alt="" width="170" height="170">
                </div>
                <div class="col-4">
                    <div class="card-block px-2 col-10">
                        <h5 class="mb-4 mt-2 text-center">Listing Description:</h5>
                        <p class="card-text"><?= $jsonArr["description"] ?></p>
                    </div>  
                  </div>
                  <div class="col-3">
                    <div class="card-block px-2">
                      <h5 class="mb-4 mt-2" style="display: block; ">Listing Details:</h5>
                      <p class="card-text">Seller Details: <?= $jsonArr["forename"]; ?> <?= $jsonArr["surname"]; ?></p>
                      <p class="card-text">Bought for: &#163;<?= $jsonArr["bid_highest"]/100 ?></p>
                            
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="card-block px-2">
                      <h5 class="mb-4 mt-2" style="display: block; ">Leave a Review:</h5>
                       <div class="container">
                      	<div class="row">
                         <?php if($jsonArr["numberOfReviewForListing"]==0): ?>
                         <p class="card-text">Please consider leaving a review for the seller below!</p>
                       <form action="reviewUser.php" method="POST">
                          <button type="submit" id="review" class="btn btn-primary btn-md mr-1 mb-2" value="<?= $jsonArr["listing_id"] ?>" name="reviewListing">Submit Review</button>
                      </form>
                      <?php else: ?>
                        <p class="card-text">Your Review Has Been Submitted, Thank You!</p>
                      <?php endif; ?>
                     
                        
                      </div>
                       </div>     
                    </div>
                  </div>
                  </div>
        
                  <div class="card-footer   text-muted">
                    <div class="text-left" id="demo">
   
        
                      Listing Won: <?=  $formatedDate ?>
                    </div>
                  </div>
         </div>
   
        

<?php } ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Won Auctions</title>
    <link rel="stylesheet" href="style.css">
    <link href="bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.html">UniBid</a>
  
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
                <h7 class="text-center">Wallet Balance: &#163;<?php echo ($_SESSION["walletAmount"]/100);?></h7>
                <div class="border-top my-4"></div>
              <?php endif; ?>
              <li class="nav-item">
                <a class="nav-link" href="index.html">
                  <span data-feather="home"></span>
                  Browse <span class="sr-only"></span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="mylistings.php">
                  <span data-feather="file"></span>
                  My Listings
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="wonauctions.php">
                  <span data-feather="shopping-cart">(current)</span>
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
                <a class="nav-link" href="wishlist.php">
                  <span data-feather="bar-chart-2"></span>
                  Wishlist
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="account.php">
                  <span data-feather="users"></span>
                  Account
                </a>
              </li>
            </ul>
          </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php if( $_SESSION['isLoggedOn']): ?>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-4 mb-3 border-bottom">
             <h1 class="h2">Won Auctions</h1>
             <div class="btn-toolbar mb-2 mb-md-0">
             </div>
           </div>
           <?php 
              foreach($decoded_array as $wonListing){
                createCard($wonListing);
              }
            ?>
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
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
          feather.replace()
        </script>
        
      </body>
</html>
