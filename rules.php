<?php
	include("config.php");
//Error Checking
echo "<h2> Errors </h2>";

//L006 Source file sould not be too long
$lines = file($target_file); 
$numLines = count($lines);
if($numLines > MAX_NUM_LINES){
echo "<p>There are <strong>$numLines </strong>lines. Limit is <strong>".MAX_NUM_LINES."</strong></p>";
}

//L006 Line should not be too long
foreach($lines as $line){
if(strlen($line) > MAX_LINE_LENGTH){
	echo "<p>".$line." <strong>line too long maxlength = " .MAX_LINE_LENGTH." </strong></p>";
	}
} 

//File names should be well formed

?>