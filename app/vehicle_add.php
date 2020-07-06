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
  <head>

    <?php include_once("layouts/dashboard.header.php") ?>

    <link rel="stylesheet" href="../app/assets/stylesheets/datatables.min.css">
  </head>
  <body class="login-page">
    <?php include_once("layouts/dashboard.navigation.php") ?>
    <script src="../app/assets/js/datatables.min.js"></script>
      <div class="container-fluid">
        <div class="row">
          <?php include_once("layouts/dashboard.sidebar.php") ?>

         <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2">
			<h1 class="h2"><span class="fa fa-fw fa-car"></span>Add Vehicle</h1>
			<div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
			</div>
		</div>
			<div class="table-responsive" id="vehicle_preview">
			</div>
		<div class="table-responsive" id="vehicle_list">
		<table class="table table-striped table-sm" id="vehicles_table">
			  
                <div class="form-group">
                  <div class="form-row">
                    <div class="col-md-6 form-group">
                      <label for="plateno">Plate No</label>
                      <input class="form-control" name="plateno" id="plateno" type="text"  placeholder="Plate No">
                    </div>
		</div>
		<div class="form-row">
                    <div class="col-md-6 form-group">
                      <label for="vtype">Type</label>
                      <input class="form-control" name="vtype" id="vtype" type="text"  placeholder="vtype">
                    </div>
		</div>
		<div class="form-row">
                    <div class="col-md-6 form-group">
                      <label for="make">Make</label>
                      <input class="form-control" name="make" id="make" type="text"  placeholder="Make">
                    </div>
                 </div>
		
                
                 <div class="form-row">
		   <div class="col-md-6 form-group">  
                    	<label for="model">Model</label>
                      <input type="text" class="form-control" name="model" id="model" placeholder="Model"> 
                  </div>
                </div>
				
		<div class="form-row">
		   <div class="col-md-6 form-group"> 
                    <label for="vcolor">Color</label>
                      <input type="text" class="form-control" name="vcolor" id="vcolor" placeholder="Color"> 
                  </div>
                </div>
				
               <div class="form-row">
		   <div class="col-md-6 form-group"> 
                  	<button type="submit" class="btn btn-success btn-block" onclick="add()">Submit</button>
                  </div>				
            </div>
          </div>
          
          </table>
		</div>
        </div>
      </div>
  </body>
</html>
<script src="vendor/components/jquery/jquery.min.js"></script>
      <script>
      var add = function () {
        var plateno = $('#plateno').val();
        var vtype = $('#vtype').val();
      var make = $('#make').val();
      var model = $('#model').val();
      var vcolor = $('#vcolor').val();
      
      
        $.ajax({
          type: "POST",
          url: "/api/vehicle/add.php",
          data: JSON.stringify({
            plateno: plateno,
            vtype: vtype,
            make: make,
            model: model,
	    vcolor: vcolor	  
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
    }
    
      </script>
</body>
</html>
