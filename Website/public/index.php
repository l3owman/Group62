<?php
  session_start();
  include('config.php');
  $user_id = $_SESSION['u_id'];
  
  $sql = "SELECT * FROM Listing WHERE status_id = 1 AND seller_id != '$user_id' ORDER BY num_of_bids DESC;";
  $result = mysqli_query($conn, $sql);
  
  $listing_data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $listing_data[] = $row;
    }
   
   $json = json_encode($listing_data, JSON_PRETTY_PRINT);
   
   
   $decoded_array = json_decode($json, true);
   
?>

<?php function createCard(array $jsonArr) { ?>
        <?php $firstFile = scandir($jsonArr["images"], SCANDIR_SORT_ASCENDING)[2]; ?>
        <div class="card h-100 mb-3 mr-2" style="min-width: 15.3rem; max-width: 15.3rem; min-height: 31.5rem">
            <img height="270" width="180" class="card-img-top" src="<?= $jsonArr["images"] ?>/<?= $firstFile?>">
            <div class="card-body">
                <h5 class="card-title" id="listing_title"><?= $jsonArr["listing_name"] ?></h5>
                <p class="card-text scrollable"><?= $jsonArr["description"] ?></p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item text-center">Highest Bid: &#163;<?= $jsonArr["bid_highest"]/100 ?></li>
              
            
            </ul>
            <div class="card-footer">
                  <div class="text-center">
                    <form method="post" action="viewlisting.php">
                      <button type="submit" class="btn btn-primary" value='<?= $jsonArr["listing_id"] ?>' name='viewListing'>View Listing</button>
                    </form>
                  </div>
                </div>
         </div> 
<?php } ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Browse</title>
    <link rel="stylesheet" href="style.css">
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="jquery.min.js" async></script>
    <script src="bootstrap.min.js" async></script>
    <script src="jquery.validate.min.js" async></script>
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.html">UniBid</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search" id="search">
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
                <a class="nav-link active" href="index.html">
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
                <a class="nav-link" href="wonauctions.php">
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
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-4 mb-3 border-bottom">
            <h1 class="h2">Browse</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
            </div>
          </div>
         
          <div class="card-deck">
            <?php 
              foreach($decoded_array as $listing){
                createCard($listing);
              }
            ?>
          </div>
         
 
        </div>
       
  
         <script>
        $(document).ready(function(){
          
          $('#search').keyup(function (){
            $('.card').removeClass('d-none');
            var filter = $(this).val(); 
            $('.card-deck').find('.card .card-title:not(:contains("'+filter+'"))').parent().parent().addClass('d-none');
          });
        });
        </script>
        
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
          feather.replace()
        </script>       
  
      </body>
</html>
