<?php
set_include_path ( get_include_path () . PATH_SEPARATOR . 'phpseclib' );
$filename = basename($target_file);
$output;
$return_var;
echo $filename;
include ('Net\SSH2.php');
$ssh = new Net_SSH2 ( '127.0.0.1:2222' );
//WATCHOUT LITTERALS HERE
if (! $ssh->login ( 'vagrant', 'vagrant' )) {
	exit ( 'Login Failed' );
}
// echo "<br>";
// echo $ssh->exec('ls');
echo "<br>";
$ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);
$ssh->setTimeout(10);
$ssh->write ( "cd /uploads/c\ unit/ \n" );
$ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);
$ssh->write ( "gcc Cutest.c StrUtil.c AllTests.c\n" );
$ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);
echo '<br>';
$ssh->write ( "./a.out\n" );
$cunit_output = $ssh->read('/.*@.*[$|#]/', NET_SSH2_READ_REGEX);
//echo var_dump($cunit_output);
echo nl2br(htmlentities($cunit_output));
echo "<br>";
?>