<?php

error_reporting(0);

date_default_timezone_set('America/Los_Angeles');

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "dothis");
define("TBL_USERS", "`users`");
define("TBL_PROJ", "`projects`");
define("TBL_INVT", "`invitations`");
define("TBL_USER_PROJ", "`user_project_map`");

define("DIR_JS", "js");
define("DIR_CSS", "css");
define("DIR_IMG", "img");

define("MAIL_FROM", "dothis@ryanmingyuchoi.com");
define("MAIL_TO", "dothis@ryanmingyuchoi.com");

?>