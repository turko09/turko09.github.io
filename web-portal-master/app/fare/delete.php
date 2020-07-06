<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include_once("layouts/dashboard.header.php"); ?>
		<script>
			function myFunction(){
			window.location="index.php";
			}
		</script>
	</head>
	<body class="login-page">
		<?php include_once("layouts/dashboard.navigation.php"); ?>
	    <div class="container-fluid">
	      <div class="row">
	      	<?php include_once("../layouts/dashboard.sidebar.php"); ?>
	        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
	          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	            <h1 class="h2"><span class="fa fa-fw fa-money-bill-alt"></span> Delete Fare</h1>
	            <a href="index.php" type="button" class="btn btn-info"><span class="fas fa-arrow-left"></span> Go Back to Index </a>
	          </div>
	          <div class="container-fluid">
		          <div class="form-group mx-auto">
		            <div class="form-row">
		              <h3>Click Delete to remove fare matrix with ID <?php echo htmlspecialchars($_GET["id"]); ?>.</h3>
		              <input class="form-control" id="id" type="hidden" value="<?php echo htmlspecialchars($_GET["id"]); ?>">
		            </div>
		            <div class="form-row">
		                <button id="fare_update" name="fare_delete" class="btn btn-lg btn-danger mt-2" onclick="myFunction()"><span class="fas fa-plus"></span> Delete Fare</button>
		            </div>
		          </div>
	          </div>
	        </main>
	      </div>
	    </div>
	</body>
		<script src="/app/assets/js/fare/delete.js"></script>
</html>