<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Area | Source Code Checker</title>
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
				<li><a href="logout.php"><strong>Log out</strong></a></li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container --> </nav>
	<!-- /.navbar -->
	<div id="main">
<?php
include "db-info.php";
if ($_SESSION ['Admin'] == 0) {
	
	echo "<h1>You don't have access the this area</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
}
?>
<h1>Admin Area</h1>
		<p>
			Thanks for logging in! You are

			<code><?php echo $_SESSION['Username'] ?></code>
			and your email address is
			<code><?php echo $_SESSION['Email']?></code>
		</p>
		<a href="logout.php">Log out</a>
		<h2>My courses</h2>
<?php

if (!empty ( $_POST ['course'] )){
	var_dump($_POST);
	echo $newcourse = mysqli_query ( $db_conn, "INSERT INTO `courses` (`CourseID`, `Course`) VALUES (NULL, '".$_POST['course']."')");
	echo $enrolnewcourse = mysqli_query($db_conn,"INSERT INTO `enrollments` (`Username`, `CourseID` ) VALUES ('".$_SESSION['Username']."', (SELECT CourseID FROM `Courses` WHERE Course = '".$_POST['course']."'))"); 
}


$mycourses = mysqli_query ( $db_conn, "SELECT * FROM `courses` INNER JOIN enrollments ON enrollments.courseID = courses.CourseID WHERE Username = '$_SESSION[Username]' ORDER BY Course" );

echo '<table class = "table">';
while ( $row = mysqli_fetch_array ( $mycourses ) ) { // Creates a loop to loop through results
	$course = $row ['Course'];
	echo "<tr><th><a href='course.php?course=$course'>$course</a></th></tr>";
	$assignments = mysqli_query ( $db_conn, "SELECT * FROM `assignments` WHERE CourseID = " . $row ['CourseID'] );
	$found = false;
	while ( $ass_row = mysqli_fetch_array ( $assignments ) ) {
		$found = true;
		$assignment = $ass_row ['AssignmentName'];
		echo "<tr><td>$assignment</td></tr>";
	}
	if ($found == false) {
		echo "<tr><td>*none*</td></tr>";
	}
}
echo "</table>";

// Free result set
mysqli_free_result ( $mycourses );
?>
<h2>
			<a>Create a new Assignment</a>
		</h2>

		<h2>
			<a>Create a new Course</a>
		</h2>
		<form method="post" action="admin.php" name="newcourseform"
			id="newcourseform">
			<fieldset>
				<label for="course">Course Name:</label><input type="text"
					name="course" id="course" /><br /> <input type="submit"
					name="newcourse" id="newcourse" value="Submit" />
			</fieldset>
		</form>
		
		
		
		<h2>My submissions</h2>
<?php
echo '<table class ="table">';
$mysubmissions = mysqli_query ( $db_conn, "SELECT Username, Course, Filename, Directory FROM uploads INNER JOIN courses ON uploads.CourseID=courses.CourseID where Username = '$_SESSION[Username]' ORDER BY Course" );
echo "<tr>
		<th>Course</th>
		<th>Filename</th>
		<th>Directory</th>
		</tr>";
while ( $row = mysqli_fetch_array ( $mysubmissions ) ) { // Creates a loop to loop through results
	$filename = $row ['Filename'];
	$directory = $row ['Directory'];
	$course = $row ['Course'];
	echo "<tr><td>$course</td><td><a href='..$directory/$filename'>$filename</a></td><td>$directory</td></tr>";
}
echo "</table>";
// Free result set
mysqli_free_result ( $mysubmissions );
echo '$_SESSION:';
var_dump ( $_SESSION );
?>

</div>
</body>
</html>