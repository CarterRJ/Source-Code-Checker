<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Area | Source Code Checker</title>
<?php
include_once '../css/css.php';
include_once '../js/js.php';
include_once '../header.php';

include "db-info.php";
if(!isset ($_SESSION ['Admin']) || $_SESSION ['Admin'] == 0) {
	
	echo "<h1>You don't have access the this area</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	return ("redirecting");
	exit ("redirecting");
}
if (isset ( $_POST ['course-delete'] )) {
		$deletecourse = $db_conn->prepare ( 'DELETE FROM `courses` WHERE `CourseID` = ?' );
		$deletecourse->bind_param ( 's', $_POST ['course-delete'] );
		$deletecourse->execute ();
		$deletecourse->close ();
}
if (isset ( $_POST ['course-rename']) && (!empty($_POST ['course-rename']))) {
	$renamecourse = $db_conn->prepare ( 'UPDATE `courses` SET `EnrollKey` = ?, `Course` = ? WHERE `CourseID` = ?' );
	$renamecourse->bind_param ( 'sss', $_POST ['enroll-key'], $_POST ['course-rename'], $_POST ['course-rename-btn']);
	$renamecourse->execute ();
	$renamecourse->close ();
}

?>
<ol class="breadcrumb">
			<li><a href="admin.php">Home</a></li>
		</ol>
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

if (! empty ( $_POST ['course'] )) {
	$newcourse = mysqli_query ( $db_conn, "INSERT INTO `courses` (`CourseID`, `Course`, `EnrollKey`) VALUES (NULL, '" . $_POST ['course'] . "','".$_POST ['EnrollKey']."')" );
	$enrolnewcourse = mysqli_query ( $db_conn, "INSERT INTO `enrollments` (`Username`, `CourseID` ) VALUES ('" . $_SESSION ['Username'] . "', (SELECT CourseID FROM `Courses` WHERE Course = '" . $_POST ['course'] . "'))" );
}

$mycourses = mysqli_query ( $db_conn, "SELECT * FROM `courses` INNER JOIN enrollments ON enrollments.courseID = courses.CourseID WHERE Username = '$_SESSION[Username]' ORDER BY Course" );

echo '<table class = "table">';
while ( $row = mysqli_fetch_array ( $mycourses ) ) {
	$course = $row ['Course'];
	$courseID = $row ['CourseID'];
	
	echo "<tr><th><a href='course.php?course=$course&courseid=$courseID'>$course</a>";
	$del_popover = '<p>
			<strong><em> Are you sure?</em></strong>
			</p>
			<form method="post" action="admin.php" name="delete-form" id="delete-form">
				<button type="submit" class="btn btn-success" name="course-delete" id="delete-btn" value = "' . $row ["CourseID"] . '">Yes</button>
	
			</form>';
	echo '<button style="float: right;" type="button" class="btn btn-danger btn-default btn-sm"
			data-toggle="popover" data-placement="left" data-trigger="focus" data-html="true" title=""
					data-content=' . "'$del_popover'" . '>';
	echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				Delete</button>';
	
	$popover= '<p style = "margin: 0;">
			<strong><em>Course name</em></strong>
			</p>
			<form method="post" action="admin.php" name="delete-form" id="delete-form">
				<input type = "text" value = "'.$course.'" name = "course-rename" id="course-rename">
		<p style = "margin: 0;"><strong><em>Enrollement Key</em></strong></p>
				<input type = "text" value = "'. $row['EnrollKey'].'"name = "enroll-key" id="enroll-key">
				<button type="submit" class="btn btn-success" name="course-rename-btn" id="delete-btn" value = "'.$courseID.'">Submit</button>
	
			</form>';
	
	echo '<button style="float: right;" type="button" class="btn btn-warning btn-default btn-sm"
			data-toggle="popover" data-placement="left" data-trigger="click" data-html="true" title=""
					data-content='."'$popover'".'>';
	echo '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				Rename/Edit</button>';
	echo '<form style="float: right;" method="post" action="addAssignment.php" name="addAssignment-form" id="addAssignment-form">
			<input type = "hidden" name ="addAssignment-course" value = "'.$row["Course"].'">
			<button name="addAssignment-id" value="'.$row["CourseID"].'" type="submit" class="btn btn-success btn-default btn-sm">
			<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
			Manage Assignments</button></form></th></tr>';
					

}
if (mysqli_num_rows($mycourses) == 0){
	echo "<p class = 'alert alert-danger'>You are not assigned to any courses.</p>";
}

echo "</table>";

// Free result set
mysqli_free_result ( $mycourses );
?>
		<h2>Create a new Course</h2>
		<form method="post" action="admin.php" name="newcourseform"
			id="newcourseform">
			<fieldset>
				<label for="course">Course Name:</label>
				<input type="text" name="course" id="course" /><br />
				
				<label for="EnrollKey">Enrollment Key:</label>
				<input type="text" name="EnrollKey" id="EnrollKey" /><br />
				<input type="submit" name="newcourse" id="newcourse" value="Submit" />
			</fieldset>
		</form>
		
<script type="text/javascript">
$("[data-toggle=popover]").popover();
</script>

	</div>
</body>
</html>