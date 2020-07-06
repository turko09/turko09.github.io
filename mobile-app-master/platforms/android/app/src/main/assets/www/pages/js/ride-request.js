var riderrequest = {  
    costElement: document.getElementById('costId'),
    pickupElement: document.getElementById('pickupId'),
    destElement: document.getElementById('destinationId'),

    vehicleType: '',   
    cost: 0,
    passengerid: 0,   
    radius: 10,
    tripid:0,

    initialize: function() {
        riderrequest.costElement.innerHTML = "0.00"; 
        riderrequest.accept.disabled = true;  
        var parameterValue = decodeURIComponent(window.location.search.match(/(\?|&)id\=([^&]*)/)[2]); 
        riderrequest.passengerid = parameterValue;    
    },

    originChange: function () {        
        console.log("Origin");
        if(riderrequest.validateValueOriginDestination()){
            riderrequest.updateCost();             
            map.searchRoute(riderrequest.pickupElement.value, riderrequest.destElement.value);
        }        
    },

    destinationChange: function () { 
        console.log("Destination");
        if(riderrequest.validateValueOriginDestination()){
            riderrequest.updateCost();             
            map.searchRoute(riderrequest.pickupElement.value, riderrequest.destElement.value);
        }  
    },

    vehicleChange: function (value) { 
        riderrequest.vehicleType = value.value;
        map.searchRoute(riderrequest.pickupElement.value, riderrequest.destElement.value);
        riderrequest.updateCost();
    },

    validateValueOriginDestination: function(){
        var valid = false;

        if(riderrequest.pickupElement.value !== '' &&
            riderrequest.destElement.value !== ''){
            valid = true;
        }      

        return valid;
    },

    updateCost: function () { 
        if(riderrequest.distance !== 0 && riderrequest.vehicleType !== '')
        {
            console.log(map.distance);
            console.log(map.time);
            $.ajax({
            type: "POST",
            url: config.apiUrl + "fare/compute.php",
            data: JSON.stringify({
                vehicle_type:riderrequest.vehicleType,
                distance_km:map.distance,
                distance_minute:map.time
            }),
            success: function (result) {
                riderrequest.cost = result["Total Amount"];
                riderrequest.costElement.innerHTML = riderrequest.cost;
            },
            error: function(error){
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json"
            });  
        }
    },

    accept: function () {  
        if(riderrequest.distance !== 0 && riderrequest.vehicleType !== '' && riderrequest.cost !== 0)
        {
            $.ajax({
            type: "POST",
            url: config.apiUrl + "trip/request.php",
            data: JSON.stringify({
                vehicletype: riderrequest.vehicleType,
                passengerid: riderrequest.passengerid,
                source: riderrequest.pickupElement.value,
                sourcelat: map.sourcelat,
                sourcelong:map.sourcelong,
                destination:riderrequest.destElement.value,
                destinationlat:map.destinationlat,
                destinationlong:map.destinationlong,
                amount:riderrequest.cost,
                radius:riderrequest.radius
            }),
            success: function (result) {
                ons.notification.alert({
                message: result["message"] + "<br />Trip ID:" + result["id"] ,
                callback: function(answer) {                  
                    var accept = document.getElementById("accept");
                    accept.style.visibility = 'collapse';

                    // var cancel = document.getElementById("cancel");
                    // cancel.style.visibility = 'collapse';

                    // var accepted = document.getElementById("accepted");
                    // accepted.style.visibility = 'collapse';

                    riderrequest.tripid = result["id"];
                }
            });           
            },
            error: function(error){
                ons.notification.alert("Encountered error!");
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json"
            });   
        }  
        else{
            ons.notification.alert("Supply source, destination and vehicle type!");
        }
    },

    rideAccepted: function(){
        //PASS TRIP ID
        window.location.href = "pending-ride.html?id=" + riderrequest.tripid;        
    },

    cancel: function () {    
        //CLEAR SELECTION
    },

    logout: function(){
        ons.notification.confirm({
        message: 'Are you sure you want to logout?',
        callback: function(idx) {
        switch (idx) {
          case 0:            
            break;
          case 1:
            window.location.href = 'login.html';
            break;
        }
        }});
        
    },

    getHistory: function(){
        window.location.href = "trip-history.html?id=" + riderrequest.passengerid; 
    }
};