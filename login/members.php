<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Member Area | Source Code Checker</title>
<?php
include "db-info.php";
include_once '../css/css.php';
include_once  '../js/js.php';
include_once '../header.php';
?>
<?php 
if(!isset ($_SESSION ['Admin'])) {
	echo "<h1>You don't have access the this area</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	return ("redirecting");
	exit ("redirecting");
}

if ($_SESSION ['Admin'] == 1) {
	
	echo "<h1>Hold on a second...</h1>";
	echo "<p>We are now redirecting you the Admin area</p>";
	echo "<meta http-equiv='refresh' content='2;admin.php' />"; // Meta refresh
	exit ();
}

if (isset ($_POST['enroll-btn'])){
	
	$checkkey = mysqli_query($db_conn, "SELECT EnrollKey FROM `courses` WHERE EnrollKey= '".$_POST['enroll-key']."' AND CourseID = ".$_POST['enroll-btn']);
	$row = mysqli_fetch_array ( $checkkey );
	var_dump($row);
	if ( $_POST ['enroll-key'] == $row['EnrollKey']){
	$enroll = $db_conn->prepare ( "INSERT INTO `enrollments` (`Username`, `CourseID`) VALUES (?,?)" );
	$enroll->bind_param ( 'ss', $_SESSION['Username'], $_POST ['enroll-btn']);
	$enroll->execute ();
	$enroll->close ();
	}
	else{
		echo "THE ENROLLMENT KEY DOES NOT MATCH! DISMISABLE ALERT!";
	}
}

?>
<h1>Member Area</h1>
<p>
	Thanks for logging in! You are

	<code><?php echo $_SESSION['Username'] ?></code>
	and your email address is
	<code><?php echo $_SESSION['Email']?></code>
	<p>
		<a href="logout.php">Log out</a>
	</p>

	<h1>My Courses</h1>
<?php

$mycourses = mysqli_query( $db_conn, "SELECT Course, `courses`.CourseID FROM `courses` INNER JOIN enrollments ON enrollments.courseID = courses.CourseID WHERE Username = '$_SESSION[Username]' ORDER BY Course" );
if (mysqli_num_rows ( $mycourses ) == 0) {
	echo '<div class="alert alert-info" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
  You are not enrolled in any courses
</div>';
} else {
	echo '<table class = "table">';
	while ( $row = mysqli_fetch_array ( $mycourses ) ) { // Creates a loop to loop through results
		$course = $row ['Course'];
		$courseid = $row ['CourseID'];
		echo "<tr><td><a href='course.php?course=$course&courseid=$courseid'>$course</a></td></tr>";
	}
	echo "</table>";
}

?>

<?php
echo '<h1>Enrollment</h1>';
echo '<form action="members.php" method="get" name="search-form" id="search-form">
		<input name = "search" type="text" class="form-control" placeholder="Search a course to enroll in">
		<button type="submit" value = "hello" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search</button>
	</form>';

if (isset($_GET['search'])){
	$searchpattern = $_GET['search'];
$getcoursesearch = mysqli_query($db_conn, "SELECT * FROM `courses` WHERE Course LIKE '%$searchpattern%' ORDER BY Course ASC");
echo"<h2>Search Results</h2>";
$numRows = mysqli_num_rows ( $getcoursesearch );
mysqli_data_seek($mycourses,0);
$allmycourses = mysqli_fetch_all ($mycourses);

if ($numRows == 0) {
	echo "<p class = 'alert alert-danger'>No courses found matching '$searchpattern'</p>";
}else{
	
	echo "<p style = 'margin-bottom: 10px;' class = 'alert alert-success'>$numRows course(s) found matching '$searchpattern'";
	echo '<table class ="table-striped table">';
	echo "<thead>
			<tr>
				<th>Courses</th>
			</tr>
		  </thead>
		  <tbody>";
	
while ( $row = mysqli_fetch_array ( $getcoursesearch ) ) {
			echo '<tr>
					<td>' . $row ['Course'];
			$popover= '<p>
			<strong><em>Enrollment key</em></strong>
			</p>
			<form method="post" action="members.php" name="delete-form" id="delete-form">
				<input type = "text" name = "enroll-key" id="enroll-key">
				<button type="submit" class="btn btn-success" name="enroll-btn" id="enroll-btn" value = "'.$row['CourseID'].'">Submit</button>
	
			</form>';
	
	echo '<button style="float: right;" type="button" class="btn btn-primary btn-sm"
			data-toggle="popover" data-placement="left" data-trigger="click" data-html="true" title=""
					data-content='."'$popover'".'>';
	echo '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				Enroll</button>';
				echo'</td></tr>';
	}
	
	}
}
echo'</thead></table>';
?>		
		<script type="text/javascript">
$("[data-toggle=popover]").popover();
</script>