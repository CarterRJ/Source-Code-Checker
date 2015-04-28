<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Area | Source Code Checker</title>
</head>
<?php
include "db-info.php";
include_once '../css/css.php';
include_once '../js/js.php';
include '../header.php';


if (empty ( $_SESSION ))
	$_SESSION ['Admin'] = 0;
if ($_SESSION ['Admin'] == 0) {
	
	echo "<h1>You don't have access the this area</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
}

if (! isset ( $_GET ['testcaseid'] ) && empty ( $_POST )) {
	if (! isset ( $_SESSION [testcaseid] )) {
		echo "<meta http-equiv='refresh' content='0;index.php' />";
		exit ();
	}
} elseif (isset ( $_GET ['testcaseid'] )) {
	
	$_SESSION ['testcaseid'] = $_GET ['testcaseid'];
}



if (isset ( $_POST ['addTest-btn'] )) {
	$addtest = $db_conn->prepare ( "INSERT INTO `tests` (`TestID`, `TestCaseID`, `Input`, `Output`) VALUES (NULL,?,?,?)" );
	$addtest->bind_param ( "sss", $_SESSION ['testcaseid'], $_POST ['test-input'], $_POST ['test-output'] );
	$addtest->execute ();
}

if (isset ( $_POST ['test-edit-btn'] )){
	$updatetestcase = $db_conn->prepare ( "UPDATE `tests` SET `Input` = ?, `Output` = ? WHERE `TestID` = ?" );
	$updatetestcase->bind_param ( "sss", $_POST ['test-input'], $_POST ['test-output'], $_POST ['test-edit-btn'] );
	$updatetestcase->execute ();
}

if (isset ( $_POST ['test-delete'] )) {
	$addtest = $db_conn->prepare ( "DELETE FROM `tests` WHERE `TestID` = ?" );
	$addtest->bind_param ( "s", $_POST ['test-delete']);
	$addtest->execute ();
}

$testcaseid = $_SESSION ['testcaseid']; 

$testcasecheck = mysqli_query ( $db_conn, "SELECT * FROM `testcases` WHERE TestCaseID = $testcaseid" );
$gettests = mysqli_query ( $db_conn, "SELECT * FROM `tests` WHERE TestCaseID = $testcaseid" );

if (mysqli_num_rows ( $testcasecheck ) > 0) {
	$testcase = mysqli_fetch_array ( $testcasecheck )['TestCaseName'];
	echo '<ol class="breadcrumb">
			<li><a href="admin.php">Home</a></li>
			<li><a href="addAssignment.php">'. $_SESSION ['course'].'</a></li>
			<li><a href="assignment.php">'. $_SESSION ['assign'].'</a></li>
			<li class="active">'.$testcase.'</a></li>
		</ol>';
	echo '<h1><a href="assignment.php">' . $_SESSION ['assign'] . "</a></h1>";
	echo "<h2>$testcase</h2>";
} else {
	
	echo "<h1>Something went wrong</h1>";
	echo "<p>We are now redirecting you...</p>";
	//echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
	die ( 'Error: ' . mysqli_error ( $db_conn ) );
}

echo '<table class = "table-bordered table table-striped ">';
echo ' <thead>
			<tr>
				<th>Input</th>
				<th>Output</th>
			<tr>
		</thead>
		<tbody>';
if (mysqli_num_rows ( $gettests ) == 0) {
echo '<tr><td>*none*</td><td>*none*</td><tr>';
}
while ( $row = mysqli_fetch_array ( $gettests ) ) {

	echo '<tr><td>' . $row ['Input'] . '</td><td>' . $row ['Output'];
	$del_popover = '<p>
			<strong><em> Are you sure?</em></strong>
			</p>
			<form method="post" action="testcase.php" name="delete-form" id="delete-form">
				<button type="submit" class="btn btn-success" name="test-delete" id="delete-btn" value = "' . $row ['TestID'] . '">Yes</button>
	
			</form>';
	
	echo '<button style="float: right;" type="button" class="btn btn-danger btn-default btn-sm"
			data-toggle="popover" data-placement="left" data-trigger="focus" data-html="true" title=""
					data-content=' . "'$del_popover'" . '>';
	echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				Delete</button>';
	
	$popover = '
			<form method="post" action="testcase.php" name="delete-form" id="delete-form">

			<label for="test-input">Input:</label>
			<input value = "' . $row ['Input'] . '" class="form-control" type="text" name="test-input" id="test-input" />
			
			<label for="test-output">Expected Output:</label>
			<input value = "' . $row ['Output'] . '" class="form-control" type="text" name="test-output" id="test-output" />
			<br /><button type="submit" class="btn btn-success" name="test-edit-btn" id="test-edit-btn" value = "' . $row ['TestID'] . '">Submit</button>
	
			</form>';
	
	echo '<button style="float: right;" type="button" class="btn btn-warning btn-default btn-sm"
			data-toggle="popover" data-placement="left" data-trigger="click" data-html="true" title=""
					data-content=' . "'$popover'" . '>';
	echo '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				Edit</button>';
	
	echo "</td></tr>";
}
echo '</tbody></table>';
?>

	<form method="post" action="testcase.php"
	name="testcase-form" id="testcase-form">
	<fieldset>
		<label for="test-input">Input:</label>
		<input class="form-control"	type="text" name="test-input" id="test-input" />
		
		<label style="width: inherit;" for="test-output">Expected Output:</label>
		<input class="form-control" type="text" name="test-output" id="test-output" />
		
		<button name="addTest-btn" type="submit" class="btn btn-success btn-default btn-default">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
			Test Case
		</button>
	</fieldset>
</form>


<script type="text/javascript">
	$("[data-toggle=popover]").popover();
	</script>