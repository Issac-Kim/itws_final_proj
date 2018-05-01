$(document).ready(function(){
  $("#login").click(function(){
    alert("this");
  });
  $.ajax({
    type:"GET",
    url: "resources/workouts/workouts.json",
    dataType: "json",
    success: function(responseData, status){
      var output ="<table id='categoryTable'><tr>";
      $.each(responseData.workoutType, function(i, item) {
        output += '<td><a class="bodyPart" href="resources/workouts/' + item.url + '" id="' + item.bodyPart + '">' + item.bodyPart + '</a></td>';
      });
      output += "</tr></table>"
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
	$('.active').removeAttr('class');
	$(this).attr('class', 'bodyPart');
	$(this).parent().attr('class', 'active');


    });
    }, error: function(msg) {
      				// there was a problem
    alert("There was a problem: " + msg.status + " " + msg.statusText);
    }
  });

});
