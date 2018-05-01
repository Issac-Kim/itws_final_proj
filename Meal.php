<?php 
  include('./resources/includes/init.inc.php'); // include the DOCTYPE and opening tags
?>
<title>Meal Planner</title>   

<?php 
  include('./resources/includes/head.inc.php'); 
  // include global css, javascript, end the head and open the body
?>



<?php 
    //Open the database.
    @ $db = new mysqli('localhost', 'root', '', 'upYourGains');
    if ($db->connect_error) { //Cannot access database 
        echo '<div class="messages">Could not connect to the database. Error: ';
        echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
    }else { // Continues towards post new entry
     $dbOk = true; 
    }
      //Variable holders
      $userName='';
      $mealType = '';  
      $foodGroup = '';
      $macros = '';
      $calories = '';  
      $mealName= '';
      $date = '';


      // hold any error messages
      $errors = ''; 

        
      $havePost = isset($_POST["save"]);
        
        
      if ($havePost) {
        //Convert all var values into htmlcharacters and takes off white space
        $mealType = htmlspecialchars(trim($_POST["mealType"]));  
        $foodGroup = htmlspecialchars(trim($_POST["foodGroup"]));
        $macros =htmlspecialchars(trim($_POST["macros"]));
        $calories = htmlspecialchars(trim($_POST["calories"]));  
        $mealName= htmlspecialchars(trim($_POST["mealName"]));
        $date = htmlspecialchars(trim($_POST["date"]));


        //Convert to time format YYYY-MM-DD
        $dateTime = strtotime($date);
        $dateFormat = 'Y-m-d';
        
        //Check if the input date is valid
        $dateOk = (date($dateFormat, $dateTime) == $date);  

        //Used to tell what input to focus on hen there is an 
        //error 
        $focusId = ''; 
        
        //Checks for errors and then outputs them onto page.
        if ($mealType == '') {
          $errors .= '<li>Meal Type must not be blank</li>';
          if ($focusId == '') $focusId = '#mealType';
        }
        if ($foodGroup == '') {
          $errors .= '<li>Food Group may not be blank</li>';
          if ($focusId == '') $focusId = '#foodGroup';
        }
  
        if (!$dateOk) {
          $errors .= '<li>Enter a valid date in yyyy-mm-dd format</li>';
          if ($focusId == '') $focusId = '#date';
        }
          
        if ($errors != '') {
          echo '<div class="messages"><h4>Please correct the following errors:</h4><ul>';
          echo $errors;
          echo '</ul></div>';
          echo '<script type="text/javascript">';
          echo '  $(document).ready(function() {';
          echo '    $("' . $focusId . '").focus();';
          echo '  });';
          echo '</script>';
        } else { 
        if ($dbOk) { //All inputs are correct so, the php 
            //will make a post to database's table.

            $mealTypeForDb = trim($_POST["mealType"]);  
            $foodGroupForDb = trim($_POST["foodGroup"]);
            $macrosForDb =trim($_POST["macros"]);
            $caloriesForDb = trim($_POST["calories"]);  
            $mealNameForDb= trim($_POST["mealName"]);
            $dateForDb = trim($_POST["date"]);
            
           
            //Set sql statement for database.
            $insQuery = "INSERT INTO  meal (`mealType`,`foodGroup`,`macros`, `calories`, `mealName`, `date`) values(?,?,?,?,?,?)";
            $statement = $db->prepare($insQuery);
            
           
            //Binds the variable to each ?.
            $statement->bind_param("ssssss",$mealTypeForDb,$foodGroupForDb,$macrosForDb, $caloriesForDb, $mealNameForDB, $dateForDb);
         
            //Runs statemnt
            $statement->execute();
          

            //Success message 
            echo '<div class="messages"><h4>Success: ' . $statement->affected_rows . ' meal added to your planner.</h4>';
            
            //Close Database 
            $statement->close();
        }
        }
      }
    ?>



<?php
/*Creates a html form for posting the data base. Uses the upper php to post    */ ?>
    <form id="addForm" name="addForm" action="Meal.php" method="post" onsubmit="return validate(this);">
          <fieldset> 
            <legend>Add Meal</legend>
            <div class="formData">

                
                <label class="field" for="mealType" >Meal Type:</label>  
                <div class="value"><input type="text"  size="60" value="<?php echo $mealType; ?>" name="mealType" id="mealType"> <em> Breakfast, Lunch, Dinner, etc. </em></div>


                <br>

                <label class="field" for="foodType" >Food Group:</label>  
                <div class="value"><input type="text"  size="60" value="<?php echo $foodGroup; ?>" name="foodGroup" id="foodGroup"> <em> Fruit, Grains, Meat, etc. </em> </div>

                <br>

                <label class="field" for="macros" >Macros:</label>  
                <div class="value"><input type="text"  size="60" value="<?php echo $macros; ?>" name="macros" id="macros"> <em>Protein, Fats, Carbs</em></div>
                <br>


                <label class="field" for="mealName" >Meal Name:</label> 
                <div class="value"><input type="text"  size="60" value="<?php echo $mealName; ?>" name="mealName" id="mealName"> </div>

                <br>

                <label class="field" for="calories" >Calories:</label>    
                <div class="value"><input type="text"  size="60" value="<?php echo $calories; ?>" name="calories" id="calories"> </div>

                <br>

                <label class="field" for="date" >Date:</label> 
                <div class="value"><input id="date" name="date" type="date" value="<?php echo $date; ?>"><em>yyyy-mm-dd</em></div>
                <br>

              <input type="submit" value="save" id="save" name="save"/>
            </div>
          </fieldset>
        </form>



<?php /*Creates a table retriving data from the database using a query statement, then with the result variable, echo out html with the row's values */ ?>
<h3>Meals</h3>
<table id="mealTable">
<?php


    $query = 'select * from meal order by date';
    $result = $db->query($query);
    $numRecords = $result->num_rows;
    
 
    for ($i=0; $i < $numRecords; $i++) {
      $record = $result->fetch_assoc();
  
      echo '</td><td>';
      echo htmlspecialchars($record['mealType']) .' |   ' ;
      echo htmlspecialchars($record['foodGroup']);
      echo '</td><td>';
      echo htmlspecialchars($record['calories']);    
      echo '</td><td>';
      echo htmlspecialchars($record['macros']);
      echo '</td><td>';
        
      echo htmlspecialchars($record['date']);
      echo '</td><td>';
      
      echo '</td></tr>';
   
    }
    // Finally, let's close the database
    $result->free();
    
    

  
?>
</table>




  <?php include('./resources/includes/foot.inc.php'); 
  // footer info and closing tags
?>

