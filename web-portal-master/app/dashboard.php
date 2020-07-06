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
		<?php include_once "layouts/dashboard.header.php"?>
    <!-- Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
	</head>
	<body class="login-page" onload="loadtripsfunction()">
		<?php include_once "layouts/dashboard.navigation.php"?>
	    <div class="container-fluid">
	      <div class="row">
	      	<?php include_once "layouts/dashboard.sidebar.php"?>
	        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
	          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	            <div><h1 class="h2"><span class="fa fa-fw fa-tachometer-alt"></span> Dashboard </h1></div>
                <div><h1 class="h2"><a class="text-danger" href="#" onclick="location.reload()"><span class="fa fa-fw fa-sync"></a></h1></span></div>
						</div>
                       
 <!-- TRIPS METRIC -->
    <div class="row" >
		<div align="center" class="col-md-11" style="margin: 10px;">
        <h3>Trips Metric</h3>
    </div>
    <div class="col-md-6" >
        <div class="card p-60">
            <div class="media">
                <div class="media-body media-text-right" style="padding: 10px;">
                    <a href="trips.php" class="text-secondary"><h2 id="total"></h2></a>
                    <p class="m-b-0">TOTAL</p>
                    <p></p>
                    <div class="progress ">
                    <div role="progressbar" style="width: 85%; height:9px;" class="progress-bar bg-danger wow animated progress-animated" ></div>
                    </div>
                </div>
                </div>             
            </div>
        </div>
    
        <div class="col-md-3" >
        <div class="card p-60">
            <div class="media">
                <div class="media-body media-text-right" style="padding: 10px;">
                    <a href="trips.php?keyword=Requested" class="text-secondary"><h2 id="totalrequested"></h2></a>
                    <p class="m-b-0">Requested</p>
                    <p></p>
                    <div class="progress ">
                    <div role="progressbar" style="width: 85%; height:9px;" class="progress-bar bg-danger wow animated progress-animated"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-3" >
        <div class="card p-60">
            <div class="media">
                <div class="media-body media-text-right" style="padding: 10px;">
                    <a href="trips.php?keyword=Assigned" class="text-secondary"><h2 id="totalassigned"></h2></a>
                    <p class="m-b-0">Assigned</p>
                    <p></p>
                    <div class="progress ">
                    <div role="progressbar" style="width: 85%; height:9px;" class="progress-bar bg-danger wow animated progress-animated"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="col-md-3" >
        <div class="card p-60">
            <div class="media">
                <div class="media-body media-text-right" style="padding: 10px;">
                    <a href="trips.php?keyword=Rejected" class="text-secondary"><h2 id="totalrejected"></h2></a>
                    <p class="m-b-0">Rejected</p>
                    <p></p>
                    <div class="progress ">
                    <div role="progressbar" style="width: 85%; height:9px;" class="progress-bar bg-danger wow animated progress-animated"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-3" >
        <div class="card p-60">
            <div class="media">
                <div class="media-body media-text-right" style="padding: 10px;">
                    <a href="trips.php?keyword=Ongoing" class="text-secondary"><h2 id="totalongoing"></h2></a>
                    <p class="m-b-0">Ongoing</p>
                    <p></p>
                    <div class="progress ">
                    <div role="progressbar" style="width: 85%; height:9px;" class="progress-bar bg-danger wow animated progress-animated"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-3" >
        <div class="card p-60">
            <div class="media">
                <div class="media-body media-text-right" style="padding: 10px;">
                    <a href="trips.php?keyword=Completed" class="text-secondary"><h2 id="totalcompleted"></h2></a>
                    <p class="m-b-0">Completed</p>
                    <p></p>
                    <div class="progress ">
                    <div role="progressbar" style="width: 85%; height:9px;" class="progress-bar bg-danger wow animated progress-animated"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-3" >
        <div class="card p-60">
            <div class="media">
                <div class="media-body media-text-right" style="padding: 10px;">
                    <a href="trips.php?keyword=Cancelled" class="text-secondary"><h2 id="totalcancelled"></h2></a>
                    <p class="m-b-0">Cancelled</p>
                    <p></p>
                    <div class="progress ">
                    <div role="progressbar" style="width: 85%; height:9px;" class="progress-bar bg-danger wow animated progress-animated" ></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
		</div>
						<div class="row">
							<div class="col-md-6">
								<div id="columnchart" style="margin: 10px;"></div>
							</div>
							<div class="col-md-6">
								<div id="piechart" style="margin: 10px;"></div>
							</div>
						</div>
  
			<div class="row">
							<div class="col-md-4">
								<div id="farechart" style="margin: 10px;"></div>
							</div>
							<div class="col-md-8">
								<div id="fareadjustmentschart" style="margin: 10px;"></div>
							</div>
						</div>
