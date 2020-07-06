var endtrip = {
    initialize: function(){
        console.log("Get data from API");  

        var driver = document.getElementById("driverId");
        var vehicle = document.getElementById("vehicleId");
        var plate = document.getElementById("plateId");

        driver.innerHTML = "Test";
        vehicle.innerHTML = "Test";
        plate.innerHTML = "Test";
    },

    arrived: function(){
        window.location.href = "ride-request.html";  
    }
};
