<!DOCTYPE html>

<html>
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link href="bootstrap.min.css" rel="stylesheet">
  <script src="jquery.min.js" async></script>
  <script src="bootstrap.min.js" async></script>
  <script src="jquery.validate.min.js" async></script>

  </head>
  <?php

    
    $filename = 'universities.txt';
    $eachlines = file($filename, FILE_IGNORE_NEW_LINES);
  
  ?>
  <body>
    <div class="login-form">
        <form action="register_submit.php" class="needs-validation" novalidate name="reg_form" method="POST">
          <div class="avatar" style="background: #d13b3e;"><i class="material-icons" style="background: #d13b3e;">&#xE7FF;</i></div>
            <h4 class="modal-title">Register</h4>
             <div class="row">
                <div class="form-group col-md-6">
                  <label class="control-label" for="forename">Forename</label>
                  <input type="text" class="form-control" id="forename" placeholder="Forename" required="required" name="forename">
                  <div class="valid-feedback">
                  </div>
                  <div class="invalid-feedback">
                    Please enter a forename.
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label class="control-label" for="surname">Surname</label>
                  <input class="form-control" id="surname" placeholder="Surname" required="required" name="surname">
                  <div class="valid-feedback">
                  </div>
                  <div class="invalid-feedback">
                    Please enter a surname.
                  </div>
                </div>
              </div>   
              <div class="form-group">
                  <label class="control-label" for="email">Email Address</label>
                  <input class="form-control" placeholder="Email" id="email" required="required" pattern=".{1,}@[^.]{1,}.ac.uk$" type="email" name="email" >
                  <div class="valid-feedback">
                  </div>
                  <div class="invalid-feedback">
                    Please enter a valid email address.
                  </div>
              </div>
              <div class="form-group">
                  <label class="control-label" for="password">Password</label>
                  <input type="password" class="form-control" id="password" placeholder="Password" required="required" name="password" >
              </div>
              <div class="form-group">
                  <label class="control-label" for="password_dup">Confirm Password</label>
                  <input type="password" class="form-control" placeholder="Confirm Password" required="required" name="password_dup" id="password_dup" >
                  <div id="confirm_password"></div>
              </div>
              <div class="form-group">
                <label for="university">Select Current Institution</label>
                <select class="form-control" id="university" required="required" name="university">
                 <option selected="true" disabled="disabled">Please Select</option>
                 <?php foreach($eachlines as $lines){
                      echo "<option value='$lines'".$lines."'>$lines</option>";
                  }?>
                </select>
                <div class="invalid-feedback">
                    Please select your Institution.
                </div>
              </div>
              <div class="form-group">
                  <label class="control-label" for="address">Address</label>
                  <input class="form-control" id="address" placeholder="Address" required="required" name="address">
                  <div class="valid-feedback">
                  </div>
                  <div class="invalid-feedback">
                    Please enter a valid address.
                  </div>
              </div>
              <div class="form-group">
                  <label class="control-label" for="postcode">Postcode</label>
                  <input class="form-control" id="postcode" placeholder="Postcode" required="required" name="postcode" required minlength="6" maxlength="8">
                  <div class="valid-feedback">
                  </div>
                  <div class="invalid-feedback">
                    Please enter a valid postcode.
                  </div>
              </div>
              <input type="submit" class="btn btn-primary btn-block btn-lg" style="background: #d13b3e;" value="Register" name="register">
          </form>

          <div class="text-center small" >Already have an account? <a href="login.html" style="color: #d13b3e;">Login</a></div>
      </div>
    </div>

  </div>

  <script>
    function checkPasswordMatch() {
        var password = $("#password").val();
        var confirmPassword = $("#password_confirm").val();
        if (password != confirmPassword)
            var element = document.getElementById("confirm_password");
            element.classList.remove("valid-feedback");
            element.classList.add("invalid-feedback");
            
        else
            var element = document.getElementById("confirm_password");
            element.classList.remove("-feedback");
            element.classList.add("invalid-feedback");
    }
    $(document).ready(function () {
       $("#password_confirm").keyup(checkPasswordMatch);
    });
    </script>
  <script>
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
  
  </script>
  </body>
</html>
