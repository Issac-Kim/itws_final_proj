<?php 
  include('./resources/includes/init.inc.php'); // include the DOCTYPE and opening tags

?>
<title>Meal Planner</title>   

<?php 
  include('./resources/includes/workout_head.inc.php'); 
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
      $workoutName = '';  
      $day= '';
      $date = '';  


      // hold any error messages
      $errors = ''; 

    
      $havePost = isset($_POST["save"]);

      if ($havePost) {
  
         
        $day = htmlspecialchars(trim($_POST["day"])); 
        $workoutName=htmlspecialchars(trim($_POST["workoutName"]));
        $date = htmlspecialchars(trim($_POST["date"]));


    
        $dateTime = strtotime($date);
        $dateFormat = 'Y-m-d';
          
        $dateOk = (date($dateFormat, $dateTime) == $date);  

        // Let's do some basic validation
        $focusId = ''; // trap the first field that needs updating, better would be to save errors in an array

    
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
        if ($dbOk) {

           
            $dateForDb = trim($_POST["date"]);
            $workoutNameForDb =trim($_POST["workoutName"]);
            $dayForDb = trim($_POST["day"]);  
          
           
            
            $insQuery = "INSERT INTO  workout (`workoutName`, `day`,`date`) values(?,?,?)";
            $statement = $db->prepare($insQuery);
            
           
        
            $statement->bind_param("sss",$workoutNameForDb, $dayForDb,$dateForDb);
         
            
            $statement->execute();
          

     
            echo '<div class="messages"><h4>Success: ' . $statement->affected_rows . ' workout added to your planner.</h4>';
  
            $statement->close();
        }
        }
      }
    ?>

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
                       <table id="tbl" align="center">
          <tr>
            <th>Sunday</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
          </tr>
          <tr>
            <td>
              <ul id="sunday"></ul>
            </td>
              <td>
                <ul id="monday"></ul>
              </td>
              <td>
                <ul id="tuesday"></ul>
              </td>
              <td>
                <ul id="wednesday"></ul>
              </td>
              <td>
                <ul id="thursday"></ul>
              </td>
              <td>
                <ul id="friday"></ul>
              </td>
              <td>
                <ul id="saturday"></ul>
              </td>

          </tr>
        </table>

              <input type="submit" value="save" id="save" name="save" onclick="addWork();"/>
            </div>
        </fieldset>
    </form>




  <?php include('./resources/includes/foot.inc.php'); 
  // footer info and closing tags
?>

