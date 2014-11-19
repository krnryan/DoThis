<?php
session_start();
require_once '../backend/database.php';

	if(isset($_POST['email_email']) AND isset($_POST['email_subject'])AND  isset($_POST['email_msg'])) {        
        $email = $_POST["email_email"];
        $to = MAIL_TO;
        $subject = $_POST["email_subject"];

        $message = "
        <html>
            <head>
                <title>Voice of DoThis User</title>
            </head>
            <body>
                <p>".$_POST["email_msg"]."</p>
            </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: DoThis User<".$email.">";

        $result = mail($to,$subject,$message,$headers);
		
	} else {
        $result = 'Bad!';
    }

    echo $result;
?>