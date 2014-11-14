<?php
session_start();
require_once 'database.php';

function add_user($fullname, $email, $username, $password, $project_id = NULL)
{
    global $db_link;
	
	$hashed_password = sha1($password);

    $insert_query = 'INSERT '.TBL_USERS.'(`fullname`, `username`, `email`, `password`)
                        VALUES(
                        	"'.addslashes($fullname).'",
                            "'.addslashes($username).'",
                            "'.addslashes($email).'",
                            "'.addslashes($hashed_password).'")';

    if($result = mysql_query($insert_query))
    {
        if($project_id !==NULL){
            add_user_proj($project_id, (int)mysql_insert_id());
        };
		return true;
    }
    return mysql_error();
}

function add_user_proj($project_id, $user_id, $is_admin = NULL)
{
    global $db_link;
	
	$hashed_password = sha1($password);
    
    if ($is_admin !== NULL)
    {
        $is_admin = 1;
    } else {
        $is_admin = 0;
    }

    $insert_query = 'INSERT '.TBL_USER_PROJ.'(`project_id`, `user_id`, `is_admin`)
                        VALUES(
                        	"'.addslashes($project_id).'",
                            "'.addslashes($user_id).'",
                            "'.addslashes($is_admin).'")';

    if($result = mysql_query($insert_query))
    {
		return true;
    }
    return mysql_error();
}

function get_user($id = NULL)
{
    $select_query = 'SELECT user_id, fullname, username, email
                      FROM ' . TBL_USERS;

    if ($id !== NULL)
    {
        $select_query .= ' WHERE `user_id`=' . (int)$id;
    }

    $select_query .= ' ORDER BY `user_id` ASC';

    $result = mysql_query($select_query);

    $users = array();
    while ($row = mysql_fetch_assoc($result))
    {
        $users[] = $row;
    }
    
    return $users;
}

function unique_check($field, $value)
{
    $select_query = 'SELECT user_id FROM '.TBL_USERS;
    switch($field)
    {
        case 'username':
            $select_query .= ' WHERE username="'.addslashes($value).'"';
            break;
        case 'email':
            $select_query .= ' WHERE email="'.addslashes($value).'"';
            break;
    }

    if($result = mysql_query($select_query))
    {
        if(mysql_num_rows($result) > 0)
        {
            return FALSE;
        }

        return TRUE;
    }

    return TRUE;
}

function login_user($username, $password)
{
    global $db_link;
	
	$hashed_password = sha1($password);

    $select_query = 'SELECT user_id, username, email FROM '.TBL_USERS.'
                        WHERE `username`="'.addslashes($username).'"
                        AND `password`="'.addslashes($hashed_password).'"';

    $result = mysql_query($select_query);
    if(mysql_num_rows($result) == 0)
    {
        return 'Invalid login credentials';
    }

    $row = mysql_fetch_assoc($result);
	
    $_SESSION['user'] = $row;
    return $row;
}

function logout_session()
{
    unset($_SESSION['user']);
    session_destroy();
    return TRUE;
}

?>