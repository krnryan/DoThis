<?php

require_once '../backend/user_functions.php';

	if( isset($_POST['user_firstname']) AND
       isset($_POST['user_lastname']) AND
		isset($_POST['user_id']) AND 
		isset($_POST['user_password']) AND 
		isset($_POST['user_email']))
	{
		$result = add_user($_POST['user_firstname'], $_POST['user_lastname'], $_POST['user_email'], $_POST['user_id'], $_POST['user_password'], $_POST['project_id'], $_POST['user_profile_pic']);
		
		$response = $result;
	}
	else {
		$response = 'Requested fields are missing';
	}
	
	echo $response;

?>