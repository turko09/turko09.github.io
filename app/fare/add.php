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
	      	<?php include_once("layouts/dashboard.sidebar.php"); ?>
	        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
	          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	            <h1 class="h2"><span class="fa fa-fw fa-money-bill-alt"></span> Add Fare</h1>
	            <a href="index.php" type="button" class="btn btn-info"><span class="fas fa-arrow-left"></span> Go Back to Fare List </a>
	          </div>
	          <form method="POST" action="index.php" onsubmit="return checkforblank()" class="needs-validation" novalidate>
	          <div class="container-fluid">
		          <div class="form-group mx-auto" required>
		            <div class="form-row">
		              <div class="col-md font-weight-bold">

		                <label for="vehicle_type">Vehicle Type</label>
		                <input class="form-control" id="vehicle_type" name="vehicle_type" type="text"  placeholder="Vehicle Type" required>
		                <div id="vehicleError" class="invalid-feedback">Please fill out this field</div>
		              </div>
		              <div class="col-md-9">
		              </div>
		            </div>
		            <hr>
		            <div class="form-row mt-2">
		              <div class="col font-weight-bold">
		                <label>Regular Fare</label>
		               </div>
		            </div>
		            <div class="form-row">
		              <div class="col-md">
		                <label for="per_km">Per Kilometer</label>
		                <input class="form-control" id="per_km" name id="per_km" type="number" step="0.01" placeholder="Per Km" required>
		                <div id="perkmError" class="invalid-feedback">Please fill out this field</div>
		              </div>
		              <div class="col-md">
		                <label for="per_minute">Minute(s) Consumed</label>
		                <input class="form-control" id="per_minute" name="per_minute" type="number" step="0.01" placeholder="Per Minute" required>
		              	<div id="perkminuteError" class="invalid-feedback">Please fill out this field</div>
		              </div>
		              <div class="col-md">
		                <label for="base_fare">Base Fare</label>
		                <input class="form-control" id="base_fare" name="base_fare" type="number" step="0.01" placeholder="Base Fare" required>
		              	<div id="basefareError" class="invalid-feedback">Please fill out this field</div>
		              </div>
		            </div>
		            <hr>
		            <div class="form-row mt-2">
		              <div class="col font-weight-bold">
		                <label>Fare Adjustments</label>
		               </div>
		            </div>
		            <div class="form-row">
		              <div class="col-md">
		                <label for="surge_rush_threshold">Surge Rush Threshold</label>
		                 <input class="form-control" id="surge_rush_threshold" name="surge_rush_threshold" type="number" step="0.01" placeholder="Surge Rush Threshold" required>
						 <div id="thresholdError" class="invalid-feedback">Please fill out this field</div>					
		              </div>
		              <div class="col-md">
		                <label for="surge_rush_multiplier">Surge Rush Multiplier</label>
		                <input class="form-control" id="surge_rush_multiplier" name="surge_rush_multiplier" type="number" step="0.01" placeholder="Surge Rush Multiplier" required><div id="rushError" class="invalid-feedback">Please fill out this field</div>
		              </div>
		              <div class="col-md">
		                <label for="surge_time_multiplier">Surge Time Multiplier</label>
		                <input class="form-control" name="surge_time_multiplier" id="surge_time_multiplier" type="number" step="0.01" placeholder="Surge Time Multiplier" required><div id="timeError" class="invalid-feedback">Please fill out this field</div>
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
		                <button id="fare_add" type="submit" name="fare_add" class="btn btn-lg btn-success mt-2"><span class="fas fa-plus"></span> Add Fare</button>
		               </form>
		              </div>
		            </div>
		          </div>
	          </div>
	        </main>
	      </div>
	    </div>
	</body>
		<script src="/app/assets/js/fare/add.js"></script>
</html>
<script>
		function checkforblank() {

			var errormessage = "";

			if (document.getElementById('vehicle_type').value == "") {
				errormesssage += "Fill up vehicle field";				
			}
			if (document.getElementById('per_km').value == "") {
				errormesssage += "Fill up per km field";				
			}
			if (document.getElementById('per_minute').value == "") {
				errormesssage += "Fill up per minute field";				
			}
			if (document.getElementById('base_fare').value == "") {
				errormesssage += "Fill up base fare field";				
			}
			if (document.getElementById('surge_time_multiplier').value == "") {
				errormesssage += "Fill up surge time multiplier";				
			}
			if (document.getElementById('surge_rush_threshold').value == "") {
				errormesssage += "Fill up surge rush threshold";				
			}
			if (document.getElementById('surge_rush_multiplier').value == "") {
				errormesssage += "Fill up surge rush multiplier";				
			}
			if (errormessage != "") {
				alert(errormessage);
				return false;			
			}
			}
			
</script>
<script>
	(function (){
		'use strict';
		window.addEventListener('load', function() {
			//Fetch all the forms we want to apply validation
			var forms = document.getElementsByClassName('needs-validation');
			//Loop oever them and prevent submission
			var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit', function(event) {
					if(form.checkValidity () === false) {
						event.preventDefault();
						event.stopPropagation();
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);
	})();
</script>
