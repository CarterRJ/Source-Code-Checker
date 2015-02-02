<?php
$output;
$return_var;
chdir ( "vagrant" );
exec ( "ls", $output, $return_var );
exec ( "vagrant-script.bat", $output, $return_var );

var_dump ( $output );
echo "Return var: $return_var\n";
?>

