<?php
session_start();
require_once 'database.php';

function add_proj($proj_name, $description) {
    $admin = $_SESSION['user']['user_id'];

    $insert_query_proj = 'INSERT '.TBL_PROJ.'(`title`, `description`, `admin_id`, `created_ts`)
                        VALUES(
                        	"'.addslashes($proj_name).'",
                            "'.addslashes($description).'",
							"'.$admin.'",
                            "'.time().'")';

    if($result = mysql_query($insert_query_proj))
    {
		return true;
    }
    return mysql_error();
};

function get_proj($id = NULL)
{
    $select_query = 'SELECT p.*, u.username
                      FROM ' . TBL_PROJ . ' p';

    $select_query .= ' JOIN ' . TBL_USERS . ' u
                    ON u.`user_id` = p.`admin_id`';
    
    if ($id !== NULL)
    {
        $select_query .= ' WHERE p.`proj_id`=' . (int)$id;
    } else {
        $select_query .= ' WHERE p.`admin_id`=' . $_SESSION['user']['user_id'];
    }
    
    $result = mysql_query($select_query);

    $projects = array();
    while ($row = mysql_fetch_assoc($result))
    {
        $projects[] = $row;
    }

    return $projects;
}

function get_proj_count($user_id = NULL)
{
    $select_query = 'SELECT COUNT(`proj_id`) AS `total`
                      FROM ' . TBL_PROJ;

    if($user_id !== NULL)
    {
        $select_query .= ' WHERE `admin_id`='.(int)$user_id;
    }

    $result = mysql_query($select_query);
    $row = mysql_fetch_assoc($result);

    return $row['total'];
}

function update_proj($proj_id, $title, $description)
{
    global $db_link;

    $data = array(
        '`title` = "' . addslashes($title) . '"',
        '`description` = "' . addslashes($description) . '"',
    );

    $insert_query = 'UPDATE ' . TBL_PROJ . '
                        SET ' . implode(',', $data) . '
                        WHERE `proj_id`=' . (int)$proj_id;

    if($result = mysql_query($insert_query))
    {
		return TRUE;
    }
    return mysql_error();

    return FALSE;
}

function delete_proj($id)
{
    $delete_query = 'DELETE FROM ' . TBL_PROJ . ' WHERE `proj_id`=' . (int)$id;
    if ($result = mysql_query($delete_query))
    {
        return TRUE;
    }

    return FALSE;
}

?>