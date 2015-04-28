<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Assignment | Source Code Checker</title>
</head>
<body>

<?php
include "db-info.php";
include_once '../css/css.php';
include_once '../js/js.php';
include_once '../header.php';

if (empty ( $_SESSION ) || !isset($_SESSION)){

	echo "<h1>You don't have access the this area</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
}

if (! isset ( $_GET ['assign'] ) && ! isset ( $_GET ['assignid'] ) && empty($_POST)) {

}elseif (isset ( $_GET ['assign'] ) && isset( $_GET ['assignid'] )){
$_SESSION ['assign'] = $_GET ['assign'];
$_SESSION ['assignid'] = $_GET ['assignid'];
}

if(isset($_POST['testcase-name']) && (!empty($_POST['testcase-name']))){
	$addtestcase = $db_conn->prepare ("INSERT INTO `testcases` (`TestCaseID`, `AssignmentID`, `TestCaseName`, `Description`) VALUES (NULL, ?,?,?)");
	$addtestcase->bind_param ("sss", $_SESSION ['assignid'], $_POST['testcase-name'], $_POST['testcase-description']);
	$addtestcase->execute();
}

if(isset($_POST['testcase-rename']) && (!empty($_POST['testcase-rename']))){
	$updatetestcase = $db_conn->prepare ("UPDATE `testcases` SET `TestCaseName` = ?, `Description` = ? WHERE `AssignmentID` = ? AND `TestCaseID` = ?;");
	$updatetestcase->bind_param ("ssss", $_POST['testcase-rename'], $_POST['testcase-description'], $_SESSION ['assignid'], $_POST['testcase-rename-btn']);
	$updatetestcase->execute();
}

if(isset($_POST['testcase-delete'])){
	$addtest = $db_conn->prepare ("DELETE FROM `testcases` WHERE `testcases`.`TestCaseID` = ? AND `AssignmentID` = ?");
	$addtest->bind_param ("ss",$_POST['testcase-delete'], $_SESSION ['assignid']);
	$addtest->execute();
}
//var_dump($_SESSION);
$assignmentcheck = mysqli_query ( $db_conn, "SELECT * FROM `assignments` WHERE AssignmentID = '" . $_SESSION ['assignid'] . "' AND AssignmentName = '" . $_SESSION ['assign'] . "'" );
if (mysqli_num_rows ( $assignmentcheck ) > 0) {
	$courseid = $_SESSION ['courseid'];
	$course = $_SESSION ['course'];
	$assignid = $_SESSION ['assignid'];
	$assign = $_SESSION ['assign'];
	
echo '<ol class="breadcrumb">';
	if ($_SESSION ['Admin'] == 0) {
		echo '<li><a href="members.php">Home</a></li>
		<li><a href="course.php">' . $course . '</a></li>
		<li class="active">' . $assign . '</a></li>';
	} else {
		echo '<li><a href="admin.php">Home</a></li>
		<li><a href="addAssignment.php">' . $course . '</a></li>
		<li class="active">' . $assign . '</a></li>';
	}
	echo '</ol>';
	
	echo "<h1> $assign </h1>";
	
} else {
	echo "<h1>Something went wrong</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
	die ( 'Error: ' . mysqli_error ( $db_conn ) );
}

?>

<?php
$gettestcases = mysqli_query ( $db_conn, "SELECT * FROM `testcases` WHERE AssignmentID = $assignid ORDER BY TestCaseName ASC" );

echo "<h3 style = 'text-decoration: underline;'>Test Cases</h3>";

