<?php  
  session_start();
  include('config.php');
  
  $selectedlistingID = $_POST['reviewListing'];
  
  $sql = "SELECT  * FROM Listing JOIN User WHERE status_id='3' AND listing_id= '$selectedlistingID' AND Listing.seller_id = User.user_id GROUP BY User.user_id, Listing.listing_id, Listing.seller_id ORDER BY end_time";
  $select = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($select);


?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css">
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="jquery.min.js" async></script>
    <script src="bootstrap.min.js" async></script>
    
    <style>
      .rating {
      float:left;
    }

    .rating:not(:checked) > input {
        position:absolute;
        top:-9999px;
        clip:rect(0,0,0,0);
    }

    .rating:not(:checked) > label {
        float:right;
        width:1em;
        /* padding:0 .1em; */
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:300%;
        /* line-height:1.2; */
        color:#ddd;
    }

    .rating:not(:checked) > label:before {
        content: '\2605';
    }

    .rating > input:checked ~ label {
        color: dodgerblue;
        
    }

    .rating:not(:checked) > label:hover,
    .rating:not(:checked) > label:hover ~ label {
        color: dodgerblue;
        
    }

    .rating > input:checked + label:hover,
    .rating > input:checked + label:hover ~ label,
    .rating > input:checked ~ label:hover,
    .rating > input:checked ~ label:hover ~ label,
    .rating > label:hover ~ input:checked ~ label {
        color: dodgerblue;
        
    }

    .rating > label:active {
        position:relative;
        top:2px;
        left:2px;
    }
    </style>
  </head>
  <body>

  <div class = "mt-4">
    <div class="container-fluid">
      <div class="row">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-6 mx-auto">
                        <div class="card text-center">
                            <div class="card-header w-100">
                                <h5><i data-feather="alert-circle" alt="alert-circle" style="width: 30px; height: 30px"></i>Listing Review</h5>
                            </div>
                            <div class="card-body">
                            <div class="container">
                                <h5>Listing Details</h5>
                                <hr>
                                <p class="card-text"><strong>Seller: </strong><?php echo $row['forename']; ?> <?php echo $row['surname']; ?></p>
                                <p class="card-text"><strong>Amount Spent:</strong> &#163;<?php echo $row['bid_highest']/100; ?></p>
                                <p class="card-text"><strong>Date Won:</strong> <?php echo $row['end_time']; ?></p>
                                <p class="card-text">Please select a Rating to give to the user based upon the listing.
                                </p>
                            </div>  
                            <div class="container">
                           	  <div class="row">
                              	<div class="rating" style="display: block; margin: auto;">
                                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Meh"></label>
                                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Kinda bad"></label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Kinda bad"></label>
                                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Sucks big tim"></label>
                                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Sucks big time"></label>
                                  </div>
                              	</div>
                              </div>
                                <a href="wonauctions.php" class="btn btn-primary">Return</a>
                                <button type="button" class="btn btn-primary" onclick="reviewFunction()">Submit Review</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
  </div>
  <div class="modal" tabindex="-1" role="dialog" id="modal">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalheader">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p id="message">Your review was successfully placed.</p>
                    <a href="wonauctions.php" class="btn btn-primary">Return</a>
                  </div>
                
                </div>
        </div>
  </div>
  <script>
    function reviewFunction(){
      var radioVal = document.getElementsByName('rating');
      var listing_id = <?php echo $selectedlistingID ?>;
      var rating;
      var seller_id = <?php echo $row['seller_id'];?> 

      for (var i = 0, length = radioVal.length; i < length; i++) {
        if (radioVal[i].checked) {
          
          rating = (radioVal[i].value);
          break;
        }
      }
      
      if(rating!=null){
          $.ajax({
            url: 'addUserRating.php',
            type: 'POST',
            data:{
              listing_id: listing_id,
              rating: rating,
              seller_id: seller_id 
            },
            success: function(response){
               $("#modal").modal();
               
               
              
                         
          }
      });
    }
   }

  </script>
 </body>
</html>