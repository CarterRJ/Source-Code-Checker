<?php
/*
echo "SESSION";
var_dump($_SESSION);
*/
set_include_path ( get_include_path () . PATH_SEPARATOR . 'phpseclib' );
$filename = basename($target_file);
$file_no_ext = substr($filename,0,strpos($filename, "."));
$output;
$return_var;
/*echo "<p>$filename</p>";
echo "<p>$target_file</p>";
echo "<p>$file_no_ext</p>";*/

function runTestCase($inputs, $outputs, $actual) {
	$num_test = count ( $inputs );
	$correct = 0;
	for($i = 0; $i < $num_test; $i ++) {
		if ($actual [$i] == $outputs [$i]) {
			$correct ++;
		} else {
			echo htmlentities ( "<p>FAIL! Input: $input[$i]>, Expected Output: <$output[$i]>, Actual: <$actual[$i]></p>" );
		}
	}
	if ($correct == $num_test) {
		echo "<p>SUCCESS ";
	}
	echo "<strong>$correct/$num_test</strong></p>";
	echo "";
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
	$errors = str_replace($filename, $_FILES['fileToUpload']['name'], $errors);
}else{
	//echo '<p>NOT A FILE UPLOAD</p>';
	$errors = str_replace($filename, "userfile.c", $errors);
}
$errors = substr($errors,strpos($errors, "<br />")+6, strrpos($errors, "<br />")-strpos($errors, "<br />"));
if (strlen($errors) > 0){
	echo '<h2>Compilation Errors</h2>';
	echo $errors;
}else{
	echo '<p>No compilation errors</p>';
}

$ssh->write ( "./a.out\n" );
$ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);


$gettests = mysqli_query($db_conn, "SELECT * FROM `tests` WHERE TestCaseID =".$_SESSION['testcaseid']);
while ($row = mysqli_fetch_array($gettests, MYSQL_ASSOC)){
	$inputs[]= $row['Input']; $outputs[]= $row['Output'];
	$ssh->write ( "./a.out ".$row['Input'].">>$file_no_ext\n" );
	$ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);
	$ssh->write ( "echo >>$file_no_ext\n" );
	$ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);
}
$ssh->write ( "rm ./a.out\n" );
echo '<br />';
$ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);
if (file_exists ( $target_dir.$file_no_ext )) {
	$actual = file ( $target_dir.$file_no_ext, FILE_IGNORE_NEW_LINES );
	var_dump ( $actual );
	var_dump ( $inputs );
	var_dump ( $outputs );
	runTestCase ( $inputs, $outputs, $actual );
}

?>