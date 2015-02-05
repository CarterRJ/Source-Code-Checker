<?php
include ("config.php");
echo '<link href="css/lighter.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/index.css">';

// Error Checking
echo "<h2> Errors </h2>";
$source_too_long = false;
// L006 Source file should not be too long
$lines = file ( $target_file );
$numLines = count ( $lines );
if ($numLines > MAX_NUM_LINES) {
	$source_too_long = true;
	echo "<p>There are <strong>$numLines </strong>lines. The limit is <strong>" . MAX_NUM_LINES . "</strong></p>";
}

// L006 Line should not be too long
$count = 0;
$longlines;
foreach ( $lines as $line ) {
	$count ++;
	if (strlen ( $line ) > MAX_LINE_LENGTH) {
		$longlines [] = $count;
		echo "<p>" . $line . " <strong>line too long max line length = " . MAX_LINE_LENGTH . " </strong></p>";
	}
}
var_dump ( $longlines );

// F002 File names should not be too long F002 *PERSONAL VERSION
if (strlen ( basename ( $target_file ) ) > MAX_FILENAME_LENGTH) {
	echo "<p> File name <strong>" . basename ( $target_file ) . " </strong>too long <strong> max length = " . MAX_FILENAME_LENGTH . "</strong></p>";
}

// F001 Source files should not use solely the '\r' (CR) character FAILED
$count = 0;
foreach ( $lines as $line ) {
	$count ++;
	if (strpos ( $line, chr ( 0x0D ) ) + 1 == strlen ( $line )) {
		echo strpos ( $line, chr ( 0x0A ) ) + 1;
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
if (count ( $lines ) > 0) {
	if (trim ( $lines [0] ) == "") {
		echo "<p>Source files should not have a leading empty line <strong>Line: $count</strong></p>";
	}
}

// OUTPUT
$output_count = 0;
echo '<div class = "code"><code style = "background: pink;"><p>';
foreach ( $lines as $line ) {
	$no_match = 1;
	$output_count ++;
	// Long lines
	If (($source_too_long = true) && ($output_count == MAX_NUM_LINES)) {
		echo '<span class = "long_source">';
	}
	
	foreach ( $longlines as $ll ) {
		if ($output_count == $ll) {
			$no_match = 0;
			echo "<span class = \"max_lines\">";
			$newstr = str_replace ( ' ', '&nbsp;', htmlentities ( $line ) );
			echo $newstr;
			echo "</span><br>";
		}
	}
	if ($no_match) {
		echo str_replace ( ' ', '&nbsp;', htmlentities ( $line, ENT_QUOTES, 'UTF-8' ) ) . '<br>';
	}
}
echo '</p></span></code></div>';

?>
	
	
	
	