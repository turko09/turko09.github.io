$( "#fare_update" ).click(function() {

var id = document.getElementById('id').value;

	$.ajax({
	  type: "POST",
	  url: "/api/fare/delete.php",
	  data: JSON.stringify({
	  	'id': id
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
});