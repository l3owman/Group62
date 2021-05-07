<?php
  session_start();
  include('config.php');

  $selectedlistingID = $_POST['viewListing'];
    

  $sql = "SELECT * FROM Listing WHERE listing_id = $selectedlistingID";
  $result = mysqli_query($conn, $sql);
  
  $listing_data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $listing_data[] = $row;
    }
   
   $json = json_encode($listing_data, JSON_PRETTY_PRINT);
   
   $decoded_array = json_decode($json, true);
   
   foreach ($decoded_array as $json ) {
     $listingData = $json;
    }
     $dir_name = $listingData['images'];
     $images = glob($dir_name."*{jpg,png,gif}", GLOB_BRACE);
     $imageArray = array();
     foreach($images as $image) {
       array_push($imageArray, $image);
     }
     $numOfImages = count($imageArray);


    $isWishlistSelectedSQL = "SELECT EXISTS(SELECT 1 FROM Wishlist WHERE user_id = '$_SESSION[u_id]' AND listing_id = '$listingData[listing_id]')";
    $wishlistResult = mysqli_query($conn, $isWishlistSelectedSQL);
    $booleanVal = array();
    while($row =mysqli_fetch_assoc($wishlistResult))
    {
        $booleanVal[] = $row;
    }
    
    $storeArray = (array_values($booleanVal[0]));
    $indexVal =  $storeArray[0];
    
    $sellerID = $listingData['seller_id'];
    
    $getSellerInfo = "SELECT forename, surname FROM User JOIN  Listing WHERE '$sellerID' = '$sellerID' LIMIT 1";
    $select = mysqli_query($conn, $getSellerInfo);
    $row = mysqli_fetch_assoc($select);
    
    $catID = $listingData['category_id'];
    
    $getCategory = "SELECT category_name FROM Category WHERE category_id = '$catID'";
    $selectCat = mysqli_query($conn, $getCategory);
    $rowCat = mysqli_fetch_assoc($selectCat);
    
    
    $getRating = "SELECT AVG(rating) as rating, COUNT(feedback_id) as numOfRatings FROM Feedback WHERE user_id = '$sellerID'";
    $selectRating = mysqli_query($conn, $getRating);
    $rowRating = mysqli_fetch_assoc($selectRating);

?>
 
<!DOCTYPE html>

