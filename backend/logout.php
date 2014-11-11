<?php
	require_once ('user_functions.php');
	logout_session();
	header('Location: ../index.php');
?>