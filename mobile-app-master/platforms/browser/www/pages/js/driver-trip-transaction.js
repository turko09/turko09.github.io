var drivertrip = {
    initialize: function(){
        console.log("Get data from API");  

        var origin = document.getElementById("originId");
        var dest = document.getElementById("destId");
        var cost = document.getElementById("costId");   

        origin.innerHTML = "Test";
        dest.innerHTML = "Test";
        cost.innerHTML = "Test";
    },

    start: function(){
        console.log("Start trip");
    },

    end: function(){
        console.log("Start end");
    }
};
