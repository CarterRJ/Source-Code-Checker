<?php
include "db-info.php";
include '../css/css.php';
include '../js/js.php';
include_once '../header.php';

if (empty ( $_SESSION ))
	$_SESSION ['Admin'] = 0;
if ($_SESSION ['Admin'] == 0) {

	echo "<h1>You don't have access the this area</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
}

if(isset($_POST['addAssignment-id'])){
	$_SESSION ['courseid'] = $_POST['addAssignment-id'];
	$_SESSION ['course'] = $_POST['addAssignment-course'];
}

$coursecheck = mysqli_query ( $db_conn, "SELECT * FROM `courses` WHERE CourseID = '" . $_SESSION ['courseid'] . "' AND Course = '" . $_SESSION ['course'] . "'" );
if (mysqli_num_rows ( $coursecheck ) > 0) {
	$courseid = $_SESSION ['courseid'];
	$course = $_SESSION ['course'];
	echo '<ol class="breadcrumb">
			<li><a href="admin.php">Home</a></li>
			<li class="active">'.$course.'</a></li>
		</ol>';
	echo "<h1> " . $_SESSION ['course'] . " </h1>";
} else {
	echo "<h1>Something went wrong</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
	die ( 'Error: ' . mysqli_error ( $db_conn ) );
}

if(isset($_POST['assignment-name']) && (!empty($_POST['assignment-name']))){
	$addassignment = $db_conn->prepare ("INSERT INTO `assignments` (`AssignmentID`, `CourseID`, `AssignmentName`, `Description`) VALUES (NULL, ?,?,?)");
	$addassignment->bind_param ("sss", $courseid, $_POST['assignment-name'], $_POST['assignment-description']);
	$addassignment->execute();
}

if(isset($_POST['assign-rename']) && (isset($_POST['assign-rename-btn']))){
	$renameassign = $db_conn->prepare ( 'UPDATE `assignments` SET `AssignmentName` = ? WHERE `AssignmentID` = ?' );
	$renameassign->bind_param ( "ss", $_POST['assign-rename'],$_POST['assign-rename-btn']);
	$renameassign->execute ();
	$renameassign->close ();
}

if(isset($_POST['assign-delete'])){
	$deleteassignment = $db_conn->prepare ( 'DELETE FROM `assignments` WHERE `AssignmentID` = ?' );
		$deleteassignment->bind_param ( 's', $_POST ['assign-delete'] );
		$deleteassignment->execute ();
		$deleteassignment->close();
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
	////var_d_dump($row);
	echo '<h4><a href="assignment.php?assign='.$row ['AssignmentName'].'&assignid='.$row ['AssignmentID'].'">' . $row ['AssignmentName']."</a>";
		
	echo '<button style="float: right;" type="button" class="btn btn-danger btn-default btn-sm"
			data-toggle="popover" data-placement="left" data-trigger="focus" data-html="true" title=""
					data-content='."'$popover'".'>';
	echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				Delete</button>';
	
	$ren_popover= '<p>
			<strong><em>Enter the new assignment name</em></strong>
			</p>
			<form method="post" action="addAssignment.php" name="rename-form" id="rename-form">
				<input type = "text" name = "assign-rename" id="assign-rename">
				<button type="submit" class="btn btn-success" name="assign-rename-btn" id="assign-btn" value = "'.$row ["AssignmentID"].'">Submit</button>
	
			</form>';
	
	echo '<button style="float: right;" type="button" class="btn btn-warning btn-default btn-sm"
			data-toggle="popover" data-placement="left" data-trigger="click" data-html="true" title=""
					data-content='."'$ren_popover'".'>';
	echo '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				Rename</button>';
	
	
	echo '<p><small>'.$row["Description"].'</small></p>';	
	echo '</h4>';
}
?>

<form class="form-inline" method="post" action="addAssignment.php"
	name="addAssignment-form" id="addAssignment-form">
	<fieldset>
		<label for="assignment-name">Name:</label> <input class="form-control"
			type="text" name="assignment-name" id="assignment-name" /> <label
			for="assignment-description">Description:</label>
		<textarea rows="4" cols="50" placeholder="Description"
			name="assignment-description" id="assignment-description"></textarea>


		<button name="addAssignment-btn" type="submit"
			class="btn btn-success btn-default btn-default">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
			Assignment
		</button>
	</fieldset>
</form>
<script type="text/javascript">
$("[data-toggle=popover]").popover();
</script>
<?php
//var_dump ( $_GET );
//var_dump ( $_SESSION );
//var_dump ( $_POST );
?>