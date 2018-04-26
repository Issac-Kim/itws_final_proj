<?php 
  include('includes/init.inc.php'); // include the DOCTYPE and opening tags
  include('includes/functions.inc.php'); // functions
?>
<title>Meal Planner</title>   

<?php 
  include('includes/head.inc.php'); 
  // include global css, javascript, end the head and open the body
?>

 
<?php include('includes/menubody.inc.php'); ?>

<?php 
    @ $db = new mysqli('localhost', 'root', '', 'upYourGains');
    if ($db->connect_error) {
        echo '<div class="messages">Could not connect to the database. Error: ';
        echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
    }
      /* some very basic form processing */

      // variables to hold our form values:
      $userName='';
      $mealType = '';  
      $foodGroup = '';
      $macros = '';
      $calories = '';  
      $mealName= '';
      $date = '';


      // hold any error messages
      $errors = ''; 

      // have we posted?
      $havePost = isset($_POST["save"]);

      if ($havePost) {
        // Get the input and clean it.
        // First, let's get the input one param at a time.
        // Could also output escape with htmlentities()
        $mealType = htmlspecialchars(trim($_POST["mealType"]));  
        $foodGroup = htmlspecialchars(trim($_POST["foodGroup"]));
        $macros =htmlspecialchars(trim($_POST["macros"]));
        $calories = htmlspecialchars(trim($_POST["calories"]));  
        $mealName= htmlspecialchars(trim($_POST["mealName"]));
        $date = htmlspecialchars(trim($_POST["date"]));


        // special handling for the date of birth
        $dateTime = strtotime($date); // parse the date of birth into a Unix timestamp (seconds since Jan 1, 1970)
        $dateFormat = 'Y-m-d'; // the date format we expect, yyyy-mm-dd
        // Now convert the $dobTime into a date using the specfied format.
        // Does the outcome match the input the user supplied?  
        // The right side will evaluate true or false, and this will be assigned to $dobOk
        $dateOk = (date($dateFormat, $dateTime) == $date);  

        // Let's do some basic validation
        $focusId = ''; // trap the first field that needs updating, better would be to save errors in an array

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

            $mealTypeForDb = htmlspecialchars(trim($_POST["mealType"]));  
            $foodGroupForDb = htmlspecialchars(trim($_POST["foodGroup"]));
            $macrosForDb =htmlspecialchars(trim($_POST["macros"]));
            $caloriesForDb = htmlspecialchars(trim($_POST["calories"]));  
            $mealNameForDb= htmlspecialchars(trim($_POST["mealName"]));
            $dateForDb = htmlspecialchars(trim($_POST["date"]));
            // Setup a prepared statement. Alternately, we could write an insert statement - but 
            // *only* if we escape our data using addslashes() or (better) mysqli_real_escape_string().
            $insQuery = "insert into meal (`mealType`,`foodGroup`,`macros`, `calories`, `mealName`, `date`) values(?,?,?,?,?,?)";
            $statement = $db->prepare($insQuery);
            // bind our variables to the question marks
            $statement->bind_param("ssssss",$mealTypeForDb,$foodGroupForDb,$macrosForDb, $caloriesForDb, $mealNameForDB, $dateForDb);
            // make it so:
            $statement->execute();

            // give the user some feedback
            echo '<div class="messages"><h4>Success: ' . $statement->affected_rows . ' meal added to database.</h4>';
            // close the prepared statement obj 
            $statement->close();      
        }
      }
    ?>

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
                <div class="value"><input type="text"  size="60" value="<?php echo $mealName; ?>" name="macros" id="macros"> <em>Protein, Fats, Carbs</em></div>
                <br>


                <label class="field" for="mealName" >Meal Name:</label> 
                <div class="value"><input type="text"  size="60" value="<?php echo $mealName; ?>" name="mealName" id="mealName"> </div>

                <br>

                <label class="field" for="mealName" >Calories:</label>    
                <div class="value"><input type="text"  size="60" value="<?php echo $calories; ?>" name="calories" id="calories"> </div>

                <br>

                <label class="field" for="date" >Date:</label> 
                <div class="value"><input id="date" name="date" type="date" value="<?php echo $date; ?>"><em>yyyy-mm-dd</em></div>
                <br>

              <input type="submit" value="save" id="save" name="save"/>
            </div>
          </fieldset>
        </form>
  <?php include('includes/foot.inc.php'); 
  // footer info and closing tags
?>

