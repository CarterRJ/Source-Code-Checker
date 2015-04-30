<?php

set_include_path ( get_include_path () . PATH_SEPARATOR . 'phpseclib' );
$filename = basename($target_file);
$file_no_ext = substr($filename,0,strpos($filename, "."));
$directory = pathinfo($target_file, PATHINFO_DIRNAME);

function myhtmlentities($string){
	$string = htmlentities($string);
	$string = str_replace ( ' ', '&nbsp;', $string);
	$string = nl2br($string);
	return $string;
}

function removePrompt($errors, $eol){
	$len = strlen($eol);
	$errors = substr($errors,strpos($errors, $eol)+$len, strrpos($errors, $eol)-strpos($errors, $eol));
	return $errors;
}

function runTestCase($inputs, $outputs, $actual) {
	echo "<h2>Execution Results:</h2>";
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
		echo "<p>SUCCESS</p> ";
	}
	$grade = round($correct*100/$num_test,2);
	echo "<p><strong>$correct/$num_test</strong> - $grade%</p>";
	return $grade;
	
}

include ('Net/SSH2.php');
$ssh = new Net_SSH2 ( '127.0.0.1:2222' );

if (! $ssh->login ( 'vagrant', 'vagrant' )) {
	echo "<h2>The system is currently unavaible, contact the system administrator</h2>";
	exit ( 'Login Failed' );
}

echo "<div>";
$ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);
$ssh->setTimeout(10);
$ssh->write ( "cd /uploads/\n" );
$ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);
$ssh->write ( "gcc $filename\n" );
$errors = $ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);

//Vera++
$ssh->read ( '/.*@.*[$|#]/', NET_SSH2_READ_REGEX );
$ssh->write ( "dos2unix $filename\n" );
$ssh->read ( '/.*@.*[$|#]/', NET_SSH2_READ_REGEX );
$ssh->write ( "vera++ $filename\n" );
$vera = $ssh->read ( '/.*@.*[$|#]/', NET_SSH2_READ_REGEX );
$vera = str_replace("$filename:", "Line ", $vera);

include ("output.php");
if (isset ( $_SESSION ['testcaseid'] ) && (strlen($errors) == 0)) {
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
		mysqli_query ( $db_conn, "INSERT INTO `grades` (`Username`, `TestCaseID`, `Grade`, `Comments`) VALUES ('".$_SESSION ['Username']."', '".$_SESSION ['testcaseid']."', '$grade', '".nl2br(implode($actual,"\n")."\n".$vera)."')");
	}
	
}else{
	$ssh->write ( "rm $filename\n" );
	$ssh->read ( '/.*@.*[$|#]/', NET_SSH2_READ_REGEX );
}
$ssh->write ( "rm ./a.out\n" );
$ssh->read ( '/.*@.*[$|#]/', NET_SSH2_READ_REGEX );

?>