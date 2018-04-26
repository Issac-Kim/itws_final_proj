
var str = "";
function addWork() {
  var element = document.getElementById("day");
  var day = document.getElementById($('#day option:selected').val());
  var workout = document.getElementById("workoutName");
  var li = document.createElement("li");
  //li.appendChild(workout.value);
  console.log($('#day option:selected').val());
  console.log(day);
  str +=  "<li class=\"no-bullet\">" + workout.value + "</li>";
  day.innerHTML += "<li class=\"no-bullet\">" + workout.value + "</li>";

}