<html>
  <head>
    <title>View Listing</title>
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
                <h7 class="text-center" id="balance">Wallet Balance: &#163;<?php echo ($_SESSION["walletAmount"]/100);?></h7>
                <div class="border-top my-4"></div>
              <?php endif; ?>
              <li class="nav-item">
                <a class="nav-link active" href="index.html">
                  <span data-feather="home"></span>
                  Browse 
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
            <h2 class="h2">Listing Details</h2>
            <div class="btn-toolbar mb-2 mb-md-0">
            </div>
          </div>
         
          <div style="display: none" id="hideAll">
         <div class="container">
           <div class="row">
              <div class="col">   
            </div>
            <div class="col">
              <div class="container"> 
              </div>
            </div>
          </div>
          <section class="mb-5 ">
          
            <div class="row">
              <div class="col-md-6 mb-4 mb-md-0">
          
                <div id="mdb-lightbox-ui"></div>
          
                <div class="mdb-lightbox">
          
                  <div class="row product-gallery mx-1">
          
                    <div class="col-12 mb-0">
                      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div id="carouselExampleControls" class="carousel slide border border-dark" data-ride="carousel" >
                      <div class="carousel-inner" style=" width:100%; height: 620px !important;">
                        <div class="carousel-item active">
                        <img height="620" width="300" style="z-index: -1;" class="d-block w-100" src="<?= $imageArray{0} ?>" alt="First slide">
                      </div>
                      <?php
                      for ($i = 1; $i < $numOfImages; $i++) { ?>
                        <div class="carousel-item">
                          <img class="d-block w-100" src="<?= $imageArray{$i} ?>" alt="Second slide">
                        </div>
                     <?php }  ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
               </div>
                    </div>
                    <div class="col-12">
                      <div class="row">
                        <div class="col-3">
                          <div class="view overlay rounded z-depth-1 gallery-item">
                           
                            <div class="mask rgba-white-slight"></div>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="view overlay rounded z-depth-1 gallery-item">
                     
                            <div class="mask rgba-white-slight"></div>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="view overlay rounded z-depth-1 gallery-item">
                            
                            <div class="mask rgba-white-slight"></div>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="view overlay rounded z-depth-1 gallery-item">
                            
                            <div class="mask rgba-white-slight"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
          
                </div>
          
              </div>
              <div class="col-md-6">
          
                <h5><?php echo $listingData['listing_name']; ?></h5>
                <p class="mb-2 text-muted text-uppercase small">Category: <?php echo $rowCat['category_name'];?></p>
                <p class="mb-2 text-muted text-uppercase small">Rating: <?php echo round($rowRating['rating'], 1);?></p>
                <p class="mb-2 text-muted text-uppercase small">Average based on <?php echo $rowRating['numOfRatings']?> review(s).</p>
                
          
                
                <?php if ($listingData['buy_now']==1): ?>
                <p><span class="mr-1"><strong>Buy Now: &#163;<?php echo $listingData['buy_now_price']/100; ?></strong></span></p>
                <?php endif; ?>
                <p id="bidHighest"><span class="mr-1"><strong>Current Bid Price: &#163;<?php echo $listingData['bid_highest']/100; ?></strong></span></p>
                <p class="pt-1"><?php echo $listingData['description']; ?></p>
                <div class="table-responsive">
                  <table class="table table-sm table-borderless mb-0" style="text-align: left;">
                    <tbody>
                      <tr>
                        <th class="pl-0 w-25" scope="row"><strong>Seller:</strong></th>
                        <td><?php echo $row['forename']; ?> <?php echo $row['surname']; ?></td>
                      </tr>
                      <tr>
                        <th class="pl-0 w-25" scope="row"><strong>Condition:</strong></th>
                        <?php if ($listingData['condition_id']==1): ?>
                        <td>Perfect</td>
                        <?php endif; ?>
                        <?php if ($listingData['condition_id']==2): ?>
                        <td>Good</td>
                        <?php endif; ?>
                        <?php if ($listingData['condition_id']==3): ?>
                        <td>Poor</td>
                        <?php endif; ?>
                      </tr>
                      <tr>
                        <th class="pl-0 w-25" scope="row"><strong>Starting Bid:</strong></th>
                        <td><p id="startingBid">&#163;<?php echo $listingData['start_price']/100?></p></td>
                      </tr>
                      <tr>
                        <th class="pl-0 w-25" scope="row"><strong>Bids:</strong></th>
                        <td><p id="numBids"><?php echo $listingData['num_of_bids']?></p></td>
                      </tr>
                    
                    </tbody>
                    
                  </table>
                  
                </div>
                <div class="mt-3">
                  <p id="timer"><span>Time Remaining: </span></p>
                </div>
                <hr>
                <div class="table-responsive mb-2">
                  <table class="table table-sm table-borderless">
                    <tbody>
                      
                        <td class="pl-0">
                          <div class="def-number-input number-input safari_only mb-0">
                          <?php if( $_SESSION['isLoggedOn']): ?>
                          <label for="bidPrice">Enter Bid Amount</label>
                            <div class="input-group mb-0">
                              <div class="input-group-prepend">
                                <span class="input-group-text">&#163;</span>
                              </div>
                             <input type="number" id="bidPrice" name="bidPrice" class="form-control" aria-label="Amount" min='<?php if($listingData['start_price']>$listingData['bid_highest']):
                                                                                                                                 echo($listingData['start_price']/100);
                                                                                                                                 else:
                                                                                                                                   echo(($listingData['bid_highest']/100)+1); 
                                                                                                                                   endif; ?>'
                                                                                                                                  value='<?php if($listingData['start_price']>$listingData['bid_highest']):
                                                                                                                                 echo($listingData['start_price']/100);
                                                                                                                                 else:
                                                                                                                                   echo(($listingData['bid_highest']/100)+1); 
                                                                                                                                   endif; ?>'>
                              <?php endif; ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <?php if( $_SESSION['isLoggedOn']): ?>
                <?php if ($listingData['buy_now']==1): ?>
                  <button type="button" class="btn btn-primary btn-md mr-1 mb-2" onclick="buyNow()">Buy now</button>
                <?php endif; ?>
                <button type="button" class="btn btn-primary btn-md mr-1 mb-2" onclick="addBid()">Bid</button>
                <button type="button" class="btn btn-danger btn-md mr-1 mb-2" style="float: right;" onclick="complaint()">Complaint</button>
                 
                  <?php if( $indexVal == 0): ?>
                    <button type="button" class="btn btn-primary btn-md mr-1 mb-2" style="float: right;" onclick="addWishList()" id="addWishList">Add to Wishlist</button>
                  <?php else: ?>
                    <button type="button" class="btn btn-primary btn-md mr-1 mb-2" style="float: right;" onclick="removeWishList()" id="removeWishList">Remove from Wishlist</button>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            </div>
            <div class="modal" tabindex="-1" role="dialog" id="bidModal">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalheader"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p id="message"></p>
                  </div>
                
                </div>
              </div>
            </div>
          </section>
          </div>
          <script>
          document.addEventListener("DOMContentLoaded", function(event) { 
  
            var countDownDate = new Date('<?php echo $listingData['end_time'];?>').getTime();
            
            // Update the count down every 1 second
            var interval = setInterval(function() {
            
              // Get today's date and time
              var now = new Date().getTime();
            
              // Find the distance between now and the count down date
              var distance = countDownDate - now;
            
              // Time calculations for days, hours, minutes and seconds
              var days = Math.floor(distance / (1000 * 60 * 60 * 24));
              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
              // Display the result in the element with id="demo"
              if (days>=1){
                document.getElementById("timer").innerHTML = "Time Remaining: "+ days + " Days " + hours + " Hours ";
              }
              if(days==0 && hours >=1){
                document.getElementById("timer").innerHTML = "Time Remaining: "+ hours + " Hour(s) " + minutes + " Minute(s) " + seconds + " Second(s)";
              }
              if(days==0 && hours ==0 && minutes >= 1){
                document.getElementById("timer").innerHTML = "Time Remaining: "+ minutes + " Minute(s) " + seconds + " Second(s)";
              }
              if(days==0 && hours ==0 && minutes >= 1){
                document.getElementById("timer").innerHTML = "Time Remaining: "+ minutes + " Minute(s) " + seconds + " Second(s)";
              }
              if(days==0 && hours ==0 && minutes == 0 && seconds >=1){
                document.getElementById("timer").innerHTML = "Time Remaining: "+ seconds + " Second(s)";
              }
              // If the count down is finished, write some text
              if (distance < 0) {
                clearInterval(interval);
                document.getElementById("timer").innerHTML = "Time Remaining: EXPIRED";
              }
              document.getElementById("hideAll").style.display = "block"; 
            }, 1000);
            });
            </script>
            <script>
            $(document).ready(function(){
               setInterval(fetchBidCountData,1000);
               setInterval(fetchBidPriceData,1000);
               setInterval(checkListingForWinner,1000);
               setInterval(updateWallet, 1000);
               setInterval(isComplete, 1000);            
               
              });
            </script>
          <script>
            var highestBidAmount = <?php echo $listingData['bid_highest']; ?>;
            var userWallet;
            var listing_id = <?php echo $listingData['listing_id']; ?>;
            var buyNowVal = <?php echo $listingData['buy_now_price']; ?>;
            
            function complaint() {
              var complaint = prompt("Please enter your Complaint:", "");
              if (complaint == null || complaint == "") {
                
                document.getElementById("modalheader").innerHTML = 'Error Submitting Complaint';
                document.getElementById("message").innerHTML = 'Please Enter a valid Complaint.';
                $("#bidModal").modal();
                
              } else {
                $.ajax({
                  url: 'submitComplaint.php',
                  type: 'POST',
                  data:{
                    listing_id: listing_id,
                    complaint: complaint
                    
                  },
                  success: function(response){
                   // Perform operation on the return value
                     document.getElementById("modalheader").innerHTML = 'Sucess Submitting Complaint';
                     document.getElementById("message").innerHTML = 'Your complaint was successfully submitted.';
                     $("#bidModal").modal();
                    
                     
                  }
                 });
                
              }
              
            }
            
             function isComplete(){
             
                $.ajax({
                  url: 'isComplete.php',
                  type: 'POST',
                  data:{
                    listing_id: listing_id
                    
                  },
                  success: function(response){
                   // Perform operation on the return value
                    if(response == 3){
                      window.location.replace('https://student.csc.liv.ac.uk/~sgcdeega/index.php');
                    }
                     
                  }
                 });
             
               
             
             }
              
            
            function buyNow(){  
            if (buyNowVal <= <?php echo $_SESSION["walletAmount"]; ?>){
               $.ajax({
                url: 'buyNow.php',
                type: 'POST',
                data:{
                  listing_id: listing_id,
                  buyNowVal : buyNowVal
                },
                success: function(response){
                 // Perform operation on the return value
                  
                   updateWallet(2); 
                }
               });
             }else{
               document.getElementById("modalheader").innerHTML = 'Error Submitting Bid';
               document.getElementById("message").innerHTML = 'Insufficent Funds. Please deposit money within the <i>Account</i> Section.';
               $("#bidModal").modal();
             }
            }
            function fetchBidCountData(){
             var listing_id = <?php echo $listingData['listing_id']; ?>;
             $.ajax({
              url: 'getUpdatedbids.php',
              type: 'POST',
              data:{
                listing_id: listing_id   
              },
              success: function(response){
               // Perform operation on the return value
                 document.getElementById("numBids").innerHTML = response;
              }
             });
            }
            function fetchBidPriceData(){
             var listing_id = <?php echo $listingData['listing_id']; ?>;
             $.ajax({
              url: 'getUpdatedBidPrice.php',
              type: 'POST',
              data:{
                listing_id: listing_id   
              },
              success: function(response){
               // Perform operation on the return value
                
                 document.getElementById("bidHighest").innerHTML = '<strong>Current Bid Price: &#163;'+response/100+'</strong>'; 
              }
             });
             }
             function updateWallet(attribute){
             $.ajax({
              url: 'updateWallet.php',
              type: 'POST',
             
              success: function(response){
               // Perform operation on the return value
                 
                 document.getElementById("balance").innerHTML = 'Wallet Balance: &#163;'+response/100;
                 if(attribute==2){
                   document.getElementById("modalheader").innerHTML = 'Success ';
                   document.getElementById("message").innerHTML = 'Your bid was placed successfully! ';
                   $("#bidModal").modal();
                 }
              }
             });
            }
            function addBid(){
             var listing_id = <?php echo $listingData['listing_id']; ?>;
             var bid_amount = document.getElementById("bidPrice").value;
             updateWallet();
             if (bid_amount*100 < <?php echo $_SESSION["walletAmount"]; ?>){
               if(bid_amount > highestBidAmount/100){
                 $.ajax({
                  url: 'addBid.php',
                  type: 'POST',
                  data:{
                    listing_id: listing_id,
                    bid_amount: bid_amount
                  },
                  success: function(response){
                   // Perform operation on the return value
                     
                     updateWallet(2);
                  }
                 });
               }else{
               document.getElementById("modalheader").innerHTML = 'Error Submitting Bid';
               document.getElementById("message").innerHTML = 'The bid entered was too low. Please submit a bid higher than &#163;'+highestBidAmount/100+'.';
               $("#bidModal").modal();
               }
             }else{
               document.getElementById("modalheader").innerHTML = 'Error Submitting Bid';
               document.getElementById("message").innerHTML = 'Insufficent Funds. Please deposit money within the <i>Account</i> Section.';
               $("#bidModal").modal();
             }
            }
            
            function checkListingForWinner(){
            var listing_id = <?php echo $listingData['listing_id']; ?>;
             $.ajax({
              url: 'checkListing.php',
              type: 'POST',
              data:{
                listing_id: listing_id   
              },
              success: function(response){
               // Perform operation on the return value
                 var data = $.parseJSON(response);
                 
                 if(response=='Success' && response!=='Active'){
                   alert(response);
                 }
                 if(response=='Fail'&& response!=='Active'){
                   alert(response);
                 }
                 if(data.Response=='Unsuccessful'&& response!=='Active'){
                   alert(response);
                   document.getElementById("balance").innerHTML = 'Wallet Balance: &#163;'+data.Content/100;
                 }
                 
              }
             });
             
            }
            function addWishList() {
             
 	         	$("#addWishList").attr("disabled", "disabled");
	              var listing_id = <?php echo $listingData['listing_id']; ?>;
          			$.ajax({
                    url:'add_to_wishlist.php',
                    method:'POST',
                    data:{
                        listing_id: listing_id
                  
                    },
                   success:function(data){
                       alert('Added to Wishlist');
                   }
                });
          	}
           
           function removeWishList(){
             $("#removeWishList").attr("disabled", "disabled");
	              var listing_id = <?php echo $listingData['listing_id']; ?>;
          			$.ajax({
                    url:'remove_from_wishlist.php',
                    method:'POST',
                    data:{
                        listing_id: listing_id
                  
                    },
                   success:function(data){
                       alert('Removed from Wishlist');
                   }
                });
           
           }
          </script>

      
        
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
          feather.replace()
        </script>     
    
  
      </body>
      
</html>
