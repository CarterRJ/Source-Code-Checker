<?php
include ("config.php");
include 'css/css.php';
include 'js/js.php';

echo "<h2> Feedback </h2>";
$lines =  file_get_contents( $target_file );


?>