<?php //Test case deletes _SESSION
include "db-info.php";
mysqli_close ($db_conn);
$_SESSION = array ();
session_destroy ();
?>
<meta http-equiv="refresh" content="0;../index.html">