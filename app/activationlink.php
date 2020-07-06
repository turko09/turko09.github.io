<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once "layouts/header.php"?>
<script src="assets/js/common.js"></script>
<script src="assets/js/login.js"></script>
  <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
<script src="../vendor/components/jquery/jquery.min.js"></script>
</head>
<body class="login-page" style="height:auto">
          <div class="row" style="margin-top:50px">
              <div class="col-md-4">
              </div>


              <div class="col-md-6">
                  <div class="card fat" id="register_form" style="margin-top:0px; border: 1px solid #cecbcb">
                      <div class="card-body">
                        <h5 class="card-title" style="text-align:center;">
                          <a href="../index.php" style="text-decoration:  none;">
                            <img src="assets/images/logoteam-alpha.png" style="width: 75px;">
                          </a>
                          Account Verification and Activation:</h5>
                        <div class="row">
                          <div class="col-md-12">
                              <span id="result" style="font-size: 11px"></span>
                              <h5 id="message">Message</h5>
                           </div>
                        </div>
                        <br>
                      </div>
                  </div>
              </div>
          </div>
</body>
</html>

<script>
var getQueryParam = function (param) {
    var result = window.location.search.match(
        new RegExp("(\\?|&)" + param + "(\\[\\])?=([^&]*)")
    );
    return result ? result[3] : false;
}

$(document).ready(function(){
    $.ajax({
      type: "POST",
      url: "/api/passenger/activateaccount.php",
      data: JSON.stringify({
          id: getQueryParam('id'),
          token: getQueryParam('token')
      }),
      success: function (response) {
        $('#message').text(response['message']);
      },
      error: function (response) {
        $('#message').text(response.responseJSON["message"]);
      },
      contentType: "application/json; charset=UTF-8",
      dataType: "json"
    });
	});

</script>