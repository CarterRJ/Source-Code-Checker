<?php
include ("config.php");
include 'css/css.php';
include 'js/js.php';

//var_dump($_FILES);
// Error Checking
echo "<h2> Feedback </h2>";
$source_too_long = false;
//L006 Source file should not be too long
//echo $target_file;
$lines = file ( $target_file );
$numLines = count ( $lines );
if ($numLines > MAX_NUM_LINES) {
	$source_too_long = true;
	//echo "<p>There are <strong>$numLines </strong>lines. The limit is <strong>" . MAX_NUM_LINES . "</strong></p>";
	$feedback[] =  "<p>There are <strong>$numLines </strong>lines. The limit is <strong>" . MAX_NUM_LINES . "</strong></p>";
}

// L006 Line should not be too long
$count = 0;
$longlines = null;
foreach ( $lines as $line ) {
	$count ++;
	if (strlen ( $line ) > MAX_LINE_LENGTH) {
		$longlines [] = $count;
		$feedback[] = "<p> Line: $count too long, <strong>max line length = " . MAX_LINE_LENGTH . " </strong></p>";
	}
}

// F002 File names should not be too long (F002 *PERSONAL VERSION)
if (strlen ( basename ( $target_file ) ) > MAX_FILENAME_LENGTH) {
	if (!$uploaded)$feedback[] =  "<p> File name <strong>" . $_FILES ["fileToUpload"] ["name"] . " </strong>too long <strong> max length = " . MAX_FILENAME_LENGTH . "</strong></p>";
}

// F001 Source files should not use solely the '\r' (CR) character FAILED BROKEN
$count = 0;
foreach ( $lines as $line ) {
	$count ++;
	if (strpos ( $line, chr ( 0x0D ) ) + 1 == strlen ( $line )) {
		$crlines [] = $count;
		//echo strpos ( $line, chr ( 0x0A ) ) + 1;
		//echo ", ";
		//echo strlen ( $line );
		echo "\n";
		$feedback[] =  "<p>Source files should not use the '\\r' (CR) character. <strong>Line: " . $count . "</strong></p>";
	}
}

// L002 Don't use tab characters
$count = 0;
foreach ( $lines as $line ) {
	$count ++;
	if (preg_match ( "/\t.*/", "$line" )) {
		$feedback[] =  "<p>Source files should not use tabs <strong>Line: " . $count . "</strong></p>";
		$tablines [] = $count;
	}
}

// L005 There should not be too many consecutive empty lines
$emptyLines = 0;
$discovered = false;
$count = 0;
foreach ( $lines as $line ) {
	$count ++;
	if (trim ( $line ) == "") {
		$emptyLines ++;
		
		if (($emptyLines > MAX_EMPTY_LINES) && ($discovered == false)) {
			$discovered = true;
			$feedback[] =  "<p>Too many consecutive empty lines. <strong>Line: $count </strong></p>";
		}
	} else {
		$emptyLines = 0;
		$discovered = false;
	}
}

// L003a Source files should not have a leading empty line
$count = 0;
if (count ( $lines ) > 0) {
	if (trim ( $lines [0] ) == "") {
		$feedback[] =  "<p>Source files should not have a leading empty line <strong>Line: $count</strong></p>";
	}
}

// OUTPUT

?>