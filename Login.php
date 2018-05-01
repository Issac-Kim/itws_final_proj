<?php 
  include('./resources/includes/init.inc.php'); // include the DOCTYPE and opening tags

?>
<title>Login</title>   

<?php 
  include('./resources/includes/login_head.inc.php'); 
  // include global css, javascript, end the head and open the body
?>



<?php //Open the database.
    @ $db = new mysqli('localhost', 'root', '', 'upYourGains');
    if ($db->connect_error) {
        echo '<div class="messages">Could not connect to the database. Error: ';
        echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
    }else {
     $dbOk = true; 
    }
     //Variable holders
      $userName='';
      $password = '';  
   


      // hold any error messages
      $errors = ''; 

    
      $havePost = isset($_GET["save"]);

      if ($havePost) {
        //Convert all var values into htmlcharacters and takes off white space
        $userName = htmlspecialchars(trim($_GET["userName"]));  
        $password = htmlspecialchars(trim($_GET["password"]));
        

        //Used to tell what input to focus on then there is an 
        //error  output
        $focusId = ''; 
          
        //Checks for errors and then outputs them onto page.  
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
        if ($dbOk) {  //All inputs are correct so, the php 
            //will make a get to database's table.
             //Set sql statement for database.
             $query = "select * from users where username='$userName'";
            $statement = $db->prepare($query);
            
            $rows = $statement->affected_rows ;
            
            //Means that the username and password is correct
            if ($rows >= 1) {
                $_SESSION['user']=$username; // Initializing Session
                echo '<h4>Welcome, '.$userName.'</h4>';
                
            } else { //Login fail
                $error = "Username or Password is invalid";
                echo $error;
            }
            $statement->close();
        }
        }
      }
    ?>
<?php
/*Creates a html form for login to the data base. Uses the upper php to get    */ ?>
<form id="addForm" name="addForm" action="Login.php" method="get" onsubmit="return validate(this);">
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

