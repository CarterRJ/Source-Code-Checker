<?php include "db-info.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login | Source Code Checker</title>
<link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="../css/lighter.css" type="text/css" />
<link rel="stylesheet" href="../css/login.css" type="text/css" />
<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script>
		$(".nav-link").click(
				function(e) {
					e.preventDefault();
					var link = $(this);
					var href = link.attr("href");
					$("html,body").animate({
						scrollTop : $(href).offset().top - 80
					}, 500);
					link.closest(".navbar").find(
							".navbar-toggle:not(.collapsed)").click();
				});
	</script>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target=".navbar-ex1-collapse">
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand nav-link" href="../#top">Ryan Carter - Source
				Code Checker</a>
		</div>
		<!-- /.navbar-header -->

		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../#features" class="nav-link">Features</a></li>
				<li><a href="../#faqs" class="nav-link">FAQs</a></li>
				<li><a href="../#about" class="nav-link">About</a></li>
				<li><a href="../#contact">Contact Us</a></li>
				<li><a href="."><strong>Log in</strong></a></li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container --> </nav>
	<!-- /.navbar -->
	<div id="main">
<?php
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
		
		//session_regenerate_id();
		echo "<h1>Success</h1>";
		echo "<p>We are now redirecting you to the member area.</p>";
		
		if($_SESSION['Admin'] != 0){
			echo "<meta http-equiv='refresh' content='1;admin.php' />";
		}else{
		echo "<meta http-equiv='refresh' content='1;index.php' />"; // Meta refresh
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