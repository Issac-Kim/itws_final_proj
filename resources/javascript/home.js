$(document).ready(function(){
  $("#login").click(function(){
    alert("this");
  });
  $.ajax({
    type:"GET",
    url: "resources/workouts/workouts.json",
    dataType: "json",
    success: function(responseData, status){
      var output ="<h3>Muscle Group</h3><ul>";
      $.each(responseData.workoutType, function(i, item) {
        output += '<li><a href=resources/workouts/' + item.url + '>' + item.bodyPart + '</a></li>';
      });
      output += "</ul>"
    $('#categories').html(output);
    }, error: function(msg) {
      				// there was a problem
    alert("There was a problem: " + msg.status + " " + msg.statusText);
    }
  });
});
