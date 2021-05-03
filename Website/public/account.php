<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css">
    <link href="bootstrap.min.css" rel="stylesheet">
    <script src="jquery.min.js" async></script>
    <script src="bootstrap.min.js" async></script>
    <script src="jquery.validate.min.js" async></script>
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
                <h7 class="text-center" id="balance">Wallet Balance: &#163;<?php echo ($_SESSION["walletAmount"]/100);?></h7>
                <div class="border-top my-4"></div>
              <?php endif; ?>
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
              <li class="nav-item active">
                <a class="nav-link active" href="account.php">
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
             <h1 class="h2">Account</h1>
             <div class="btn-toolbar mb-2 mb-md-0">
             </div>
           </div>
           <main class="content">
				<div class="container-fluid p-0">

					
					<div class="row mb-4">
						<div class="col-12 col-sm-6 col-xxl d-flex">
							<div class="card illustration flex-fill mb-4 ">
								<div class="card-body p-0 d-flex flex-fill">
									<div class="row g-0 w-100">
										<div class="col-6">
											<div class="illustration-text p-3 m-1">
												<h4 class="illustration-text" id="activeListings">0</h4>
												<p class="mb-0">Active Listings</p>
											</div>
										</div>
				
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-6 col-xxl d-flex">
							<div class="card flex-fill mb-4">
								<div class="card-body py-4">
									<div class="d-flex align-items-start">
										<div class="flex-grow-1">
											<h3 class="mb-2" id="earnings">&#163;0</h3>
											<p class="mb-2">Total Earnings</p>
											<div class="mb-0">
												<span class="badge badge-soft-success me-2 text-success" id="perChangeEarnt"> <i class="mdi mdi-arrow-bottom-right"></i> 0% </span>
												<span class="text-muted">Since last week</span>
											</div>
										</div>
									
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-6 col-xxl d-flex">
							<div class="card flex-fill">
								<div class="card-body py-4">
									<div class="d-flex align-items-start">
										<div class="flex-grow-1">
											<h3 class="mb-2" id="listingsWon">0</h3>
											<p class="mb-2">Listings Won</p>
							
										</div>
										
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-6 col-xxl d-flex">
							<div class="card flex-fill">
								<div class="card-body py-4">
									<div class="d-flex align-items-start">
										<div class="flex-grow-1">
											<h3 class="mb-2" id="totalSpent">&#163;0</h3>
											<p class="mb-2">Total Spent</p>
											<div class="mb-0">
												<span class="badge badge-soft-success me-2 text-success" id="perChangeSpent" <i class="mdi mdi-arrow-bottom-right"></i> +0% </span>
												<span class="text-muted">Since last week</span>
											</div>
										</div>
									
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row card-group">
						<div class="col-12 col-lg-8 d-flex">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<div class="card-actions float-end">
									  
									</div>
									<h5 class="card-title mb-0">Account Details</h5>
								</div>
                                              
								<div class="card-body d-flex w-100">
									<div class="mx-auto w-75">
                    <form>
                       <div class="row">
                        <div class="form-group col">
                          <label for="firstname">First Name</label>
                          <input type="text"  readonly class="form-control" id="firstname" placeholder="Christian" style="background-color:transparent;">
                        </div>
                        <div class="col">
                          <label for="surname">Last Name</label>
                          <input type="text" readonly class="form-control" placeholder="Deegan"  style="background-color:transparent;">
                        </div>
                      </div>
                      <div class="form-row w-100">
                        <div class="form-group w-100">
                          <label for="inputEmail4">Email</label>
                          <input type="email" readonly class="form-control" id="inputEmail4" placeholder="test@test.com"  style="background-color:transparent;">
                        </div>
                  
                      </div>
                      <div class="form-row w-100">
                        <div class="form-group w-100">
                          <label for="Institution">Institution</label>
                          <input type="text" readonly class="form-control" id="Institution" placeholder="University of Liverpool"  style="background-color:transparent;">
                        </div>
                  
                      </div>
                      <div class="row">
                        <div class="form-group col-9">
                          <label for="address">Address</label>
                          <input type="text"  readonly class="form-control" id="address" placeholder="19 Tudor Road" style="background-color:transparent;">
                        </div>
                        <div class="col-3">
                          <label for="postcode">Postcode</label>
                          <input type="text" readonly class="form-control" placeholder="L233DH"  id="postcode" style="background-color:transparent;">
                        </div>
                      </div>
                    </form>

									</div>
                                            
								</div>
                <div class="card-footer text-center">
                    <button class="btn btn-sm btn-primary" type="button" onclick="updateModal()">
                        <i data-feather="user-plus"></i> Update Details</button>
                    <button class="btn btn-sm btn-danger" type="button" onclick="verifyDelete()">
                        <i data-feather="delete"></i> Delete Account</button>
                </div>   
							</div>
                        
						</div>
						<div class="col-12 col-lg-4 d-flex">
              <form>
							<div class="card flex-fill w-100">
								<div class="card-header">
									
									<h5 class="card-title mb-0">Wallet</h5>
								</div>
                  <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" id="name" type="text" placeholder="Enter Name on Card">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ccnumber">Credit Card Number</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" placeholder="0000 0000 0000 0000"  maxlength="19" id="cardNum">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i data-feather="credit-card"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="ccmonth">Month</label>
                            <select class="form-control" id="ccmonth">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="ccyear">Year</label>
                            <select class="form-control" id="ccyear">
                                <option>2021</option>
                                <option>2022</option>
                                <option>2023</option>
                                <option>2024</option>
                                <option>2025</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="cvv">CVV/CVC</label>
                                <input class="form-control" id="cvv" type="text" minlength="3" maxlength="3" placeholder="123">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Amount</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">	&#163;</span>
                                  </div>
                                  <input type="number" class="form-control" placeholder="0" min='0' id="amount" aria-label="amount" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button class="btn btn-sm btn-success float-right" type="button" onclick="depositMoney()">
                        <i data-feather="download"></i> Deposit</button>
                        <button class="btn btn-sm btn-success float-right mr-2" type="button" onclick="withdrawMoney()">
                        <i data-feather="upload"></i> Withdraw</button>
                    <button class="btn btn-sm btn-danger" type="reset">
                        <i data-feather="refresh-ccw"></i> Reset</button>
                </div>                                
              </div> 
            </div>                                 
					</div>
        </form>

				</div>
			</main>
      <div class="modal" tabindex="-1" role="dialog" id="updateModal">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalheader">Update Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <form action="updateDetails.php" method="POST">
                       <div class="row">
                        <div class="form-group col">
                          <label for="firstname">First Name</label>
                          <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Christian" autocomplete="off" style="background-color:transparent;">
                        </div>
                        <div class="col">
                          <label for="surname">Last Name</label>
                          <input type="text" class="form-control" placeholder="Deegan" name="lastname" autocomplete="off" style="background-color:transparent;">
                        </div>
                      </div>
                      <div class="form-row w-100">
                        <div class="form-group w-100">
                          <label for="inputEmail4">Email</label>
                          <input type="email" readonly class="form-control" id="inputEmail4" placeholder="test@test.com"  style="background-color:transparent;">
                        </div>
                  
                      </div>
                      <div class="form-row w-100">
                        <div class="form-group w-100">
                          <label for="Institution">Institution</label>
                          <input type="text" readonly class="form-control" id="Institution" placeholder="University of Liverpool"  style="background-color:transparent;">
                        </div>
                  
                      </div>
                      <div class="row">
                        <div class="form-group col-9">
                          <label for="address">Address</label>
                          <input type="text"   class="form-control" id="address" name="address" autocomplete="off" placeholder="19 Tudor Road" style="background-color:transparent;">
                        </div>
                        <div class="col-3">
                          <label for="postcode">Postcode</label>
                          <input type="text"  class="form-control" placeholder="L233DH" name="postcode" autocomplete="off" id="postcode" style="background-color:transparent;">
                        </div>
                      </div>
                    
                    <div class="modal-footer text-center">
                    <button class="btn btn-sm btn-primary" type="submit">
                        Update Details</button>
                    
                    </div> 
                    </form>
                  
                  </div>
                
                </div>
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
       <div class="modal" tabindex="-1" role="dialog" id="deleteModal">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalheader">Delete Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <p id="message">To delete your account, please enter the email in use. (Case-Sensitive)</p>
                    <form action="deleteAccount.php">
                      <input type="text" class="form-control" id="confirmEmail" pattern="" autocomplete="off" oninvalid="try{setCustomValidity('Please Enter the Correct Email')}catch(e){}" required>
                      <button type="submmit" class="btn btn-sm btn-danger mt-3">Delete Account</button>

                    </form>

                  </div>
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
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
          feather.replace()
        </script>
        <script>
            $(document).ready(function(){
               setInterval(fetchActiveListings,1000);   
               setInterval(fetchListingsWon,1000);  
               setInterval(fetchTotalEarnt,1000);
               setInterval(fetchTotalSpent,1000); 
             });
        </script>
        <script>
        function updateModal(){
           $("#updateModal").modal();
        }
        function verifyDelete(){
             $.ajax({
              url: 'verifyDelete.php',
              type: 'POST',
              success: function(response){
               // Perform operation on the return value
               var element = document.getElementById("confirmEmail");
               element.setAttribute("pattern",response);
               $("#deleteModal").modal();
              }
             });
        }
        function depositMoney(){   
          var deposit = document.getElementById("amount").value;
             $.ajax({
              url: 'depositMoney.php',
              type: 'POST',
              data:{
                deposit: deposit   
              },
              success: function(response){
               // Perform operation on the return value
               document.getElementById("modalheader").innerHTML = 'Success';
               document.getElementById("message").innerHTML = 'Your deposit was successfuly placed within your account';
               $("#bidModal").modal();
               document.getElementById("balance").innerHTML = 'Wallet Balance: &#163;'+response/100;  
              }
          });
        }
        function withdrawMoney(){   
          var withdraw = document.getElementById("amount").value;
          if(withdraw == 0){
            document.getElementById("modalheader").innerHTML = 'Failed';
            document.getElementById("message").innerHTML = 'Please enter a value greater than &#163;0 to continue';
            $("#bidModal").modal();
          }
          if(withdraw > <?php echo $_SESSION["walletAmount"]/100 ?>){
             document.getElementById("modalheader").innerHTML = 'Failed';
             document.getElementById("message").innerHTML = 'You are attempting to withdraw more than is available within your wallet. Please try again.';
             $("#bidModal").modal();
          }
          if(withdraw < <?php echo $_SESSION["walletAmount"]/100 ?>&&withdraw >0){
            $.ajax({
              url: 'withdrawMoney.php',
              type: 'POST',
              data:{
                withdraw: withdraw   
              },
              success: function(response){
               // Perform operation on the return value
               document.getElementById("modalheader").innerHTML = 'Success';
               document.getElementById("message").innerHTML = 'Your money was successfuly withdrawn from your account';
               $("#bidModal").modal();
               document.getElementById("balance").innerHTML = 'Wallet Balance: &#163;'+response/100;  
              }
            });
          }
             
        }
        function fetchActiveListings(){
             $.ajax({
              url: 'fetchActiveListings.php',
              type: 'POST',
              success: function(response){
               // Perform operation on the return value
               document.getElementById("activeListings").innerHTML = response;  
              }
             });
        }
        function fetchListingsWon(){
             $.ajax({
              url: 'fetchListingsWon.php',
              type: 'POST',
              success: function(response){
               // Perform operation on the return value
               document.getElementById("listingsWon").innerHTML = response;  
              }
             });
        }
        function fetchTotalEarnt(){
             $.ajax({
              url: 'fetchTotalEarnt.php',
              type: 'POST',
              success: function(response){
               // Perform operation on the return value
               var data = $.parseJSON(response);
               
               document.getElementById("earnings").innerHTML = "&#163;"+data.totalEarnt; 
               if(data.percentChange=='N/A'){
                 var element = document.getElementById("perChangeEarnt");
                 element.classList.remove('text-success');
                 element.classList.add("text-primary");
                 document.getElementById("perChangeEarnt").innerHTML = data.percentChange;  
               }
               if(data.percentChange<0){
                 element.classList.remove('text-success');
                 element.classList.add("text-danger");
                 document.getElementById("perChangeEarnt").innerHTML = '-'+data.percentChange+'%'; 
              } if(data.percentChange>0){
                document.getElementById("perChangeEarnt").innerHTML = '+'+data.percentChange+'%';
              } 
              }
             });
        }
        function fetchTotalSpent(){
             $.ajax({
              url: 'fetchTotalSpent.php',
              type: 'POST',
              success: function(response){
               // Perform operation on the return value
               var data = $.parseJSON(response);
                 
               document.getElementById("totalSpent").innerHTML = "&#163;"+data.totalSpent;
               if(data.percentChange=='N/A'){
                 var element = document.getElementById("perChangeSpent");
                 element.classList.remove('text-success');
                 element.classList.add("text-primary");
                 document.getElementById("perChangeSpent").innerHTML = data.percentChange;  
               }
               if(data.percentChange<0){
                 element.classList.remove('text-success');
                 element.classList.add("text-danger");
                 document.getElementById("perChangeSpent").innerHTML = '-'+data.percentChange+'%'; 
              } if(data.percentChange>0){
                document.getElementById("perChangeSpent").innerHTML = '+'+data.percentChange+'%';
              }
              }
             });
        }

        </script>
        <script>
          $(document).ready(function(){

            //For Card Number formatted input
            var cardNum = document.getElementById('cardNum');
            cardNum.onkeyup = function (e) {
            if (this.value == this.lastValue) return;
            var caretPosition = this.selectionStart;
            var sanitizedValue = this.value.replace(/[^0-9]/gi, '');
            var parts = [];
            
            for (var i = 0, len = sanitizedValue.length; i < len; i +=4) { parts.push(sanitizedValue.substring(i, i + 4)); } for (var i=caretPosition - 1; i>= 0; i--) {
                var c = this.value[i];
                if (c < '0' || c> '9') {
                    caretPosition--;
                    }
                    }
                    caretPosition += Math.floor(caretPosition / 4);
            
                    this.value = this.lastValue = parts.join(' ');
                    this.selectionStart = this.selectionEnd = caretPosition;
                    }
            
                    
                    var cvv_Value = document.getElementById('cvv');
                    cvv_Value.onkeyup = function (e) {
                      if (this.value == this.lastValue) return;
                      var caretPosition = this.selectionStart;
                      var sanitizedValue = this.value.replace(/[^0-9]/gi, '');
                      var parts = [];
              
                      for (var i = 0, len = 3; i < len; i +=3) {
                       parts.push(sanitizedValue.substring(i, i + 3)); 
                       } 
                      
                      caretPosition += Math.floor(caretPosition / 2);
                      
                      this.value = this.lastValue = parts.join(' ');
                      this.selectionStart = this.selectionEnd = caretPosition;
                      
                  }

                });
        </script>
      </body>
</html>
