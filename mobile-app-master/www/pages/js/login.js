
var login = {

    email : document.getElementById("email"),
    password : document.getElementById("password"),
    id : 0,
    login: function(){
        $.ajax({
        type: "POST",
        url: config.apiUrl + "passenger/authenticate.php",
        data: JSON.stringify({
            email: login.email.value,
            password: login.password.value
        }),
        success: function (result) {
            login.id = result["id"];
            onesignal.setPlayerIdAndRedirect(result["id"], "passenger", "ride-request.html?id=" + login.id);
        },
        error: function(error){
            ons.notification.alert("Login failed!");             
        },
        contentType: "application/json; charset=utf-8",
        dataType: "json"
        });        
    },

    loginAsDriver: function(){
        $.ajax({
        type: "POST",
        url: config.apiUrl + "driver/authenticate.php",
        data: JSON.stringify({
            email: login.email.value,
            password: login.password.value
        }),
        success: function (result) {
            login.id = result["id"];
            onesignal.setPlayerIdAndRedirect(result["id"], "driver", "driver-ride-request.html?id=" + login.id);
        },
        error: function(error){
            ons.notification.alert("Login failed!");
        },
        contentType: "application/json; charset=utf-8",
        dataType: "json"
        });        
    }
};
