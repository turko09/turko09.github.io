<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once("layouts/header.php") ?>
</head>
<body class="login-page">
  <section class="h-75">
    <div class="container h-75">
      <div class="row  h-75">
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
          <div class="card fat" id="register_form">
            <div class="card-body">
              <h4 class="card-title">Driver Registration</h4>
              <div class="row">
                <div class="col-md-12">
                    <span id="result" style="font-size: 11px"></span>
                 </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                    <label class="form-control-label">Firstname</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Juan">
                 </div>
               <div class="col-md-6">
                    <label class="form-control-label">Lastname</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Cruz">
                </div>
              </div>
              <br>
              <div class="row">
                  <div class="col-md-12">
                    <label class="form-control-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="juancruz@gmail.com">
                  </div>
              </div>
              <br>
              <div class="row">
                  <div class="col-md-12">
                    <label class="form-control-label">Password</label>
                    <input type="text" class="form-control" name="password" id="password" placeholder="@juander12">
                  </div>
              </div>
              <br>
              <div class="row">
                  <div class="col-md-12">
                    <label class="form-control-label">Address</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="Quezon City">
                  </div>
              </div>
              <br>
              <div class="row">
                  <div class="col-md-12">
                    <label class="form-control-label">Mobile</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="09123456789" maxlength="11">
                  </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <label>Photos</label><br>
                   <img src="#" id="driver_img" alt="" style="width: 200px; height: 200px; border:1px solid;">
                  <input type="file" id="photo">
                </div>
              </div>   
          </div>
          <br>
          <div class="form-group no-margin">
            <button type="submit" name="submit" class="btn btn-success btn-block" onclick="registerdriver()">
              Register
            </button>
          </div>
          <div class="margin-top20 text-center">
            Already have an account? <a href="login.php">Log-in</a>
          </div>
              </form>
            </div>
        </div>
        </div>
      </div>
    </div>
  </section>

<script>
    document.getElementById("photo").onchange = function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("driver_img").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    };

    function registerdriver() {
     var firstname = $('#firstname').val();
     var lastname = $('#lastname').val();
     var email = $('#email').val();
     var password = $('#password').val();
     var address = $('#address').val();
     var mobile = $('#mobile').val();
     var photo = document.getElementById("driver_img").src;
  
      $.ajax({
        type: "POST",
        url: "/api/driver/register.php",
        data: JSON.stringify({
        firstname: firstname,
        lastname: lastname,
        email: email,
        password: password,
        address: address,
        mobile : mobile,
        photo: photo
        }),
        success: function (response) {
          $("#result").removeClass();
          $('#result').addClass('alert alert-success');
          $('#result').html("Successful Message:" + response["message"] + ". ID: " + response["id"]);
          $('#register_form input').val('');
        },
        error: function (response) {
          $("#result").removeClass();
          $('#result').addClass('alert alert-danger');
          $('#result').html("Error Message: " + response.responseJSON["message"]);
        },
        contentType: "application/json; charset=UTF-8",
        dataType: "json"
      });
    };
    </script>
</body>
</html>
