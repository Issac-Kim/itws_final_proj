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
        output += '<li><a class="bodyPart" href="resources/workouts/' + item.url + '" id="' + item.bodyPart + '">' + item.bodyPart + '</a></li>';
      });
      output += "</ul>"
    $('#categories').html(output);
    $(".bodyPart").on("click", function(e){
        e.preventDefault();
        var currentURL = $(this).attr('href');
        var body = $(this).attr('id');
        $.ajax({
          type:"GET",
          url: currentURL,
          dataType: "json",
          success: function(responseData, status){
          var output = '<h2>' + body + '</h2>';
          $.each(responseData.workout, function(i, item) {
            output += '<h3>' + item.name_of_workout + '</h3><p>' + item.instruction + '</p>';
          });
        $("#category").html(output);
        }, error: function(msg){
          alert("There was a problem: " + msg.status + " " + msg.statusText);
        }
      });
    });
    }, error: function(msg) {
      				// there was a problem
    alert("There was a problem: " + msg.status + " " + msg.statusText);
    }
  });
});
