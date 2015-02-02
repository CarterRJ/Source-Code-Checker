<?php
$output;
$return_var;
chdir ( "vagrant-script.bat" );
//exec ( "vagrant up", $output, $return_var );
//var_dump ( $output );
exec ( "vagrant up", $output, $return_var );

var_dump ( $output );
exec ( "pwd", $output, $return_var );
var_dump ( $output );
exec ( "pwd", $output, $return_var );

var_dump ( $output );
exec ( "pwd", $output, $return_var );

var_dump ( $output );
exec ( "pwd", $output, $return_var );

// 2>&1
var_dump ( $output );
echo "Return var: $return_var\n";
?>

