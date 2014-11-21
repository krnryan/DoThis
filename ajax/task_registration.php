<?php

require_once '../backend/task_functions.php';

	if( isset($_POST['project_id']) AND 
		isset($_POST['user_id'])AND 
		isset($_POST['task_title'])AND 
		isset($_POST['task_list']))
	{
		$result = add_task($_POST['project_id'], $_POST['user_id'], $_POST['task_title'], $_POST['task_list']);
		
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