<?php 
  include('./resources/includes/init.inc.php'); // include the DOCTYPE and opening tags

?>
<title>Meal Planner</title>   

<?php 
  include('./resources/includes/head.inc.php'); 
  // include global css, javascript, end the head and open the body
?>



<?php 
    @ $db = new mysqli('localhost', 'root', '', 'upYourGains');
    if ($db->connect_error) {
        echo '<div class="messages">Could not connect to the database. Error: ';
        echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
    }else {
     $dbOk = true; 
    }
  
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
  
        $mealType = htmlspecialchars(trim($_POST["mealType"]));  
        $foodGroup = htmlspecialchars(trim($_POST["foodGroup"]));
        $macros =htmlspecialchars(trim($_POST["macros"]));
        $calories = htmlspecialchars(trim($_POST["calories"]));  
        $mealName= htmlspecialchars(trim($_POST["mealName"]));
        $date = htmlspecialchars(trim($_POST["date"]));


    
        $dateTime = strtotime($date);
        $dateFormat = 'Y-m-d';
          
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
        if ($dbOk) {

            $mealTypeForDb = trim($_POST["mealType"]);  
            $foodGroupForDb = trim($_POST["foodGroup"]);
            $macrosForDb =trim($_POST["macros"]);
            $caloriesForDb = trim($_POST["calories"]);  
            $mealNameForDb= trim($_POST["mealName"]);
            $dateForDb = trim($_POST["date"]);
            
           
            
            $insQuery = "INSERT INTO  meal (`mealType`,`foodGroup`,`macros`, `calories`, `mealName`, `date`) values(?,?,?,?,?,?)";
            $statement = $db->prepare($insQuery);
            
           
        
            $statement->bind_param("ssssss",$mealTypeForDb,$foodGroupForDb,$macrosForDb, $caloriesForDb, $mealNameForDB, $dateForDb);
         
            
            $statement->execute();
          

     
            echo '<div id="content"><h4>Success: ' . $statement->affected_rows . ' meal added to your planner.</h4>';
  
            $statement->close();
        }
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




<h3>Meals</h3>
<table id="mealTable">
<?php


    $query = 'select * from meal order by date';
    $result = $db->query($query);
    $numRecords = $result->num_rows;
    
 
    for ($i=0; $i < $numRecords; $i++) {
      $record = $result->fetch_assoc();
  
      
     
      echo '</td><td>';
      echo htmlspecialchars($record['mealType']) .'    ' ;
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
    
    $result->free();
    
    // Finally, let's close the database

  
?>
</table>




  <?php include('./resources/includes/foot.inc.php'); 
  // footer info and closing tags
?>

