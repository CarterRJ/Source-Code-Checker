<?php
include "db-info.php";
if (empty ( $_SESSION ) || !isset($_SESSION) || !isset($_GET['testcaseid'])){

	echo "<h1>You don't have access the this area</h1>";
	echo "<p>We are now redirecting you...</p>";
	echo "<meta http-equiv='refresh' content='2;index.php' />"; // Meta refresh
	exit ();
}

//Create query
if (isset ( $_GET ['username'] ) && $_SESSION ['Admin'] == 1) {
	$qry = "SELECT * FROM `files` WHERE Username='" . $_GET ['username'] . "' AND TestCaseID='" . $_GET ['testcaseid'] . "'";
} else {
	$qry = "SELECT * FROM `files` WHERE Username='" . $_SESSION ['Username'] . "' AND TestCaseID='" . $_GET ['testcaseid'] . "'";
}
$getfile=mysqli_query($db_conn, $qry);

//Check whether the query was successful or not
if(mysqli_num_rows($getfile)==1) {
	$row = mysqli_fetch_assoc($getfile);
	$file = "../".$row['Directory']."/".$row['Filename'];
	if( file_exists( $file ))
    {
    	readfile( $file );
    	header('Content-Description: File Transfer');
    	header('Content-Type: text/plain');
    	//header('Content-Disposition: attachment; filename= "'.$row['RealFilename'].'"'); //Download or display in browser
    	header('Content-Transfer-Encoding: binary');
    	header('Connection: Keep-Alive');
    	header('Expires: 0');
    	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    	header('Pragma: public');
    	header('Content-Length: ' . filesize($file));
    	
     exit;
    }
  }else{
die( "ERROR: File does not exist or you don't have permissions to download it." );
}
?>