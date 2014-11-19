<?php
session_start();
require_once '../backend/database.php';
require_once '../backend/invite_function.php';

if(isset($_POST['email_email']) AND isset($_POST['email_msg']) AND isset($_POST['firstname']) AND isset($_POST['project_id'])) {  
    $email = $_POST["email_email"];
    $body = $_POST["email_msg"];
    $firstname = $_POST['firstname'];
    $proj_id = $_POST['project_id'];
        
    $trimmed_email = trim($email, " ");
    $ind_emails = explode(",", $trimmed_email);
    
    foreach($ind_emails as $ind_email) {
        $invt_num = add_invitation($proj_id);
        $to = $ind_email;

        $subject = "Invitation to DoThis from ".$firstname;

        $message = "
        <html>
            <head>
                <title>Invitation from DoThis</title>
            </head>
            <body>
                <div style='@import url(http://fonts.googleapis.com/css?family=Amatic+SC:400,700); width: 100%; height: 100%'>
                    <div style='width: 500px; height: 500px; border: 2px solid #F3C100; margin: 0 auto; border-radius: 5px;'>
                        <div style='width: 298px; height: 298px; margin: 50px auto 20px auto'>
                            <img src='dothis.ryanmingyuchoi.com/img/logo_sm_dothis.png' />
                        <div>
                        <h1 style='text-align: center; font-family: Amatic SC; font-size: 60px; margin: 20px; color: black;'>Hello, there!</h1>
                        <h2 style='text-align: center; font-family: Amatic SC; font-size: 30px; margin: 20px; color: black;'>".$firstname." wants you to join his/her project to work together!</h2><br>
                        <h2 style='text-align: center; font-family: Amatic SC; font-size: 30px; margin: 20px; color: black;'>''".$body."''</h2><br>

                        <a style='text-decoration: none; color: white;' href='http://dothis.ryanmingyuchoi.com/invite.php?email=".$to."&id=".$invt_num."'><div style='background-color: #F3C100; height: 40px; border-radius: 5px;'><h2 style='text-align: center; font-family: Amatic SC; font-size: 30px; margin: 10px;'>Accept</h2></div></a>
                    </div>
                </div>
            </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: DoThis <".MAIL_FROM.">";

        $result = mail($to,$subject,$message,$headers);
	} 
} else {
        $result = 'Bad!';
    }

    echo $result;
?>