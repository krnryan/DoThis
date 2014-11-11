<?php
session_start();
require_once 'database.php';

function add_user($fullname, $email, $username, $password)
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
		return true;
    }
    return mysql_error();
}

function add_role($user_id, $role_id) {
	$insert_query_role = 'INSERT '.TBL_USER_ROLE_MAP.'(`user_id`,`role_id`)
							VALUES(
								"'.$user_id.'",
								"'.$role_id.'")';
    if($result = mysql_query($insert_query_role))
    {
        return true;
    }
    return mysql_error();
}

function add_team($team_name, $team_description, $admin_id) {
	$hashed_teamname = md5($team_name);

    $insert_query_team = 'INSERT '.TBL_TEAMS.'(`team_id`, `team_name`, `team_description`, `admin_id`)
                        VALUES(
                        	"'.addslashes($hashed_teamname).'",
                        	"'.addslashes($team_name).'",
                            "'.addslashes($team_description).'",
							"'.$admin_id.'")';

    if($result = mysql_query($insert_query_team))
    {
		return true;
    }
    return mysql_error();
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