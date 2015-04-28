<?php
include "db-info.php";
include '../css/css.php';
include '../js/js.php';
include '../header.php';

if (isset ( $_SESSION ['LoggedIn'] ) && isset ( $_SESSION ['Username'] )) // If user is already logged in
{
	echo '<meta http-equiv="refresh" content="0;members.php">';
} elseif (isset ( $_POST ['username'] ) && isset ( $_POST ['password'] )) // If user has submitted username and password
{
	$username = $_POST ['username'];
	if ($checklogin = $db_conn->prepare ( "SELECT * FROM users WHERE Username LIKE BINARY ?" )) {
		$checklogin->bind_param ( 's', $username );
		$checklogin->execute ();
		$result = $checklogin->get_result ();
		$checklogin->close ();
	}
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc ();
		
		if (password_verify ( $_POST ['password'], $row ['Password'] )) {
			$_SESSION ['Username'] = $username;
			$_SESSION ['Email'] = $row ['Email'];
			$_SESSION ['LoggedIn'] = 1;
			$_SESSION ['Admin'] = $row ['Admin'];
			
			if ($_SESSION ['Admin'] != 0) {
				echo "<meta http-equiv='refresh' content='0;admin.php' />";
			} else {
				echo "<meta http-equiv='refresh' content='0;index.php' />"; // Meta refresh
			}
			exit();
		}
	}
	
	echo "<h1>Error</h1>";
	echo "<p>Sorry, your log in was unsuccessful. Please <a href=\"index.php\">click here to try again</a>.</p>";
	
}else{	
	
	?>
<h1>Member Login</h1>

<p>
	Thanks for visiting! Please either login below, or <a
		href="register.php">click here to register</a>.
</p>

<form method="post" action="index.php" name="loginform" id="loginform">
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