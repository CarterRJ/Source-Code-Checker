<?php
//Error Checking
echo "<h2> Errors </h2>";

//L006 Source file sould not be too long
$lines = file($target_file); 
$numLines = count($lines);
if($numLines > 130){
echo "<p>There are <strong>$numLines </strong>lines. Limit is 130</p>";
}

//L006 Line should not be too long
foreach($lines as $line){
if(strlen($line) > 90){
	echo "<p>".$line." <strong>line too long maxlength = 90</strong></p>";
	}
} 

//File names should be well formed

?>