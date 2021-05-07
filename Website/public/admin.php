<?php
  session_start();
  include('config.php');

  $sql = "SELECT complaint_id, Listing.listing_id, listing_name, description, complaint, (SELECT images FROM Listing WHERE Listing.listing_id = Complaints.listing_id) AS images FROM Complaints, Listing WHERE Complaints.listing_id = Listing.listing_id AND Complaints.active_comp = 0 AND Listing.status_id = 1 ORDER BY complaint_id;";

  $result = mysqli_query($conn, $sql);

  $listing_data = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $listing_data[] = $row;
    }

   $json = json_encode($listing_data, JSON_PRETTY_PRINT);

   $file_name = date('d-m-y_test') . '.json';
   file_put_contents($file_name, $json);

   $decoded_array = json_decode($json, true);
   
   $activeComplaints = count($decoded_array);

?>



<?php function createCard(array $jsonArr) { ?>

      <?php 
              $firstFile = scandir($jsonArr[0]["images"], SCANDIR_SORT_ASCENDING)[2];     
       ?>

<div class="card w-100 align-item-center mb-4" style="max-height: 25rem;">
    <div class="card-header w-100">
        <div class="miniComplaints">
            <h5> Complaint ID: <?= $jsonArr[0]["complaint_id"]   ?></h5><span><h5>Listing ID: <?= $jsonArr[0]["listing_id"] ?></h5></span>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-2">
            <img  src="<?= $jsonArr[0]["images"].$firstFile?>" class="img-fluid" alt="" width="170" height="170">
        </div>
        <div class="col-5">
            <div class="card-block px-2 col-9">
                <h5 class="mb-4 mt-2">Complaint Description:</h5>
                <p class="card-text"><?= $jsonArr[0]["complaint"]?></p>
            </div>
        </div>
        <div class="col-5">
            <div class="card-block text-center px-2">
                <h5 class="mb-4 mt-2"><?= $jsonArr[0]["listing_name"]?> </h5>
                <p class="card-text"> <?= $jsonArr[0]["description"] ?> </p>
                <hr>
                <a href="complaint_allow_listing.php" class="btn btn-primary">Allow Listing</a>
                <a href="complaint_remove_listing.php" class="btn btn-primary">Remove Listing</a>
            </div>
        </div>
    </div>
<?php } ?>

    <?php function createFootCard(array $jsonArr){ ?>
        <div class="card-footer   text-muted">
            <div class="miniComplaints">
                Complaint: <?= $jsonArr["complaint_id"]?> <span> Listing: <?= $jsonArr["listing_id"]?></span>
            </div>
        </div>
   <?php }?>



<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css">
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="jquery.validate.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.html">UniBid</a>
     
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
        <?php if(isset( $_SESSION['isLoggedOn'])): ?>
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
              <?php if( isset($_SESSION['isLoggedOn'])): ?>
                <h5 class="text-center"><?php
                    echo $_SESSION["forename"];
                    echo " ";
                    echo $_SESSION["surname"];
                  ?></h5>
                <h7 class="text-center"><?php
                    echo "Admin";
                  ?></h7>
                <div class="border-top my-4"></div>
              <?php endif; ?>
              <li class="nav-item">
                <a class="nav-link active" href="admin.php">
                  <span data-feather="edit"></span>
                  Manage Complaints <span class="sr-only"></span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="transaction.php">
                  <span data-feather="activity"></span>
                  Transaction History
                </a>
              </li>
            </ul>
          </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-4 mb-3 border-bottom">
            <span><h1 class="h2">Complaints</h1>
            <p class="mb-2 text-muted text small">Active Complaints: <?php echo $activeComplaints; ?></p></span>
            <div class="btn-toolbar mb-2 mb-md-0">
            </div>
          </div>
            <?php
               if(!empty($decoded_array)):
                  createCard($decoded_array);
               endif;

            ?>
            <?php
            foreach (array_slice($decoded_array, 1) as $complaint_listing){

                createFootCard($complaint_listing);
            }
            ?>



          </div>

        </div>


        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
          feather.replace()
        </script>

      </body>
</html>