</div>
					</main>
				</div>
			</div>
<script>
//BASE FARE
    function loadfarefunction() {
    avgbasefare();
    }
    var avgbasefare = function () {
      $.ajax({
        type: "GET",
        url: "/api/report/farestats.php",
        success: function (response) {
          // $("#avgbasefare").removeClass();
          // $('#avgbasefare').addClass('alert alert-success');
          $('#avgbasefare').html("Php " + response["avgbasefare"]);
          $('#lowestbasefare').html("Php " + response["lowestbasefare"]);
          $('#hightestbasefare').html("Php " + response["hightestbasefare"]);
          $('#avgfareperkm').html("Php " + response["avgfareperkm"]);
          $('#lowestfareperkm').html("Php " + response["lowestfareperkm"]);
          $('#hightestfareperkm').html("Php " + response["hightestfareperkm"]);
          $('#avgfareperminute').html("Php " + response["avgfareperminute"]);
          $('#lowestfareperminute').html("Php " + response["lowestfareperminute"]);
          $('#hightestfareperminute').html("Php " + response["hightestfareperminute"]);
        },
        error: function (response) {
        },
        contentType: "application/json; charset=UTF-8",
        dataType: "json"
      });
  }
//TRIPS
    function loadtripsfunction() {
    trips();
    }
      var trips = function () {
      $.ajax({
        type: "GET",
        url: "/api/report/tripstats.php",
        success: function (response) {
          $('#total').html(response["total"]);
          $('#totalrequested').html(response["totalrequested"]);
          $('#totalassigned').html(response["totalassigned"]);
          $('#totalrejected').html(response["totalrejected"]);
          $('#totalongoing').html(response["totalongoing"]);
          $('#totalcompleted').html(response["totalcompleted"]);
          $('#totalcancelled').html(response["totalcancelled"]);
        },
       error: function (response) {
        },
        contentType: "application/json; charset=UTF-8",
        dataType: "json"
      });
  }
// COLUMN CHART
			function getAdminStats() {
                return JSON.parse($.ajax({
                        type: 'GET',
                        url: "/api/report/adminstats.php",
                        data: JSON.stringify({
                            }),
                        contentType: "application/json; charset=UTF-8",
                        dataType: 'html',
                        global: false,
                        async:false,
                        success: function(response) {
                            return response;
                        }
                    }).responseText);
            }
	function getDriverStats() {
                return JSON.parse($.ajax({
                        type: 'GET',
                        url: "/api/report/driverstats.php",
                        data: JSON.stringify({
                            }),
                        contentType: "application/json; charset=UTF-8",
                        dataType: 'html',
                        global: false,
                        async:false,
                        success: function(response) {
                            return response;
                        }
                    }).responseText);
            }
	function getPassengerStats() {
                return JSON.parse($.ajax({
                        type: 'GET',
                        url: "/api/report/passengerstats.php",
                        data: JSON.stringify({
                            }),
                        contentType: "application/json; charset=UTF-8",
                        dataType: 'html',
                        global: false,
                        async:false,
                        success: function(response) {
                            return response;
                        }
                    }).responseText);
            }
		
		var adminstats = getAdminStats();
		var driverstats = getDriverStats();
		var passengerstats = getPassengerStats();
    Highcharts.chart('columnchart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Admin, Driver, & Passenger Metrics'
        },
        xAxis: {
            categories: ['Admin', 'Driver', 'Passenger']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'normal',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: 'gray'
                }
            }
        },
        series: [{
            name: 'Active',
            data: [adminstats['totalactive'], driverstats['totalactive'], passengerstats['totalactive']]
        }, {
            name: 'Non-Active',
            data: [adminstats['totaladmin'] - adminstats['totalactive'], driverstats['totaldriver'] - driverstats['totalactive'], passengerstats['totalactive'] - passengerstats['totalactive']]
        }]
		});
