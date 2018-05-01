<?php 
  include('./resources/includes/init.inc.php'); // include the DOCTYPE and opening tags

?>
<title>Workout Journal</title>   

<?php 
  include('./resources/includes/workout_head.inc.php'); 
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
      $workoutName = '';  
      $day= '';
      $date = '';  


      // hold any error messages
      $errors = ''; 

    
      $havePost = isset($_POST["save"]);

      if ($havePost) {
    
        //Convert all var values into htmlcharacters and takes off white space
        $day = htmlspecialchars(trim($_POST["day"])); 
        $workoutName=htmlspecialchars(trim($_POST["workoutName"]));
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
        if ($workoutName == '') {
          $errors .= '<li>Workout Name may not be blank</li>';
          if ($focusId == '') $focusId = '#workoutName';
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

           
            $dateForDb = trim($_POST["date"]);
            $workoutNameForDb =trim($_POST["workoutName"]);
            $dayForDb = trim($_POST["day"]);  
          
           
              //Set sql statement for database.
            $insQuery = "INSERT INTO  workout (`workoutName`, `day`,`date`) values(?,?,?)";
            $statement = $db->prepare($insQuery);
            
           
              //Binds the variable to each ?.
            $statement->bind_param("sss",$workoutNameForDb, $dayForDb,$dateForDb);
         
            //Runs statemnt
            $statement->execute();
          

             //Success message
            echo '<div class="messages"><h4>Success: ' . $statement->affected_rows . ' workout added to your planner.</h4>';
            
            //Close Database
            $statement->close();
        }
        }
      }
    ?>

    <?php
    /*Creates a html form for posting the data base. Uses the upper php to post    */ ?>

    <form id="addForm" name="addForm" action="workout_journal.php" method="post" onsubmit="return validate(this);">
          <fieldset> 
            <legend>Workout Enrty</legend>
            <div class="formData">
                
                
                 <label class="field" for="day" >Day: </label>
                <div class="value">
                <select  id="day" name="day">
                   <option value="Sunday">Sunday</option>
                  <option value="Monday">Monday</option>
                  <option value="Tuesday">Tuesday</option>
                  <option value="Wednesday">Wednesday</option>
                  <option value="Thursday">Thursay</option>
                  <option value="Friday">Friday</option>
                  <option value="Saturday">Saturday</option>
                </select>
                </div>
                
                <label class="field" for="workoutName" >Workout Name:</label>

            <input type="text" size="60" value="<?php echo $workoutName; ?>" name="workoutName" id="workoutName"/>
            <br>
                
            <div>Date:
                <input type="date" size="60" value="<?php echo $date;?>" name="date" id="date"/> </div>
                
            
                <style>
                  table, th, td {
                    border: 1px solid black;
                    margin-top: 10px;
                  }
                </style>
   

              <input type="submit" value="save" id="save" name="save" onclick="addWork();"/>
            </div>
        </fieldset>
    </form>


<?php /*Creates a table retriving data from the database using a query statement, then with the result variable, echo out html with the row's values */ ?>
<?php
    $query = 'select * from workout order by date';
    $result = $db->query($query);
    $numRecords = $result->num_rows;


    for ($i=0; $i < $numRecords; $i++) {
      $record = $result->fetch_assoc();

      echo '</td><td>';
      echo htmlspecialchars($record['day']) .'    ' ;
      echo htmlspecialchars($record['date']).'    ';
      echo '</td><td>';
      echo htmlspecialchars($record['workoutName']);  
      echo '<br>';

    }

    $result->free();
    // Finally, let's close the database

?>

                
                
           




<?php include('./resources/includes/foot.inc.php'); 
// footer info and closing tags
?>

