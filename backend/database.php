<?php

if(file_exists(__DIR__.'/../constants.php')) {
	require_once __DIR__.'/../constants.php';
} else {
	require_once 'constants.php';
}
//we connect to the MySQL database using the host name, the user and the password:
global $db_link;

$db_link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
if (!$db_link) { //in case of error, mysql_connect() returns FALSE; !$something ($something negated) means that $something is not TRUE
	die("Could not connect to the database: ".mysql_error()); //mysql_error() returns the error message from the previous operation
}

//then, we select the database:
$db_selected = mysql_select_db(DB_NAME, $db_link); //similarly to mysql_connect(), mysql_select_db() returns FALSE in case of error
if (!$db_selected) {
	die ("Cannot use database: ".mysql_error());
}

?>