// PIE CHART
    function getJson() {
                return JSON.parse($.ajax({
                        type: 'GET',
                        url: "/api/report/vehiclestats.php",
                        data: JSON.stringify({
                            }),
                        contentType: "application/json; charset=UTF-8",
                        dataType: 'html',
                        global: false,
                        async:false,
                        success: function(response) {
                            return response;
                        }
                    }).responseText);
            }
    var vehicleStatus = getJson();
    Highcharts.chart('piechart', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: 'Vehicle<br>Status',
            align: 'center',
            verticalAlign: 'middle',
            y: 40
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: -50,
                    style: {
                        fontWeight: 'bold',
                        color: 'white'
                    }
                },
                startAngle: -90,
                endAngle: 90,
                center: ['50%', '75%']
            }
        },
        series: [{
            type: 'pie',
            name: 'Vehicles',
            innerSize: '50%',
            data: [
                ['On-Duty', vehicleStatus["totalonduty"]],
                ['On-Trip', vehicleStatus["totalontrip"]],
                ['Available', vehicleStatus["totalavailable"]],
                {
                    dataLabels: {
                        enabled: true
                    }
                }
            ]
        }]
		});
		
	function getFareStats() {
                return JSON.parse($.ajax({
                        type: 'GET',
                        url: "/api/report/farestats.php",
                        data: JSON.stringify({
                            }),
                        contentType: "application/json; charset=UTF-8",
                        dataType: 'html',
                        global: false,
                        async:false,
                        success: function(response) {
                            return response;
                        }
                    }).responseText);
            }
		
		var farestats = getFareStats();
  
	Highcharts.chart('farechart', {
    title: {
        text: 'Base Fare Metrics'
    },
    xAxis: {
        categories: ['Fare']
		},    
		labels: {
        items: [{
            html: 'Total matrices: ' + farestats['totalmatrices'],
            style: {
                left: '50px',
                top: '18px',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
            }
        }]
    },
    series: [{
        type: 'column',
        name: 'Minimum',
        data: [farestats['lowestbasefare']]
    }, {
        type: 'column',
        name: 'Maximum',
        data: [farestats['hightestbasefare']]
    }, {
        type: 'spline',
        name: 'Average',
        data: [farestats['avgbasefare']],
        marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }
    }]
});
  
Highcharts.chart('fareadjustmentschart', {
    title: {
        text: 'Fare Adjustments Metrics'
    },
    xAxis: {
        categories: ['Fare Per Km', 'Fare Per Minute']
		},    
		labels: {
        items: [{
            html: 'Total matrices: ' + farestats['totalmatrices'],
            style: {
                left: '50px',
                top: '18px',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
            }
        }]
    },
    series: [{
        type: 'column',
        name: 'Minimum',
        data: [farestats['lowestfareperkm'], farestats['lowestfareperminute']]
    }, {
        type: 'column',
        name: 'Maximum',
        data: [farestats['hightestfareperkm'], farestats['hightestfareperminute']]
    }, {
        type: 'spline',
        name: 'Average',
        data: [farestats['avgfareperkm'], farestats['avgfareperminute']],
        marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }
    }]
});
		//TRIPS
    function loadtripsfunction() {
    trips();
    }
      var trips = function () {
      $.ajax({
        type: "GET",
        url: "/api/report/tripstats.php",
        success: function (response) {
          $('#total').html(response["total"]);
          $('#totalrequested').html(response["totalrequested"]);
          $('#totalassigned').html(response["totalassigned"]);
          $('#totalrejected').html(response["totalrejected"]);
          $('#totalongoing').html(response["totalongoing"]);
          $('#totalcompleted').html(response["totalcompleted"]);
          $('#totalcancelled').html(response["totalcancelled"]);
        },
       error: function (response) {
        },
        contentType: "application/json; charset=UTF-8",
        dataType: "json"
      });
  }
</script>
	</body>
</html>
