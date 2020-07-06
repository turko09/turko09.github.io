var starttrip = {
    tripid: 0,

    initialize: function () {
        starttrip.tripid = decodeURIComponent(window.location.search.match(/(\?|&)id\=([^&]*)/)[2]);
        starttrip.bindEvents();
    },

    bindEvents: function () {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },

    onDeviceReady: function () {
        starttrip.getTrip(starttrip.tripid);
    },

    getTrip: function (id) {
        $.ajax({
            type: "GET",
            url: config.apiUrl + "trip/get.php",
            data: {
                id: id
            },
            success: function (result) {
                var vehicleid = parseInt(result['vehicleid']);

                var origin = document.getElementById("originId");
                var dest = document.getElementById("destId");
                var cost = document.getElementById("costId");

                origin.innerHTML = result['source'];
                dest.innerHTML = result['destination'];
                cost.innerHTML = result['amount'];

                starttrip.getVehicle(vehicleid);
            },
            error: function (error) {
                console.log(error);
            },
            contentType: "text/plain",
            dataType: "json"
        });
    },

    getVehicle: function (id) {
        $.ajax({
            type: "GET",
            url: config.apiUrl + "vehicle/get.php",
            data: {
                id: id
            },
            success: function (result) {
                var driverid = parseInt(result['driverid']);

                var vehicle = document.getElementById("vehicleId");
                var plate = document.getElementById("plateId");

                vehicle.innerHTML = result['make'] + ' ' + result['model'] + ' (' + result['color'] + ')';
                plate.innerHTML = result['plateno'];

                starttrip.getDriver(driverid);
            },
            error: function (error) {
                console.log(error);
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        });
    },

    getDriver: function (id) {
        $.ajax({
            type: "GET",
            url: config.apiUrl + "driver/get.php",
            data: {
                id: id
            },
            success: function (result) {
                var driver = document.getElementById("driverId");
                driver.innerHTML = result['firstname'] + ' ' + result['lastname'];
            },
            error: function (error) {
                console.log(error);
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        });
    },

    panicButton: function () {
        $.ajax({
            type: "POST",
            url: config.apiUrl + "trip/panic.php",
            data: JSON.stringify({
                id: starttrip.tripid
            }),
            success: function (result) {
                ons.notification.alert(result['message'], {
                    title: "Panic Button"
                });
            },
            error: function (error) {
                console.log(error);
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        });
    },

    endTrip: function () {
        window.location.href = "end-trip.html";
    }
};