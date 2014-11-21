<?php
session_start();
require_once 'database.php';

function add_task($project_id, $user_id, $task_title, $task_list) {

    $insert_query_proj = 'INSERT '.TBL_TASKS.'(`project_id`, `user_id`, `task_title`, `task_list`, `created_ts`)
                        VALUES(
                        	"'.(int)$project_id.'",
                            "'.(int)$user_id.'",
							"'.addslashes($task_title).'",
							"'.addslashes($task_list).'",
                            "'.time().'")';

    if($result = mysql_query($insert_query_proj))
    {
		return true;
    }
    return mysql_error();
};

function get_task($id)
{
    $select_query = 'SELECT *
                      FROM ' . TBL_TASKS;
    $select_query .= ' WHERE `user_id`=' . (int)$id;

    $result = mysql_query($select_query);

    $tasks = array();
    while ($row = mysql_fetch_assoc($result))
    {
        $tasks[] = $row;
    }
    
    return $tasks;
}

?>