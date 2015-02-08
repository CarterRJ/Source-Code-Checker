<?php
// http://www.w3schools.com/php/php_file_upload.asp //They don't want you to copy
include_once 'html.php';
$target_dir = "uploads/";
$uploadOk = 1;
//var_dump ( $_FILES );
//var_dump ( $_POST );
if (isset ( $_POST ["code"] )) {
	$text = $_POST ["code"];
	file_put_contents ( $target_dir . "somethingreallylonglol.c", $text );
	$target_file = $target_dir . "somethingreallylonglol.c";
	
	// Check file size
	var_dump ( $_FILES );
	if (filesize($target_file) > 5000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
} 

// Check if image file is a actual image or fake image
else if (isset ( $_POST ["submit"] )) {
	$target_file = $target_dir . basename ( $_FILES ["fileToUpload"] ["name"] );
	$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if file already exists
	if (file_exists ( $target_file )) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	if ($FileType != "c" && $FileType != "bak") {
		echo "Sorry, only .c and .bak files are allowed.\n";
		$uploadOk = 0;
	}
	
	// Check file size
	if ($_FILES ["fileToUpload"] ["size"] > 5000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats***TODO
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "<p>Sorry, your file was not uploaded.</p>";
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file ( $_FILES ["fileToUpload"] ["tmp_name"], $target_file )) {
			echo "The file " . basename ( $_FILES ["fileToUpload"] ["name"] ) . " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
}

// exec("gcc uploads/simple.c");
// exec("a.exe");

echo "<h2> Did it work? </h2>";
echo exec ( "whoami" );
include_once ("rules.php");
include_once ("vm-control.php");

?>