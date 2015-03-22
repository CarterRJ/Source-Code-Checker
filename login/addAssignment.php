<?php
include "db-info.php";
include '../css/css.php';
include '../js/js.php';
include 'logout-header.php';

$coursecheck = mysqli_query ( $db_conn, "SELECT * FROM `courses` WHERE CourseID = '" . $_SESSION ['courseid'] . "' AND Course = '" . $_SESSION ['course'] . "'" );
if (mysqli_num_rows ( $coursecheck ) > 0) {
	
	echo "<h1> " . $_SESSION ['course'] . " </h1>";
	$courseid = $_SESSION ['courseid'];
} else {
	echo "FATAL ERROR";
	if (! mysqli_query ( $db_conn, $coursecheck )) {
		die ( 'Error: ' . mysqli_error ( $db_conn ) );
	}
}
if(isset($_POST['assignment-name'])){
	$addassignment = mysqli_query ( $db_conn, "INSERT INTO `assignments` (`AssignmentID`, `CourseID`, `AssignmentName`) VALUES (NULL, '$courseid', '" . $_POST ['assignment-name'] . "')" );
}

if(isset($_POST['assign-delete'])){
	$deleteassignment = $db_conn->prepare ( 'DELETE FROM `assignments` WHERE `AssignmentID` = ?' );
		$deleteassignment->bind_param ( 's', $_POST ['assign-delete'] );
		$deleteassignment->execute ();
}

?>

<?php
$getassignments = mysqli_query ( $db_conn, "SELECT * FROM `assignments` WHERE CourseID = $courseid ORDER BY AssignmentName ASC" );
while ( $row = mysqli_fetch_array ( $getassignments ) ) {
	$popover= '<p>
			<strong><em> Are you sure?</em></strong>
			</p>
			<form method="post" action="addAssignment.php" name="delete-form" id="delete-form">
				<button type="submit" class="btn btn-success" name="assign-delete" id="delete-btn" value = "'.$row["AssignmentID"].'">Yes</button>
	
			</form>';
	//var_dump($row);
	echo '<h4>' . $row ['AssignmentName'];
	echo '<button style="float: right;" type="button" class="btn btn-danger btn-default btn-sm"
			data-toggle="popover" data-trigger="focus" data-html="true" title=""
					data-content='."'$popover'".'>';
	echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				Delete</button>';
	echo '</h4>';
}
?>

<form method="post" action="addAssignment.php" name="addAssignment-form"
	id="addAssignment-form">
	<fieldset>
		<label for="assignment-name">Name:</label>
		<input type="text" name="assignment-name" id="assignment-name" />
		<button name="addAssignment-btn" type="submit" class="btn btn-success btn-default btn-default">
		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Assignment
	</button>
	</fieldset>
</form>
<script type="text/javascript">
$("[data-toggle=popover]").popover();
</script>
<?php
var_dump ( $_GET );
var_dump ( $_SESSION );
var_dump ( $_POST );
?>