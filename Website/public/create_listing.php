<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css">
    <script src="jquery.min.js"></script>

    <link href="bootstrap.min.css" rel="stylesheet">

    <script src="bootstrap.min.js"></script>
    <script src="jquery.validate.min.js"></script>

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
                <a class="nav-link" href="mylistings.php">Active Listings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Previous Listings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="create_listing.php">Create Listing</a>
              </li>
            </ul>
            <div class="row justify-content-center align-items-center">
            <form action="upload.php" method="post" enctype="multipart/form-data" class="form-container  w-75 ">
              <label for="listingName">Listing Name</label>
              <div class="input-group mb-3">
                <input type="text" id="listingName" name="listingName" class="form-control" placeholder="Listing Name" aria-label="Listing Name" aria-describedby="basic-addon1">
              </div>
              <label for="description">Description</label>
              <div class="input-group mb-3">
                <textarea class="form-control" id="listingDesc" name="listingDesc" placeholder="Item Description" aria-label="With textarea"></textarea>
              </div>
              <label for="listingDuration">Select a Category</label>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="listingCategory">Category</label>
                  </div>
                  <select class="custom-select" name="listingCategory" id="listingCategory">
                    <option value="0">Please Select a Category</option>

                  </select>
                </div>
              <div class="form-row">
                  <div class="col-md-6 mb-3">
                  <label for="listingBidPrice">Starting Bid Price</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">&#163;</span>
                      </div>
                      <input type="text" id="listingBidPrice" name="listingBidPrice" class="form-control" aria-label="Amount ">

                    </div>
                    <button type="button" style="background:none;border:none;outline: none;" data-toggle="modal" data-target="#priceHelp"><small class="text-muted">Need help with deciding a price?</small></button>

                  </div>
                  <div class="col-md-6 mb-3">
                  <label for="listingBuyPrice">Buy Now Price</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text">&#163;</span>
                      </div>
                      <input type="text" id="listingBuyPrice" name="listingBuyPrice" class="form-control" aria-label="Amount" disabled=disabled>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="buyNowCheck" name="buyNowCheck" onclick="EnableDisableTextBox(this)">
                      <label class="form-check-label" for="buyNowCheck">
                        Include Buy Now Price
                      </label>
                    </div>
                  </div>
                </div>
                <label for="listingDuration">Select Duration of Listing</label>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="listingDuration">Duration</label>
                  </div>
                  <select class="custom-select" name="listingDuration" id="listingDuration">
                    <option value="5">Quick - 5 Hours</option>
                    <option value="24">Short - 24 Hours</option>
                    <option value="72">Medium - 3 Days</option>
                    <option value="168">Long - 7 Days</option>
                  </select>
                </div>
                <label for="image">Select Images for Upload</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Upload</span>
                  </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="image" name="photo" multiple>
                    <label class="custom-file-label" id="image" for="image">Choose file</label>

                  </div>


                </div>

                 <p class="text-center" id="imageCount"></p>
                <input type="submit" class="btn btn-primary btn-block btn-lg" value="Create Listing" name="submit"><br>

              </form>




         </div>
         <div class="modal fade" id="priceHelp" tabindex="-1" role="dialog" aria-labelledby="priceHelp" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="priceHelpTitle">Price Helper</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                Successful listings of [Kettles] have started from [startPrice] and have sold from [finalPrice].
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              </div>
            </div>
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


        <script type="text/javascript">
        var limit = 5;
        $(document).ready(function(){
            $('#image').change(function(){
                var files = $(this)[0].files;
                if(files.length > limit){
                    document.getElementById('imageCount').innerHTML = "";
                    $('#image').val('');
                    return false;
                }else{
                    document.getElementById('imageCount').innerHTML = "";
                    if(files.length == 1){
                      document.getElementById('imageCount').innerHTML += "You have selected "+files.length+" image.";
                    }else{
                      document.getElementById('imageCount').innerHTML += "You have selected "+files.length+" images.";
                    }

                    return true;
                }
            });
        });
        </script>



        <script type="text/javascript">
           function EnableDisableTextBox(buyNowCheck) {
             if(document.getElementById('buyNowCheck').checked)
              document.getElementById('listingBuyPrice').disabled=false;
             else
              document.getElementById('listingBuyPrice').disabled=true;
           }
         </script>
         <script src="../assets/vendor/dropzone/js/dropzone.min.js"></script>

<!--Dropzone init-->

<script src="../assets/js/demo/dropzone/dropzone.min.js"></script>

        <script>
          feather.replace()
        </script>
      </body>
</html>
