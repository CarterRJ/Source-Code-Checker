<?php

include "db-info.php";
if (empty ( $_SESSION ) || !isset($_SESSION) || !isset($_GET['testcaseid'])){

	echo "<h1>You don't have access the this area</h1>";
	echo "<p>We are now redirecting you...</p>";
	//echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
}

//Create query
if (isset ( $_GET ['username'] ) && $_SESSION ['Admin'] == 1) {
	$qry = "SELECT Comments FROM `grades` WHERE Username='" . $_GET ['username'] . "' AND TestCaseID='" . $_GET ['testcaseid'] . "'";
} else {
	$qry = "SELECT Comments FROM `grades` WHERE Username='" . $_SESSION ['Username'] . "' AND TestCaseID='" . $_GET ['testcaseid'] . "'";
}
$getcomments=mysqli_query($db_conn, $qry);

//Check whether the query was successful or not
if(mysqli_num_rows($getcomments)==1) {
	$row = mysqli_fetch_assoc ( $getcomments );
	echo "<h1>Comments</h1>";
	if ($row ['Comments'] == 0) {
		echo '<p>None<p>';
	} else {
		echo $row ['Comments'];
	}

  }else{
die( "ERROR: Comment does not exist or you don't have permissions to view it." );
}
