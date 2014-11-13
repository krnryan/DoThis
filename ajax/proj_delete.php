<?php

require_once '../backend/proj_functions.php';

    $result = delete_proj($_POST['proj_id']);
    $response = $result;

    if($response === TRUE){
            echo 1;
        } else {
            echo $response;
        }

?>