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
if ($_SESSION ['Admin'] == 0) {
	
	echo "<h1>You don't have access the this area</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
}

if (isset ( $_GET ['username'] ) ){
	$user = $_GET ['username'];
	if (! isset ( $_SESSION ['course'] ) && ! isset ( $_SESSION ['courseid'] )) {
		echo "<meta http-equiv='refresh' content='0;index.php' />";
	}
} 

/*if (isset ( $_POST ['course-rename']) && (!empty($_POST ['course-rename']))) {
	$renamecourse = $db_conn->prepare ( 'UPDATE `courses` SET `EnrollKey` = ?, `Course` = ? WHERE `CourseID` = ?' );
	$renamecourse->bind_param ( 'sss', $_POST ['enroll-key'], $_POST ['course-rename'], $_POST ['course-rename-btn']);
	$renamecourse->execute ();
	$renamecourse->close ();
}*/

$coursecheck = mysqli_query ( $db_conn, "SELECT * FROM `courses` WHERE CourseID = '" . $_SESSION ['courseid'] . "' AND Course = '" . $_SESSION ['course'] . "'" );
if (mysqli_num_rows ( $coursecheck ) > 0) {
	$courseid = $_SESSION ['courseid'];
	$course = $_SESSION ['course'];
	echo '<ol class="breadcrumb">';
	if ($_SESSION ['Admin'] == 0) {
		echo '<li><a href="members.php">Home</a></li>';
	} else {
		echo '<li><a href="admin.php">Home</a></li>';
	}
	echo '<li class="active">' . $course . '</a></li>
		</ol>';
	echo "<h1> $course </h1>";
	$getall = mysqli_query ( $db_conn, "SELECT * FROM `grades` INNER JOIN `testcases` ON `grades`.`TestCaseID` = `testcases`.`TestCaseID` INNER JOIN `assignments` ON `testcases`.AssignmentID = `assignments`.AssignmentID WHERE Username = '$user' AND CourseID = '$courseid'" );
	$getassignments = mysqli_query ( $db_conn, "SELECT * FROM `assignments` WHERE CourseID = $courseid ORDER BY AssignmentName ASC" );
	if (mysqli_num_rows ( $getassignments ) == 0) {
		echo "<p class = 'alert alert-danger'>There are no assignmets</p>";
	} 

	else {
		while ( $row = mysqli_fetch_assoc ( $getassignments ) ) {
			echo '<h2><a href="assignment.php?assign=' . $row ['AssignmentName'] . '&assignid=' . $row ['AssignmentID'] . '">' . $row ['AssignmentName'] . "</a>";
			$getAVGassignGrade = mysqli_query ( $db_conn, "SELECT AVG(Grade) AS avgGrade FROM `grades` INNER JOIN `testcases` ON `grades`.`TestCaseID` = `testcases`.`TestCaseID` WHERE Username = '$user' AND AssignmentID = '" . $row ['AssignmentID'] . "'" );
			echo "<p style = 'float: right;'>" . mysqli_fetch_assoc ( $getAVGassignGrade )['avgGrade'] . "%</p></h2>";
			$gettests = mysqli_query ( $db_conn, "SELECT * FROM `testcases` WHERE AssignmentID ='" . $row ['AssignmentID'] . "' ORDER BY TestCaseName ASC" );
			if (mysqli_num_rows ( $gettests ) == 0) {
				echo "<p class = 'alert alert-danger'>There are no tests</p>";
			} 

			else {
				echo '<table class ="table-striped table">';
				echo "<thead><tr>
		<th>Tests</th>
		<th>Grade</th>
		<th></th>
		</tr></thead><tbody>";
				while ( $testcase = mysqli_fetch_assoc ( $gettests ) ) {
					$getgrades = mysqli_query ( $db_conn, "SELECT * FROM `grades` WHERE TestCaseID ='" . $testcase ['TestCaseID'] . "' AND Username = '$user'" );
					echo "<tr><td><h4>" . $testcase ['TestCaseName'] . "</td></h4>";
					
					if (mysqli_num_rows ( $getgrades ) == 0) {
						echo "<td>*No grade*</td></p>";
					} else {
						$grade = mysqli_fetch_assoc ( $getgrades );
						echo "<td><h4>" . $grade ['Grade'] . "</h4></td>";
					}
					
					echo "<td style = 'width: 25%;';><p><span class ='btn-sm glyphicon glyphicon-download-alt'></span><a href= 'download.php?username=$user&testcaseid=" . $testcase ['TestCaseID'] . "'>Download Source</a></p>";
							echo "<p><span class ='btn-sm glyphicon glyphicon glyphicon-comment'></span><a href= 'comments.php?username=$user&testcaseid=" . $testcase ['TestCaseID'] . "'>View Comments</a></p></td></tr>";
				}
			}
			echo "</tbody></table>";
		}
	}
} else {
	echo "<h1>Something went wrong</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;admin.php' />"; // Meta refresh
	exit ();
}

?>