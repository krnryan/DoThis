<?php
require_once 'backend/sessions.php';
require_once 'backend/proj_functions.php';
require_once 'backend/user_functions.php';

if (isset($_GET["id"]) && $_GET["id"]!="") {
		$proj_id = $_GET["id"];
	} else {
		die("No page specified!");
	}

	$project = get_proj($proj_id);
    $users = get_user($_SESSION['user']['user_id']);

    foreach($users as $user) {
        $fullname = $user['fullname'];
    }

    foreach($project as $proj) {
        echo '<h1>Hello, '.$fullname.'</h1>     
            <p>Project '.$proj['title'].'</p>
            <p>Description: '.$proj['description'].'</p>';
    }
?>