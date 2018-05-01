<?php 
  include('./resources/includes/init.inc.php'); // include the DOCTYPE and opening tags<?php 

?>
 
<?php 
  include('./resources/includes/login_head.inc.php'); 
  // include global css, javascript, end the head and open the body
?>

<title>Registar</title>  

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
       //Convert all var values into htmlcharacters and takes off white space
        $userName = htmlspecialchars(trim($_POST["userName"]));  
        $password = htmlspecialchars(trim($_POST["password"]));
        

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
        if ($dbOk) {
            //All inputs are correct so, the php 
            //will make a post to database's table.
             //Set sql statement for database.
            $query = "select * from users where username='$userName'";
            $statement = $db->prepare($query);
            
            //Username taken so return an error 
            $rows = $statement->affected_rows ;
            if ($rows >= 1) {
                echo 'Username already taken';
               
            } else { 
                //Create the account
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
<?php
/*Creates a html form for login to the data base. Uses the upper php to post new account info   */ ?>
<form id="addForm" name="addForm" action="registar.php" method="post" onsubmit="return validate(this);">
          <fieldset> 
            <legend>Create Account</legend>
            <div class="formData">
                <label class="field" for="userName" >New Username</label>  
                <div class="value"><input type="text"  size="60" value="<?php echo $userName; ?>" name="userName" id="userName"> </div>

                <br>
                <label class="field" for="password" >New Password:</label>  
                <div class="value"><input type="text"  size="60" value="<?php echo $password; ?>" name="password" id="password"> </div>

                <br>
              <input type="submit" value="save" id="save" name="save"/>
            </div>
          </fieldset>
        </form>


  <?php include('./resources/includes/foot.inc.php'); 
  // footer info and closing tags
?>



