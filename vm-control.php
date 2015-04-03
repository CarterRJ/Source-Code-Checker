<?php

echo "SESSION";
var_dump($_SESSION);

echo "POST";
var_dump($_POST);

set_include_path ( get_include_path () . PATH_SEPARATOR . 'phpseclib' );
$filename = basename($target_file);
$file_no_ext = substr($filename,0,strpos($filename, "."));
$directory = pathinfo($target_file, PATHINFO_DIRNAME);

$output;
$return_var;
echo"filename";
echo "<p>$filename</p>";
echo"tagret_file";
echo "<p>$target_file</p>";
echo "no ext";
echo "<p>$file_no_ext</p>";
echo "path";
echo "<p>".pathinfo($target_file, PATHINFO_DIRNAME)."</p>";

function runTestCase($inputs, $outputs, $actual) {
	echo "<h3>Execution Results:</h3>";
	$num_test = count ( $inputs );
	$correct = 0;
	for($i = 0; $i < $num_test; $i ++) {
		if ($actual [$i] == $outputs [$i]) {
			$correct ++;
		} else {
			echo "<p>";
			echo htmlentities ( "FAIL - Input: <$inputs[$i]>, Expected Output: <$outputs[$i]>, Actual: <$actual[$i]>" );
			echo "</p>";
		}
	}
	if ($correct == $num_test) {
		echo "<p>SUCCESS ";
	}
	$grade = round($correct*100/$num_test,2);
	echo "<p><strong>$correct/$num_test</strong> - $grade%</p>";
	return $grade;
	
}

include ('Net\SSH2.php');
$ssh = new Net_SSH2 ( '127.0.0.1:2222' );
//WATCHOUT LITTERALS HERE wwwroot
if (! $ssh->login ( 'vagrant', 'vagrant' )) {
	exit ( 'Login Failed' );
}
echo "<div>";
$ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);
$ssh->setTimeout(10);
$ssh->write ( "cd /uploads/\n" );
$ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);
$ssh->write ( "gcc $filename\n" );
$errors = nl2br(htmlentities($ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX)));

if (!empty($_FILES)){
	/*echo "<p>FILE UPLOAD</p>";
	echo "FILES";
	var_dump($_FILES);*/
	$real_filename = $_FILES['fileToUpload']['name'];
	$errors = str_replace($filename, $real_filename, $errors);
}else{
	//echo '<p>NOT A FILE UPLOAD</p>';
	$real_filename = "userfile.c";
	$errors = str_replace($filename, $real_filename, $errors);
}
$errors = substr($errors,strpos($errors, "<br />")+6, strrpos($errors, "<br />")-strpos($errors, "<br />"));
if (strlen($errors) > 0){
	echo '<h2>Compilation Errors</h2>';
	echo $errors;
}else{
	echo '<h4>No compilation errors.</h4>';
}
//$complines;
preg_match_all('/:(\d+):/', $errors, $complines);
$ssh->write ( "./a.out\n" );
$ssh->read ( '/.*@.*[$|#]/', NET_SSH2_READ_REGEX );

include ("output.php");
if (! empty ( $_SESSION ) && (strlen($errors) == 0)) {
	$gettests = mysqli_query ( $db_conn, "SELECT * FROM `tests` WHERE TestCaseID =" . $_SESSION ['testcaseid'] );
	while ( $row = mysqli_fetch_array ( $gettests, MYSQL_ASSOC ) ) {
		$inputs [] = $row ['Input'];
		$outputs [] = $row ['Output'];
		$ssh->write ( "./a.out " . $row ['Input'] . ">>$file_no_ext\n" );
		$ssh->read ( '/.*@.*[$|#]/', NET_SSH2_READ_REGEX );
		$ssh->write ( "echo >>$file_no_ext\n" );
		$ssh->read ( '/.*@.*[$|#]/', NET_SSH2_READ_REGEX );
		mysqli_query ( $db_conn, "INSERT INTO `files` (`Username`, `Filename`, `RealFilename`, `Directory`, `TestCaseID`) VALUES ('".$_SESSION ['Username']."', '$filename', '$real_filename', '$directory', '".$_SESSION['testcaseid']."')");
	}
	if (file_exists ( $target_dir . $file_no_ext )) {
		$actual = file ( $target_dir . $file_no_ext, FILE_IGNORE_NEW_LINES );
		$grade = runTestCase ( $inputs, $outputs, $actual );
		mysqli_query ( $db_conn, "INSERT INTO `grades` (`Username`, `TestCaseID`, `Grade`) VALUES ('".$_SESSION ['Username']."', '".$_SESSION ['testcaseid']."', '$grade')");
	}
	
}
$ssh->write ( "rm ./a.out\n" );
$ssh->read ( '/.*@.*[$|#]/', NET_SSH2_READ_REGEX );

?>