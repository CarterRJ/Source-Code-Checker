<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Area | Source Code Checker</title>
</head>
<?php
include_once '../css/css.php';
include_once '../js/js.php';
include 'logout-header.php';

include "db-info.php";
if (empty ( $_SESSION ))
	$_SESSION ['Admin'] = 0;
if ($_SESSION ['Admin'] == 1) {
	
	echo "<h1>You don't have access the this area</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
}
echo'SESSION';
var_dump($_SESSION);
echo'GET';
var_dump($_GET);
if (! isset ( $_GET ['testcaseid'] ) ){
	if (! isset ( $_SESSION ['testcaseid'] )) {
		echo "<meta http-equiv='refresh' content='0;index.php' />";
		exit ();
	}
} else {
	$_SESSION ['testcaseid'] = $_GET ['testcaseid'];
}

$course = $_SESSION ['course'];
$courseid = $_SESSION ['courseid'];
$assign = $_SESSION ['assign'];
$testcaseid = $_SESSION ['testcaseid'];

$gettestcases = mysqli_query ( $db_conn, "SELECT * FROM `testcases` WHERE TestCaseID = $testcaseid" );
if (mysqli_num_rows ( $gettestcases ) != 1) {
	echo "<h1>Something went wrong</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
} else {
	$row = mysqli_fetch_array ( $gettestcases, MYSQLI_ASSOC );
	$checkenroll = mysqli_query ( $db_conn, "SELECT * FROM assignments INNER JOIN enrollments ON assignments.CourseID=enrollments.CourseID WHERE AssignmentID = " . $row ['AssignmentID'] . " AND Username = '" . $_SESSION ['Username'] . "'" );
	if (mysqli_num_rows ( $checkenroll ) != 1) {
		echo "<h1>Something went wrong</h1>";
		echo "<p>We are now redirecting you...</p>";
		echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
		exit ();
	} else {
		$testcase = $row ['TestCaseName'];
		var_dump ( $row );
		echo '<ol class="breadcrumb">';
		echo '<li><a href="members.php">Home</a></li>';
		echo '<li><a href="course.php">' . $course . '</a></li>
			<li><a href="Assignment.php">' . $assign . '</a></li>
			<li class="active">' . $testcase . '</a></li>
		</ol>';
	}
	
	echo "<h1>$course</h1>";
	echo "<h2>$assign</h2>";
	echo "<h3>$testcase</h3>";
	echo "<p><small>" . $row ['Description'] . "</small></p>";
}
?>

<div class="container">
	<div class="pasteBox">
		<form action="../upload.php" method="post">
			<label for="sourcecode">Source code:</label>
			<textarea class="pasteBox" id="sourcecode" name="code"></textarea>
			<input type="submit" value="Submit">
		
		</form>
	</div>
	<div class="uploadCode">
		<form action="../upload.php" method="post" enctype="multipart/form-data">
			<label class="uploadCode" for="fileToUpload">OR select file to
				upload: </label>
			<input class="uploadCode" type="file" name="fileToUpload"
				id="fileToUpload"> <input class="uploadCode" type="submit"
				value="Upload File" name="submit">
		
		</form>
	</div>
</div>