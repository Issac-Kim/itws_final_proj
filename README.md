# itws_final_proj
Group 1 
Up Your Gains 



For the Meal, Workout php, Regoistar and Login:
To recreate the Meal.php page and workout_journal.php create use workoutTable.sql, mealTable.sql, loginTable.sql and import using utf-8 option. When trying to use php files change the username and password to your localhost information.


*Clicking the logo will always return the user to the home page 


Home Page should be full screen for best exprience.
Play with zoom of the page. Navigation of body parts should all be on one line. To access workouts, which uses javascript onload to output the list of body parts, which all have on-click functions that read through the coresponding body part JSON file. After reading, the javascript outputs the information onto the page.


Meal Journal Page
When using Meal Journal page, Meal Type, Food Group, Meal Name, calories and are required outputs. The form will output and error messages if any of those input are not filled. Once the save is clicked the php preforms a POST to the mealTable. Then the php performs a query on the database and runs a for loop to output the user's entries.


Workout Journal
When using the workout journal, The user is required to enter a workout name, and date. If the User doesn't adjust the day dropdown, the value of day will default to Sunday. If any output is empty, the php will return error messages on what to fix. Once all input is valid, the php will post to the workoutTable.



Login/Registar( *WIP )
To Login after a submit the php runs a query on the entered username and password. If the login in fails, the page returns, "Username or  password invaild".  

To Registar the php will check if the username is in user,
Is so the page will return an error or if the password is empty the page returns errors. If the both entries are valid the the php add the username and pssword to the database. 

