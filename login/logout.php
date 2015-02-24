<?php //Test case deletes _SESSION
include "db-info.php";
$_SESSION = array ();
session_destroy ();
?>
<meta http-equiv="refresh" content="0;../index.html">

