<?php
$output;
$return_var;
//chdir ( "vagrant" );
//exec ( "ls", $output, $return_var );
phpinfo();
$session = ssh2_connect('vagrant@localhosts', 22);
//system("cmd /c C:[path to file]");
echo $session;
//var_dump ( $output );
//echo "Return var: $return_var\n";
?>

