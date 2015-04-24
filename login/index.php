<?php include "db-info.php";
include '../css/css.php';
include '../js/js.php';
include '../header.php';

if (isset ( $_SESSION ['LoggedIn'] ) && isset ( $_SESSION ['Username'] )) // If user is already logged in
{
	
	?>
 <meta http-equiv="refresh" content="0;members.php">
    
      
     <?php
} elseif (isset ( $_POST ['username'] ) && isset ( $_POST ['password'] )) // If user has submitted username and password
{
	$username = mysqli_escape_string ( $db_conn, $_POST ['username'] );
	$password = md5 ( mysqli_escape_string ( $db_conn, $_POST ['password'] ) );
	
	$checklogin = mysqli_query ( $db_conn, "SELECT * FROM users WHERE Username LIKE BINARY '" . $username . "' AND Password LIKE BINARY '" . $password . "'" );
	if (mysqli_num_rows ( $checklogin ) == 1) {
		$row = mysqli_fetch_array ( $checklogin );
		$email = $row ['Email'];
		$admin = $row ['Admin'];
		
		$_SESSION ['Username'] = $username;
		$_SESSION ['Email'] = $email;
		$_SESSION ['LoggedIn'] = 1;
		$_SESSION ['Admin'] = $admin;
		
		//echo "<h1>Success</h1>";
		//echo "<p>We are now redirecting you to the member area.</p>";
		
		if($_SESSION['Admin'] != 0){
			echo "<meta http-equiv='refresh' content='0;admin.php' />";
		}else{
		echo "<meta http-equiv='refresh' content='0;index.php' />"; // Meta refresh
		}
	} else // Login failed.
{
		echo "<h1>Error</h1>";
		echo "<p>Sorry, your account could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
	}
} else // User has not logged in
{
	?>		
		<h1>Member Login</h1>

			<p>
				Thanks for visiting! Please either login below, or <a
					href="register.php">click here to register</a>.
			</p>

			<form method="post" action="index.php" name="loginform"
				id="loginform">
				<fieldset>
					<label for="username">Username:</label><input type="text"
						name="username" id="username" /><br /> <label for="password">Password:</label><input
						type="password" name="password" id="password" /><br /> <input
						type="submit" name="login" id="login" value="Login" />
				</fieldset>
			</form>
     
   <?php
}
?>
	
	</div>
</body>
</html>