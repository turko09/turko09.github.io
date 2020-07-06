<?php
session_start();
?>
<!DOCTYPE html>	
<html lang="en">
	<head>
		<?php include_once("layouts/dashboard.header.php"); ?>
	</head>
	<body class="login-page">
		<?php include_once("layouts/dashboard.navigation.php"); ?>
	    <div class="container-fluid">
	      <div class="row">
	      	<?php include_once("../layouts/dashboard.sidebar.php"); ?>
	        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
	          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	            <h1 class="h2"><span class="fa fa-fw fa-money-bill-alt"></span> Compute Fare</h1>
	            <a href="index.php" type="button" class="btn btn-info"><span class="fas fa-arrow-left"></span> Go Back to Fare List </a>
	          </div>
	          <div class="container-fluid">
		          <div class="form-group mx-auto">
		            <div class="form-row mt-2">
		            </div>
		            <div class="form-row">
		              <div class="col-md">
		                <label for="per_km">Vehicle type</label>
		                <input class="form-control" id="vehicle_type" name id="vehicle_type" type="text" placeholder="Vehicle Type">
		              </div>
		              <div class="col-md">
		                <label for="per_minute">Distance Km</label>
		                <input class="form-control" id="distance_km" name="distance_km" type="number" step="0.01" placeholder="Distance per Km">
		              </div>
		              <div class="col-md">
		                <label for="base_fare">Distance Minutes</label>
		                <input class="form-control" id="distance_minute" name="distance_minute" type="number" step="0.01" placeholder="Distance per Minutes">
		              </div>
		            </div>
		            <hr>
		            <div class="form-row">
		              <div class="col-md">
		                <label for="surge_rush_threshold">Source Lat</label>
		                 <input class="form-control" id="source_lat" name="source_lat" type="number" step="0.01" placeholder="Source Lat">
											
		              </div>
		              <div class="col-md">
		                <label for="surge_rush_multiplier">Source Long</label>
		                <input class="form-control" id="source_long" name="source_long" type="number" step="0.01" placeholder="Source Long">
		              </div>
		              <div class="col-md">
		                <label for="surge_time_multiplier">Radius</label>
		                <input class="form-control" name="radius" id="radius" type="number" step="0.01" placeholder="Radius">
		              </div>
		            </div>
		            <hr>
		            <div class="form-row mt-2">
		              <div class="col font-weight-bold">
		                <label for="exampleInputName">Actions</label>
		               </div>
		            </div>
		            <div class="form-row">
		              <div class="col-md">
		              </div>
		              <div class="col-md">
		              </div>
		              <div class="col-md">
		                <button id="fare_compute" type="submit" name="fare_compute" class="btn btn-lg btn-success mt-2"><span class="fas fa-calculator"></span> Compute Fare</button>
		              </div>
		            </div>
		          </div>
	          </div>
	        </main>
	      </div>
	    </div>
	    <!-- Modal -->
  <div class="modal fade" id="compute_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Computed Fare</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="modal_body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
   </div>
	</body>
		<script src="/app/assets/js/fare/compute.js"></script>
</html>