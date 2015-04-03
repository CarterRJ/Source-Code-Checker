<?php 
$output_count = 0;
echo '<div class = "code">';
//echo '<div class = "code"><code>';
echo'<style>
.class_name_demo { border: 2px solid #000; }
</style>';
 
/*echo '<pre class="brush: c; toolbar: false class-name: \'class_name_demo\' highlight: [';

if ($source_too_long) {
	for($i = MAX_NUM_LINES; $i <= count($lines) ; $i++){
	echo $i.",";
	}
}

if (isset($tablines)) {
	foreach ( $tablines as $tl ) {
		echo $tl . ",";
	}
}

if (isset($crlines)) {
	foreach ( $crlines as $crl ) {
		echo $crl . ",";
	}
}

if (isset($complines[1])) {
	foreach ( $complines[1] as $cl ) {
		echo $cl . ",";
	}
}

if (isset($longlines)) {
	foreach ( $longlines as $ll ) {
		echo $ll . ",";
	}
}
echo ']">';
*/
echo "<pre>";
foreach ( $lines as $line ) {
	echo htmlentities($line);
	$no_match = 1;
	$output_count ++;
}
echo '</pre></div>';
//echo '</div></code>';

?>

<script type="text/javascript">
     SyntaxHighlighter.all()
</script>

