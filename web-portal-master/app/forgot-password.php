<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once("layouts/header.php") ?>
</head>
<body class="login-page">
  <section class="h-100">
    <div class="container h-100">
      <div class="row  h-100">
          <div class="brand-lg">
            <a href="index.php">
              <img src="assets/images/logoteam-alpha.png">
            <a href="index.php">
          </div>
          <div class="card-wrapper">
          <div class="brand">
            <a href="index.php">
              <img src="assets/images/logoteam-alpha.png">
            </a>
          </div>
          <div class="card fat">
            <div class="card-body">
              <h4 class="card-title">Forgot Password</h4>
              <div class="text-center">
              <p>Please enter your email address to reset your password</p>
              </div>
		    
		    	<div class="form-group col-md-8">
					<div id="result">			
					</div>
				</div>

                <div class="form-row form-group">
                  <label for="email">Email Address</label>
                  <input class="form-control" name="email" id="email" type="text"  placeholder="Email">
                </div>
                <div class="form-row no-margin">
                  <button type="submit" class="btn btn-success btn-block" onclick="reset()">
                    Reset Password
                  </button>
                </div>
                <div class="margin-top20 text-center">
                  <a href="login.php">Login now</a>
                </div>

            </div>
          </div>
          <div class="footer">
            Copyright &copy; 2018 &mdash; UPOU-CMSC-207-Team-Alpha 
          </div>
        </div>
      </div>
    </div>
  </section>
	<script src="vendor/components/jquery/jquery.min.js"></script>
      <script>
      var reset = function () {
      var email = $('#email').val();
      
     
        $.ajax({
          type: "POST",
          url: "/api/admin/forgotpass.php",
          data: JSON.stringify({
            email: email,
          }),
          success: function (response) {
    	  $("#result").removeClass();
          $('#result').addClass('alert alert-success');
          $('#result').html("Successful Message:" + response["message"] + ". ID: " + response["id"]);
        },
        error: function (response) {
    	  $("#result").removeClass();
          $('#result').addClass('alert alert-danger');
          $('#result').html("Error Message: " + response.responseJSON["message"]);
          },
          contentType: "application/json; charset=UTF-8",
          dataType: "json"
        });
    }
    
      </script>

</body>
</html>
