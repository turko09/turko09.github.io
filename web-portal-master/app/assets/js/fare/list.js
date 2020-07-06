$.getJSON( "/api/fare/get.php", function( data ) {
  var items = [];
  $.each( data, function( key, val ) {
    items.push( showRow(val) )
  });

  function showRow(val) {
  	/*return "<tr><td><input type=\"checkbox\" name=\"\"></td><td>" +
     val['id'] + "</td><td>" +*/
    return "<tr><td>" +
     val['vehicle_type'] + "</td><td>" +
     val['base_fare'] + "</td><td>" + 
     val['per_km'] + "</td><td>" + 
     val['per_minute'] + "</td><td>" + 
     val['surge_rush_threshold'] + "</td><td>" + 
     val['surge_rush_multiplier'] + "</td><td>" + 
     val['surge_time_multiplier']  + "</td><td>" +
     /*"<a href=\"/app/fare/update.php?id=" + val['id'] + "\">Update" + "</a> | <a href=\"/app/fare/delete.php?id=" + val['id'] + "\">Delete" + "</a></td></tr>"*/
     "<a href=\"/app/fare/update.php?id=" + val['id'] + "\">Update" + "</a></td></tr>"
  }

  $('tbody').html(items.join());
});