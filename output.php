<?php
include 'css/css.php';
include 'js/js.php';

$lines =  file_get_contents( $target_file );
echo "<h2>Feedback</h2>";
$vera = removePrompt($vera, "\n");
echo "<pre>$vera</pre>";
preg_match_all('/(\d+):/', $vera, $feedback_lines_nums);

if (!empty($_FILES)){
	$real_filename = $_FILES['fileToUpload']['name'];
	$errors = str_replace($filename, $real_filename, $errors);
}else{
	$real_filename = "userfile.c";
	$errors = str_replace($filename, $real_filename, $errors);
}
$errors = removePrompt($errors, "\n");
if (strlen($errors) > 0){
	echo '<h2>Compilation Errors</h2>';
	echo "<pre>$errors</pre>";
}else{
	echo '<h4>No compilation errors.</h4>';
}
preg_match_all('/:(\d+):/', $errors, $error_lines_nums);
$ssh->write ( "./a.out\n" );
$ssh->read ( '/.*@.*[$|#]/', NET_SSH2_READ_REGEX );
echo '<pre class="language-c" data-line="'.implode(", ",$feedback_lines_nums[1]).'"><code>';
echo myhtmlentities($lines);
echo '</code></pre>';
?>
