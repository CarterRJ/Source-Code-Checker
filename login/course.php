<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Course | Source Code Checker</title>
</head>

<?php
include "db-info.php";
include_once '../css/css.php';
include_once '../js/js.php';
include_once '../header.php';

if (! isset ( $_GET ['course'] ) && ! isset ( $_GET ['courseid'] )) {
	
	if (! isset ( $_SESSION ['course'] ) && ! isset ( $_SESSION ['courseid'] )) {
		echo "<meta http-equiv='refresh' content='0;index.php' />";
	}
} else {
	$_SESSION ['course'] = $_GET ['course'];
	$_SESSION ['courseid'] = $_GET ['courseid'];
}

if (isset ( $_POST ['course-rename']) && (!empty($_POST ['course-rename']))) {
	$renamecourse = $db_conn->prepare ( 'UPDATE `courses` SET `EnrollKey` = ?, `Course` = ? WHERE `CourseID` = ?' );
	$renamecourse->bind_param ( 'sss', $_POST ['enroll-key'], $_POST ['course-rename'], $_POST ['course-rename-btn']);
	$renamecourse->execute ();
	$renamecourse->close ();
	$_SESSION['course'] = $_POST ['course-rename'];
}

$coursecheck = mysqli_query ( $db_conn, "SELECT * FROM `courses` WHERE CourseID = '" . $_SESSION ['courseid'] . "' AND Course = '" . $_SESSION ['course'] . "'" );
if (mysqli_num_rows ( $coursecheck ) > 0) {
	$courseid = $_SESSION ['courseid'];
	$course = $_SESSION ['course'];
	echo '<ol class="breadcrumb">';
	if ($_SESSION ['Admin'] == 0) {
		echo		'<li><a href="members.php">Home</a></li>';
	}else{
	echo		'<li><a href="admin.php">Home</a></li>';
			
	}
			echo '<li class="active">' . $course . '</a></li>
		</ol>';
	echo "<h1> $course </h1>";

	if ($_SESSION ['Admin'] == 1) {
		$getstudents = mysqli_query ( $db_conn, "SELECT * FROM `enrollments` INNER JOIN users ON enrollments.Username=users.Username WHERE CourseID = '" . $_SESSION ['courseid'] . "' AND Admin = 0" );
		if (mysqli_num_rows ( $getstudents ) == 0) {
			echo "<p class = 'alert alert-danger'>No students currently enrolled</p>";
		} else {
			echo "<h2>Enrolled Students</h2>";
			echo '<table class ="table-striped table">';
			echo "<thead><tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Grade</th>
		<th></th>
		</tr></thead><tbody>";
			
			while ( $row = mysqli_fetch_array ( $getstudents ) ) {
				$getavggrade = mysqli_query($db_conn, "SELECT AVG(Grade) AS avgGrade FROM `grades` INNER JOIN `testcases` ON `grades`.`TestCaseID` = `testcases`.`TestCaseID` INNER JOIN `assignments` ON `testcases`.AssignmentID = `assignments`.AssignmentID WHERE Username = '".$row ['Username']."' AND CourseID = '$courseid'");
				
				$grade = mysqli_fetch_assoc($getavggrade);
				echo '<tr><td>';
				echo $row ['fName'];
				echo '</td><td>';
				echo $row ['lName'];
				echo '</td><td>'.round($grade['avgGrade'],2).'%</td>';
				echo '<td style = "width: 20%;"><a href="submissions.php?username='.$row['Username'].'">View Submissions</a></td></tr>';
			}
		}
	}else{
		//STUDENT STUFF
		echo "<h2>Assignments</h2>";
		$getassignments = mysqli_query ( $db_conn, "SELECT * FROM `assignments` WHERE CourseID = $courseid ORDER BY AssignmentName ASC" );
		if (mysqli_num_rows ( $getassignments ) == 0) {
			echo "<p class = 'alert alert-danger'>There are no assignmets</p>";
		} 

		else {
			while ( $row = mysqli_fetch_array ( $getassignments ) ) {
				echo '<h4><a href="assignment.php?assign=' . $row ['AssignmentName'] . '&assignid=' . $row ['AssignmentID'] . '">' . $row ['AssignmentName'] . "</a></h4>";
			}
		}
		exit();
	}
		
		echo '</table>';
	} else {
			echo "<h1>Something went wrong</h1>";
			echo "<p>We are now redirecting you...</p>";
			echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
			exit ();
		}


?>
<?php
$mycourses = mysqli_query ( $db_conn, "SELECT * FROM `courses` WHERE CourseID = '".$_SESSION['courseid']."' ORDER BY Course" );
$row = mysqli_fetch_assoc( $mycourses );

$del_popover= '<p>
			<strong><em> Are you sure?</em></strong>
			</p>
			<form method="post" action="admin.php" name="delete-form" id="delete-form">
				<button type="submit" class="btn btn-success" name="course-delete" id="delete-btn" value = "'.$courseid.'">Yes</button>
	
			</form>';

	echo '<button style="float: right;" type="button" class="btn btn-danger btn-default btn-lg"
			data-toggle="popover" data-placement="left" data-trigger="focus" data-html="true" title=""
					data-content='."'$del_popover'".'>';
	echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				Delete</button>';
	echo '</h4>';
	
	$popover= '<p  style = "margin: 0;">
			<strong><em>Enter the new course name</em></strong>
			</p>
			<form method="post" action="course.php" name="delete-form" id="delete-form">
				<input type = "text" value = "'.$course.'" name = "course-rename" id="course-rename">
				<p style = "margin: 0;"><strong><em>Enrollement Key</em></strong></p>
				<input type = "text" value = "'. $row['EnrollKey'].'" name = "enroll-key" id="enroll-key">
			<button type="submit" class="btn btn-success" name="course-rename-btn" id="delete-btn" value = "'.$courseid.'">Submit</button>
	
			</form>';

	echo '<button style="float: right;" type="button" class="btn btn-warning btn-default btn-lg"
			data-toggle="popover" data-placement="left" data-trigger="click" data-html="true" title=""
					data-content='."'$popover'".'>';
	echo '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				Rename/Edit</button>';
	echo '</h4>';
	?>
<form method="post" action="addAssignment.php" name="addAssignment-form"
	id="addAssignment-form">
	<button name="addAssignment-btn"
		value="<?php echo $_SESSION ['courseid']; ?>" type="submit"
		class="btn btn-success btn-default btn-lg">
		<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Manage
		Assignments
	</button>
</form>


<script type="text/javascript">
$("[data-toggle=popover]").popover();
</script>