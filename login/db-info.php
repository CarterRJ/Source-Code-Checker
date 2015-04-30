<?php
if(!isset($_SESSION))
{
	session_start();
}
 
$dbhost = "localhost"; // this will ususally be 'localhost', but can sometimes differ
$dbname = "3rd year individual project"; // the name of the database that you are going to use for this project
$dbuser = "root"; // the username that you created, or were given, to access your database
$dbpass = ""; // the password that you created, or were given, to access your database

ini_set('display_errors','Off');
$db_conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("MySQL Error: " . mysql_error());
mysqli_select_db($db_conn, $dbname) or die("MySQL Error: " . mysql_error());
?>