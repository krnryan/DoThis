<?php
session_start();
ob_start();
if(file_exists(__DIR__.'/../constants.php')) {
    require_once __DIR__.'/../constants.php';
} else {
    require_once 'constants.php';
}

// If the 'user' key in the session data is not present, then the user has not logged in.
// Redirect the user to the login page if that is the case.
if(!isset($_SESSION['user'])) {
    header('Location: index.php?url='.$_SERVER['REQUEST_URI']);
}