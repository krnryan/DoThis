<?php
session_start();
require_once 'database.php';

function add_invitation($proj_id) {
    $admin = $_SESSION['user']['user_id'];
    
    $time = md5(microtime(true)*10000);
    
    $insert_query = 'INSERT '.TBL_INVT.'(`admin_id`, `project_id`, `created_ts`)
                        VALUES(
                        	"'.addslashes($admin).'",
                            "'.addslashes($proj_id).'",
                            "'.$time.'")';
    
    if($result = mysql_query($insert_query))
    {
        return $time;
    };
    return mysql_error();
};

function confirm_invitation($id)
{
    $select_query = 'SELECT i.*, p.*
                      FROM ' . TBL_INVT.' i';
    $select_query .= ' JOIN ' . TBL_PROJ . ' p
                      ON p.`proj_id` = i.`project_id`';
    $select_query .= ' WHERE i.`created_ts`="' . addslashes($id).'"';
    
    $result = mysql_query($select_query);
    if(mysql_num_rows($result) == 0)
    {
        return false;
    } else {
        $invt_info = array();
        while ($row = mysql_fetch_assoc($result))
        {
            $invt_info[] = $row;
        }

        return $invt_info;
    };
}

?>