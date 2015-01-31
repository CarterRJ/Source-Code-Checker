<?php
include ("config.php");
// Error Checking
echo "<h2> Errors </h2>";

// L006 Source file should not be too long
$lines = file ( $target_file );
$numLines = count ( $lines );
if ($numLines > MAX_NUM_LINES) {
	echo "<p>There are <strong>$numLines </strong>lines. The limit is <strong>" . MAX_NUM_LINES . "</strong></p>";
}

// L006 Line should not be too long
foreach ( $lines as $line ) {
	if (strlen ( $line ) > MAX_LINE_LENGTH) {
		echo "<p>" . $line . " <strong>line too long max line length = " . MAX_LINE_LENGTH . " </strong></p>";
	}
}

// F002 File names should not be too long F002 *PERSONAL VERSION
if (strlen ( basename ( $target_file ) ) > MAX_FILENAME_LENGTH) {
	echo "<p> File name <strong>" . basename ( $target_file ) . " </strong>too long <strong> max length = " . MAX_FILENAME_LENGTH . "</strong></p>";
}

// F001 Source files should not use solely the '\r' (CR) character FAILED
$count = 0;
foreach ( $lines as $line ) {
	$count ++;
	if (strpos ( $line, "\r" ) + 1 == strlen ( $line )) {
		echo strpos ( $line, "\r" ) + 1;
		echo ", ";
		echo strlen ( $line );
		echo "\n";
		echo "<p>Source files should not use the '\\r' (CR) character. <strong>Line: " . $count . "</strong></p>";
	}
}

// L002 Don't use tab characters
$count = 0;
foreach ( $lines as $line ) {
	$count ++;
	if (preg_match ( "/\t.*/", "$line" )) {
		echo "<p>Source files should not use tabs <strong>Line: " . $count . "</strong></p>";
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
			echo "<p>Too many consecutive empty lines. <strong>Line: $count </strong></p>";
		}
	} else {
		$emptyLines = 0;
		$discovered = false;
	}
}

// L003a Source files should not have a leading empty line
$count = 0;
	if(count($lines)>0){
	if (trim($lines[0]) ==""){
		echo "<p>Source files should not have a leading empty line<strong>Line: $count</strong></p>";
	}
}
?>
	
	
	
	