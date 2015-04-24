<?php include "db-info.php";
include_once '../header.php';

if(!empty($_POST['username']) && !empty($_POST['password']))
{
    $username = mysqli_escape_string($db_conn, $_POST['username']);
    $password = md5(mysqli_escape_string($db_conn, $_POST['password']));
    $email = mysqli_escape_string($db_conn, $_POST['email']);
     
     $checkusername = mysqli_query($db_conn, "SELECT * FROM users WHERE Username = '".$username."'");
      
     if(mysqli_num_rows($checkusername) == 1)
     {
        echo "<h1>Error</h1>";
        echo '<p>Sorry, that username is taken. Please go back and <a href="register.php">try again</a>.</p>';
     }
     else
     {
        $registerquery = mysqli_query($db_conn, "INSERT INTO users (Username, Password, Email) VALUES('".$username."', '".$password."', '".$email."')");
        if($registerquery)
        {
            echo "<h1>Success</h1>";
            echo "<p>Your account was successfully created. Please <a href=\"index.php\">click here to login</a>.</p>";
        }
        else
        {
            echo "<h1>Error</h1>";
            echo "<p>Sorry, your registration failed. Please go back and <a href=\"register.php\">try again</a>.</p>";    
        }       
     }
}
else
{
    ?>
     
   <h1>Register</h1>
     
   <p>Please enter your details below to register.</p>
     
    <form method="post" action="register.php" name="registerform" id="registerform">
    <fieldset>
        <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
        <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
        <label for="email">Email Address:</label><input type="text" name="email" id="email" /><br />
        <input type="submit" name="register" id="register" value="Register" />
    </fieldset>
    </form>
     
    <?php
}
?>
 
</div>
</body>
</html>