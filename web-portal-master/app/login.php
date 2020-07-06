<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once("layouts/header.php") ?>
<script src="assets/js/common.js"></script>
<script src="assets/js/login.js"></script>
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
              <h4 class="card-title">Administrator Login</h4>
        
              <div class="form-group col-md-8">
                  <div id="result">
                  </div>
              </div>
              
                <div class="form-group">
                  <label for="email">Email Address</label>
                  <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fa fa-lg fa-user"></i></div>
                  </div>
                  <input type="text" class="form-control" name="email" id="email" placeholder="Email Address">
                  </div>
                </div>
                <div class="form-group">
                  <label for="password">Password
                    <a href="forgot-password.php" class="float-right">
                      Forgot Password?
                    </a>
                  </label>
                  <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="fa fa-lg fa-lock"></i></div>
                    </div>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                  </div>
                </div>

                <?php
                    if(isset($_COOKIE["login_hold"])){
                    echo 'Youre not allowed to login for 30 minutes<br/>';
                }
                else {    
                    if(isset($_POST["submit"])){    
                        if(!empty($_POST['email']) && !empty($_POST['password'])) {  
                            $email=$_POST['email'];  
                            $password=$_POST['password'];
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {  
                                    $_SESSION['sess_user']=$row['email'];
                                    echo 'You are currently logged in';
                                }
                            }else {  
                                echo "Invalid email address or password!<br/>";  
                                $_SESSION['login_attempts'] = $_SESSION['login_attempts'] + 1;
                                echo 3 -  $_SESSION['login_attempts'] . ' attempt/s remaining.';
                                if($_SESSION['login_attempts'] >= 3){
                                    setcookie("login_hold", "hold", time() + (1800));
                                    $_SESSION['login_attempts'] = 0; 
                                }
                            }  
                        } else {  
                            echo "All fields are required!";  
                        }  
                    }
                }
                ?>

                <div class="form-group no-margin">
                  <button type="submit" class="btn btn-success btn-block" onclick="login()">
                    Login
                  </button>
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
      var login = function () {
      var email = $('#email').val();
      var password = $('#password').val();
      
     
        $.ajax({
          type: "POST",
          url: "/api/admin/authenticate.php",
          data: JSON.stringify({
            email: email,
            password: password
          }),
          success: function (response) {
          $("#result").removeClass();
			window.location='dashboard.php';
          },
          error: function (response) {
          $("#result").removeClass();
            $('#result').addClass('alert alert-danger');
            $('#result').html("Invalid email or password");
          },
          contentType: "application/json; charset=UTF-8",
          dataType: "json"
        });
    }
    
      </script>
</body>
</html>
