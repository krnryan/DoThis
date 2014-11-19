<?php

require_once '../backend/invite_function.php';

    $result = delete_invitation($_POST['invitation_id']);
    $response = $result;

    if($response === TRUE){
            echo 1;
        } else {
            echo $response;
        }

?>