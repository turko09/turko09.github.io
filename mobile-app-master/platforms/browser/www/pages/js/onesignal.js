var onesignal = {
    initialize: function () {
        this.bindEvents();
    },
    bindEvents: function () {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    onDeviceReady: function () {
        var notificationReceiveCallback = function (jsonData) {
            if (jsonData["payload"]["title"] === "Trip assigned!") {
                onesignal.driverTripAlert(jsonData["payload"]["additionalData"]["tripid"]);
            }
            //passenger
            else if (jsonData["payload"]["title"] === "Trip accepted!") {
                onesignal.passengerRideAccepted();
            }
            else if (jsonData["payload"]["title"] === "Trip started!") {
                onesignal.passengerTripStarted();
            }
            else if (jsonData["payload"]["title"] === "Trip ended!") {
                onesignal.passengerTripEnded();
            }
            //Trip assigned!
            //tripid
        };

        window.plugins.OneSignal
            .startInit("d2097cc3-fb04-4981-806b-19c87aabc868")
            .handleNotificationReceived(notificationReceiveCallback)
            .endInit();
    },

    setPlayerIdAndRedirect: function (id, role, page) {

        //remove this
        //window.location.href = page;
        window.plugins.OneSignal.getIds(function (user) {
            $.ajax({
                type: "POST",
                url: config.apiUrl + role + "/setplayerid.php",
                data: JSON.stringify({
                    id: id,
                    playerid: user.userId
                }),
                success: function (result) {
                    console.log("Setting of player id successfully completed.");
                    window.plugins.OneSignal.sendTag("role", role);
                    console.log("Role tag sent to OneSignal.");
                    window.location.href = page;
                },
                error: function (error) {
                    ons.notification.alert("Setting of player id failed!");
                    console.log(error.responseText);
                },
                contentType: "application/json; charset=utf-8",
                dataType: "json"
            });
        });
    },

    //FUNCTIONS
    driverAcceptTrip: function (id) {
        //PUSH MESSAGE TO PASSENGER INCLUDE TRIP ID

        console.log("OS driverAcceptTrip");
    },

    driverStartTrip: function () {
        //PUSH MESSAGE TO PASSENGER INCLUDE TRIP ID

        console.log("OS driverStartTrip");
    },

    driverEndTrip: function () {
        //PUSH MESSAGE TO PASSENGER INCLUDE TRIP ID

        console.log("OS driverEndTrip");
    },


    //EVENTS
    driverTripAlert: function (id) {
        driverride.tripid = id;
        driverride.getTrip(1);
    },

    passengerRideAccepted: function () {

        riderrequest.rideAccepted();
        console.log("OS rideAccepted");
    },

    passengerTripStarted: function () {
        pendingride.startTrip();
        console.log("OS passengerTripStarted");
    },

    passengerTripEnded: function () {
        starttrip.endTrip()
        console.log("OS passengerTripEnded");
    }
};