if ($_SESSION['Admin'] == 1){
while ( $row = mysqli_fetch_array ( $gettestcases ) ) {
	echo '<h4><a href="testcase.php?testcaseid='.$row ['TestCaseID'].'">'.$row ['TestCaseName'].'</a>';

$del_popover= '<p>
			<strong><em> Are you sure?</em></strong>
			</p>
			<form method="post" action="assignment.php" name="delete-form" id="delete-form">
				<button type="submit" class="btn btn-success" name="testcase-delete" id="delete-btn" value = "'.$row['TestCaseID'].'">Yes</button>
	
			</form>';

	echo '<button style="float: right;" type="button" class="btn btn-danger btn-default btn-sm"
			data-toggle="popover" data-placement="left" data-trigger="focus" data-html="true" title=""
					data-content='."'$del_popover'".'>';
	echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				Delete</button>';
	
	$popover= '<p>
			<strong><em>Name</em></strong>
			</p>
			<form method="post" action="assignment.php" name="delete-form" id="delete-form">
			<fieldset>
				<input class="form-control" type = "text" value = "'.$row['TestCaseName'].'"name = "testcase-rename" id="testcase-rename">
			<label for="testcase-description">Description:</label>
		<textarea class="form-control" "rows="6" cols="12" placeholder = "Description" name="testcase-description" id="testcase-description">'.$row['Description'].'</textarea>
			
			<br /><button type="submit" class="btn btn-success" name="testcase-rename-btn" id="delete-btn" value = "'.$row['TestCaseID'].'">Submit</button>
	</fieldset>
			</form>';

	echo '<button style="float: right;" type="button" class="btn btn-warning btn-default btn-sm"
			data-toggle="popover" data-placement="left" data-trigger="click" data-html="true" title=""
					data-content='."'$popover'".'>';
	echo '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				Edit</button>';
	
	echo "<p><small>".$row['Description']."&nbsp</small></h4>";

}


?><?php
echo '<form class="form-horizontal" method="post" action="assignment.php" name="testcase-form" id="testcase-form">
	<fieldset>
		<label for="testcase-name">Name:</label> <input class="form-control"
			type="text" name="testcase-name" id="testcase-name" />

		<label for="testcase-description">Description:</label>
		<textarea rows="4" cols="50" placeholder="Description"
			name="testcase-description" id="testcase-description"></textarea>

		<button name="addTestCase-btn" type="submit"
			class="btn btn-success btn-default btn-default">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
			Test Case
		</button>
	</fieldset>
</form>';
} else {
	echo "<table class = 'table table-border'><thead><tr><th>Exercise</th><th>Grade</th><th></th</tr></thead><tbody>";
	while ( $row = mysqli_fetch_array ( $gettestcases, MYSQL_ASSOC ) ) {
		$description_html= "<p><small>" . $row ['Description'] . "</small></p></td>";
		
		$getgrades = mysqli_query ( $db_conn, "SELECT * FROM `grades` WHERE Username = '" . $_SESSION ['Username'] . "' AND TestCaseID = '" . $row ['TestCaseID'] . "'" );
		$grade = mysqli_fetch_array ( $getgrades, MYSQL_ASSOC )['Grade'];
		if ($grade != "") {
			echo '<tr><td><h4>'. $row ['TestCaseName'];
			echo $description_html;
			echo "<td>$grade</td>";
			echo '<td><form method="get" action="download.php" name="download-form" id="download-form">
		<button style="float: right;" name = "testcaseid" type="submit" class="btn btn-success" value = "' . $row ['TestCaseID'] . '">';
			echo '<span class="glyphicon glyphicon glyphicon glyphicon glyphicon-download-alt" aria-hidden="true"></span>
				Download Solution</button></form></h4>';
		} else {
			echo '<tr><td><h4 style="margin-top:0px;"><a href="submit.php?testcaseid=' . $row ['TestCaseID'] . '">' . $row ['TestCaseName'] . '</a>';
			echo $description_html;
			echo "<td>*no grade*</td>";
		
		echo '<td><form method="get" action="submit.php" name="submit-form" id="submit-form">
		<button style="float: right;" name = "testcaseid" type="submit" class="btn" value = "' . $row ['TestCaseID'] . '">';
		echo '<span class="glyphicon glyphicon glyphicon glyphicon-cloud-upload" aria-hidden="true"></span>
				Submit Solution</button></form></td></tr></h4>';
		}
	}
	echo "</tbody></table>";
}
?>

<script type="text/javascript">
$("[data-toggle=popover]").popover();
</script>
</body>
</html>
