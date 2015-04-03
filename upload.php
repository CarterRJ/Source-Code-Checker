<?php
// http://www.w3schools.com/php/php_file_upload.asp //They don't want you to copy
include_once 'html.php';
include_once 'login/db-info.php';

if (isset($_SESSION['Admin'])){
	include 'login/logout-header.php';
}else{
		include 'login-header.php';
}

//var_dump($_SESSION);

if (!empty ( $_SESSION )) {
echo '<ol class="breadcrumb">';
	if ($_SESSION ['Admin'] == 0) {
		echo '<li><a href="login/members.php">Home</a></li>';
		//<li><a href="course.php">' . $course . '</a></li>
		//<li class="active">' . $assign . '</a></li>';
	} else {
		echo '<li><a href="admin.php">Home</a></li>';
		//<li><a href="addAssignment.php">' . $course . '</a></li>
		//<li class="active">' . $assign . '</a></li>';
	}
	echo '</ol>';
}

function gen_random_code($length) {
	$characters = "abcdefghijklmnopqrstuvwxyzABCDERFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$randomString = "";
	for($i = 0; $i < $length; $i ++) {
		$randomString .= $characters [mt_rand ( 0, strlen ( $characters ) - 1 )];
	}
	return $randomString;
}

$len_rand_fname = 20;
$target_dir = "uploads/";
$max_file_size = 96000;
$uploadOk = 1;
$uploaded = 1; // Uploaded or Copy and Paste
 // var_dump ( $_FILES );
 // var_dump ( $_POST );
if (isset ( $_POST ["code"] )) {
	$text = $_POST ["code"];
	do {
		$rand_fname = gen_random_code ( $len_rand_fname );
		$target_file = $target_dir . $rand_fname . ".c";
		//echo $uploadOk;
	} while ( file_exists ( $target_file ) );
	file_put_contents ( $target_file, $text );
	// Check file size
	if (filesize ( $target_file ) > $max_file_size) {
		echo "Sorry, your file is too large.";
		unlink ( $target_file );
		$uploadOk = 0;
	}
} 

// Check if image file is a actual image or fake image
else if (isset ( $_POST ["submit"] )) {
	$target_file = $target_dir . basename ( $_FILES ["fileToUpload"] ["name"] );
	$FileType = pathinfo ( $target_file, PATHINFO_EXTENSION );
	
	if ($FileType != "c") {
		echo "Sorry, only .c files are allowed.\n";
		$uploadOk = 0;
	}
	
	// Check file size
	if ($_FILES ["fileToUpload"] ["size"] > $max_file_size) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Give random filename
	do {
		$rand_fname = gen_random_code ( $len_rand_fname );
		$target_file = $target_dir . $rand_fname . ".c";
	} while ( file_exists ( $target_file ) );
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 1) {
		if (move_uploaded_file ( $_FILES ["fileToUpload"] ["tmp_name"], $target_file )) {
			echo "The file " . basename ( $_FILES ["fileToUpload"] ["name"] ) . " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
}

if ($uploadOk && ! empty ( $_POST )) {
	include_once ("rules.php");
	include_once ("vm-control.php");
	//var_dump($_FILES); var_dump($_POST);
} else {
	include 'css/css.php';
	include 'js/js.php';
	echo "<meta http-equiv='refresh' content='4;index.html' />"; // Meta refresh
	echo "<div>";
	if (empty($_FILES)&&empty($_POST)){
		echo "<h1>Your file is too large</h1>";
	}
	echo "<p>Your file has not been uploaded.</p>";
	echo "<p>We are now redirecting you</p>";
	echo '<a href = "index.html">back</a>';
	echo "</div>";
}

?>
