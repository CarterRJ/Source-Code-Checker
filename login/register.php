<?php

include "db-info.php";
include '../css/css.php';
include '../js/js.php';
include_once '../header.php';

if (! empty ( $_POST ['username'] ) && ! empty ( $_POST ['password'] )) {
			
	$username = $_POST ['username'];
	$password = password_hash ( $_POST ['password'], PASSWORD_BCRYPT );
	$fname = $_POST ['fname'];
	$lname = $_POST ['lname'];
	$email = $_POST ['email'];
	
	if(strlen($_POST['password']) < 6){
		echo "<h1>Error</h1>";
		echo "<p>Sorry, your is password too short. Please go back and <a href=\"register.php\">try again</a>.</p>";
		exit();
	}
	
	if ($checkusername = $db_conn->prepare ( "SELECT * FROM users WHERE Username =?" )) {
		$checkusername->bind_param ( 's', $username );
		$checkusername->execute ();
		$checkusername->store_result ();
	}
	
	if ($checkusername->num_rows == 1) {
		echo "<h1>Error</h1>";
		echo '<p>Sorry, that username is taken. Please go back and <a href="register.php">try again</a>.</p>';
		$checkusername->close ();
	} else {
		$checkusername->close ();
		
		if ($registerquery = $db_conn->prepare ( "INSERT INTO users (Username, Password, fName, lName, Email) VALUES(?, ?, ?, ?, ?)" )) {
			$registerquery->bind_param ( 'sssss', $username, $password, $fname, $lname, $email );
			$registerquery->execute ();
			$registerquery->close ();
			echo "<h1>Success</h1>";
			echo "<p>Your account was successfully created. Please <a href=\"index.php\">click here to login</a>.</p>";
		} else {
			echo "<h1>Error</h1>";
			echo "<p>Sorry, your registration failed. Please go back and <a href=\"register.php\">try again</a>.</p>";
			exit();
		}
	}
} else {
	?>

<h1>Register</h1>

<p>Please enter your details below to register<br />
<small>Passwords must be a least 6 character long</small></p>


<form method="post" action="register.php" name="registerform"
	id="registerform">
	<fieldset>
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" required/><br />
		
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" required="" pattern=".{6,}" title ="Password must be at least 6 characters long"/><br />
		
		<label for="fname">First Name:</label>
		<input type="text" name="fname" id="fname" /><br />
		
		<label for="lname">Last Name:</label>
		<input type="text" name="lname" id="lname" /><br />
		
		<label for="email">Email Address:</label>
		<input type="email" name="email" id="email" /><br />
		
		<input type="submit" name="register" id="register" value="Register" />
	</fieldset>
</form>

<?php
}
?>

</div>
</body>
</html>