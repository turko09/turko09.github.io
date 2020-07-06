<?php
session_start();
if (!isset($_SESSION["admin_id"]) || !isset($_SESSION["admin_name"]))
{
   header("location: logout.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once("layouts/header.php") ?>
  <script src="assets/js/common.js"></script>
  <script src="assets/js/register.js"></script>
  <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
  <script src="assets/lib/jquery/js/jquery.min.js"></script>
</head>
<body class="login-page">
  <section class="h-100">
    <div class="container h-100">
      <div class="row  h-100">
          <div class="brand-lg">
            <a href="index.php">
              <img src="assets/images/logoteam-alpha.png">
            </a>
          </div>
          <div class="card fat">
            <div class="card-body">
                            <h4 class="card-title">New Administrator Registration</h4>
			  
				<div class="form-group col-md-8">
					<div id="result">			
					</div>
				</div>
			  
                <div class="form-group">
                  <div class="form-row">
                    <div class="col-md-6 form-group">
                      <label for="firstname">Firstname</label>
                      <input class="form-control" name="firstname" id="firstname" type="text"  placeholder="Firstname">
                    </div>

                    <div class="col-md-6 form-group">
                      <label for="lastname">Lastname</label>
                      <input class="form-control" name="lastname" id="lastname" type="text"  placeholder="Lastname">
                    </div>

                    <div class="col-md-6 form-group">
                      <label for="email">Email</label>
                      <input class="form-control" name="email" id="email" type="text"  placeholder="Email Address">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-row">
                    <label for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password"> 
                  </div>
                </div>
				
				<div class="form-group">
                  <div class="form-row">
                    <label for="password">Confirm Password</label>
                      <input type="password" class="form-control" name="conpassword" id="conpassword" placeholder="Confirm Password"> 
                  </div>
                </div>
				
                <div class="form-group">
                  <div class="form-row">
                  <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter your mobile number">
                  </div>
                </div>


                <div class="form-group no-margin">
                  <button type="submit" class="btn btn-success btn-block" onclick="register()">Register</button>
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
      var register = function () {
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
      var email = $('#email').val();
      var password = $('#password').val();
      var conpassword = $('#conpassword').val();
      var mobile = $('#mobile').val();
      
      if(password != conpassword){
        $("#result").removeClass();
            $('#result').addClass('alert alert-danger');
            $('#result').html("Error Message: " + "Passwords do not match.");
          }
      else{
        
        $.ajax({
          type: "POST",
          url: "/api/admin/register.php",
          data: JSON.stringify({
            firstname: firstname,
            lastname: lastname,
            email: email,
            password: password,
        mobile: mobile
          }),
          success: function (response) {
          $("#result").removeClass();
            $('#result').addClass('alert alert-success');
            $('#result').html("Successful Message:" + response["message"] + ". ID: " + response["id"]);
	    header("location: Administrator.php");
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
    }
    
      </script>
</body>
</html>
