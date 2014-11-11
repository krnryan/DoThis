<?php

require_once '../backend/user_functions.php';

$result = 2;

if(isset($_POST['user_id']) OR isset($_POST['user_email'])) {
	if(isset($_POST['user_id']) AND !empty($_POST['user_id'])){
		$result = unique_check('username', $_POST['user_id']);
	}
	elseif (isset($_POST['user_email']) AND !empty($_POST['user_email'])){
		$result = unique_check('email', $_POST['user_email']);
	}
}	

echo (int)$result;