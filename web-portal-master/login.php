<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once("layouts/header.php") ?>
<script src="assets/js/common.js"></script>
<script src="assets/js/login.js"></script>
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
          <div class="card-wrapper">
          <div class="brand">
            <a href="index.php">
              <img src="assets/images/logoteam-alpha.png">
            </a>
          </div>
          <div class="card fat">
            <div class="card-body">
              <h4 class="card-title">Login</h4>
              <form method="POST">
                <div class="form-group">
                  <label for="username">Username</label>
                  <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                  <div class="input-group-text"><i class="fa fa-lg fa-user"></i></div>
                  </div>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Username">
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

                <div class="form-group">
                  <label>
                    <input type="checkbox" name="remember"> Remember Me
                  </label>
                </div>
                <br>
                <?php
  

    if(isset($_COOKIE["login_hold"])){
    echo 'Youre not allowed to login for 30 minutes<br/>';

}
else {    
    if(isset($_POST["submit"])){    
        if(!empty($_POST['username']) && !empty($_POST['password'])) {  
            $username=$_POST['username'];  
            $password=$_POST['password'];

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {  
                    $_SESSION['sess_user']=$row['user_name'];
                    echo 'You are currently login now';
                }
            }else {  
                echo "Invalid Username or password!<br/>";  
                $_SESSION['login_attempts'] = $_SESSION['login_attempts'] + 1;
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
<br>

                <div class="form-group no-margin">
                  <button type="submit" name="submit" class="btn btn-success btn-block">
                    Login
                  </button>
                </div>
                <div class="margin-top20 text-center">
                  Don't have an account? <a href="register.php">Create One</a>
                </div>
              </form>
            </div>
          </div>
          <div class="footer">
            Copyright &copy; 2018 &mdash; UPOU-CMSC-207-Team-Alpha
 
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>