<?php

require_once '../backend/proj_functions.php';

	if( isset($_POST['proj_name']) AND 
		isset($_POST['description']))
	{
		$result = update_proj($_POST['proj_id'], $_POST['proj_name'], $_POST['description']);
		
		$response = $result;
		
	}
	else {
		$response = 'Requested fields are missing';
	}
	if($response === TRUE){
		echo 1;
	} else {
		echo $response;
	}

?>