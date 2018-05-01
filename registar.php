<?php 
  include('./resources/includes/init.inc.php'); // include the DOCTYPE and opening tags<?php 

?>
<title>Registar</title>   

<?php 
  include('./resources/includes/login_head.inc.php'); 
  // include global css, javascript, end the head and open the body
?>



<?php 
    @ $db = new mysqli('localhost', 'root', 'issachkim99', 'upYourGains');
    if ($db->connect_error) {
        echo '<div class="messages">Could not connect to the database. Error: ';
        echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
    }else {
     $dbOk = true; 
    }
  
      $userName='';
      $password = '';  
   


      // hold any error messages
      $errors = ''; 

    
      $havePost = isset($_POST["save"]);

      if ($havePost) {
  
        $userName = htmlspecialchars(trim($_POST["userName"]));  
        $password = htmlspecialchars(trim($_POST["password"]));
        

        // Let's do some basic validation
        $focusId = ''; // trap the first field that needs updating, better would be to save errors in an array

        if ($userName == '') {
          $errors .= '<li>Must have a User Name</li>';
          if ($focusId == '') $focusId = '#userName';
        }
        if ($password == '') {
          $errors .= '<li>Enter a password</li>';
          if ($focusId == '') $focusId = '#password';
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
            
            
            $query = "select * from users where username='$userName'";
            $statement = $db->prepare($query);
            
            $rows = mysql_num_rows($statement);
            if ($rows >= 1) {
                echo 'Username already taken';
               
            } else {
                
                
                $userNameForDb = trim($_POST["userName"]);  
                $passwordForDb = trim($_POST["password"]);
                $insQuery = "INSERT INTO  users (`userName`,`password`) values(?,?)";
                $statement = $db->prepare($insQuery);
                $statement->bind_param("ss",$userNameForDb,$passwordForDb);


                $statement->execute();
                echo '<div class="messages"><h4>You have successfully joined Up Your Gains. </h4>';


            
            }
        $statement->close();
          
        }
        }
      }
    ?>
<form id="addForm" name="addForm" action="Login.php" method="post" onsubmit="return validate(this);">
          <fieldset> 
            <legend>Login</legend>
            <div class="formData">
                <label class="field" for="userName" >Username</label>  
                <div class="value"><input type="text"  size="60" value="<?php echo $userName; ?>" name="userName" id="userName"> </div>


                <br>

                <label class="field" for="password" >Password:</label>  
                <div class="value"><input type="text"  size="60" value="<?php echo $password; ?>" name="password" id="password"> </div>

                <br>
              <input type="submit" value="save" id="save" name="save"/>
            </div>
          </fieldset>
        </form>


  <?php include('./resources/includes/foot.inc.php'); 
  // footer info and closing tags
?>



?>
<title>Login</title>   

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
      $password = '';  
   


      // hold any error messages
      $errors = ''; 

    
      $havePost = isset($_POST["save"]);

      if ($havePost) {
  
        $userName = htmlspecialchars(trim($_POST["userName"]));  
        $password = htmlspecialchars(trim($_POST["password"]));
        

        // Let's do some basic validation
        $focusId = ''; // trap the first field that needs updating, better would be to save errors in an array

        if ($userName == '') {
          $errors .= '<li>Must have a User Name</li>';
          if ($focusId == '') $focusId = '#userName';
        }
        if ($password == '') {
          $errors .= '<li>Enter a password</li>';
          if ($focusId == '') $focusId = '#password';
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
            
            $query = "select * from login where username='$userName'";
            $statement = $db->prepare($query);
            $rows = $statement->affected_rows ;
            if ($rows >= 1) {
               echo 'Username taken';
                
            } else { 
            $insQuery = "INSERT INTO  users (`userName`,`password`) values(?,?)";
            $statement = $db->prepare($insQuery);
                
                
            $statement->bind_param("ss",$userNameForDb,$passwordForDb);
         
            
            $statement->execute();
          

     
            echo '<div class="messages"><h4>Thanks for joining Up Your Gains. Please login on login page.</h4>';
  
            $statement->close();
            
            }
            mysql_close($connection);
        }
        }
      }
    ?>
<form id="addForm" name="addForm" action="Login.php" method="post" onsubmit="return validate(this);">
          <fieldset> 
            <legend>Login</legend>
            <div class="formData">
                <label class="field" for="userName" >Username</label>  
                <div class="value"><input type="text"  size="60" value="<?php echo $userName; ?>" name="userName" id="userName"> </div>


                <br>

                <label class="field" for="password" >Password:</label>  
                <div class="value"><input type="text"  size="60" value="<?php echo $password; ?>" name="password" id="password"> </div>

                <br>
              <input type="submit" value="save" id="save" name="save"/>
            </div>
          </fieldset>
        </form>








  <?php include('./resources/includes/foot.inc.php'); 
  // footer info and closing tags
?>

