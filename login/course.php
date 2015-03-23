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

if (! isset ( $_GET ['course'] ) && ! isset ( $_GET ['courseid'] )) {
	echo "<meta http-equiv='refresh' content='0;index.php' />";
}
$_SESSION ['course'] = $_GET ['course'];
$_SESSION ['courseid'] = $_GET ['courseid'];

var_dump ( $_SESSION );
$coursecheck = mysqli_query ( $db_conn, "SELECT * FROM `courses` WHERE CourseID = '" . $_SESSION ['courseid'] . "' AND Course = '" . $_SESSION ['course'] . "'" );
if (mysqli_num_rows ( $coursecheck ) > 0) {
	echo "<h1> " . $_SESSION ['course'] . " </h1>";
	$courseid = $_SESSION ['courseid'];
} else {
	// do something
	if (! mysqli_query ( $db_conn, $coursecheck )) {
		die ( 'Error: ' . mysqli_error ( $db_conn ) );
	}
}

?>
<?php
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
	
	$popover= '<p>
			<strong><em>Enter the new course name</em></strong>
			</p>
			<form method="post" action="admin.php" name="delete-form" id="delete-form">
				<input type = "text" name = "course-rename" id="course-rename">
				<button type="submit" class="btn btn-success" name="course-rename-btn" id="delete-btn" value = "'.$courseid.'">Submit</button>
	
			</form>';

	echo '<button style="float: right;" type="button" class="btn btn-warning btn-default btn-lg"
			data-toggle="popover" data-placement="left" data-trigger="click" data-html="true" title=""
					data-content='."'$popover'".'>';
	echo '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				Rename</button>';
	echo '</h4>';
	?>
<form method="post" action="addAssignment.php" name="addAssignment-form"
			id="addAssignment-form">
			<button name="addAssignment-btn"
				value="<?php echo $_SESSION ['courseid']; ?>" type="submit"
				class="btn btn-success btn-default btn-lg">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				Add Assignment
			</button>
		</form>
		

		<script type="text/javascript">
$("[data-toggle=popover]").popover();
</script>