var addfare = function () {
      var vehicle_type = document.getElementById('vehicle_type').value;
      var base_fare = document.getElementById('base_fare').value;
      var per_km = document.getElementById('per_km').value;
      var per_minute = document.getElementById('per_minute').value;
      $.ajax({
        type: "POST",
        url: "/api/fare/add.php",
        data: JSON.stringify({
          vehicle_type: vehicle_type,
          base_fare: base_fare,
          per_km: per_km,
          per_minute: per_minute
        }),
        success: function (response) {
          alert("Successful Message:" + response["message"] + ". ID: " + response["id"]);
        },
        error: function (response) {
          console.log(response);
          alert("Error Message: " + response.responseJSON["message"]);
        },
        contentType: "application/json; charset=UTF-8",
        dataType: "json"
      });
    };