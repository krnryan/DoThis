<?php
require_once 'backend/sessions.php';
require_once 'backend/proj_functions.php';
require_once 'backend/user_functions.php';
require_once 'backend/invite_function.php';

if (isset($_GET["id"]) && !empty($_GET["id"])) {
		$proj_id = $_GET["id"];
	} else {
		die("No page specified!");
	}

	$project = get_proj($proj_id);
    $project_confirm = confirm_project($proj_id, $_SESSION['user']['user_id']);
    $users = get_user($_SESSION['user']['user_id']);

    foreach($users as $user) {
        $firstname = $user['firstname'];
    }

    foreach($project as $proj) {
        $proj_title_col = $proj['title'];
        $proj_desc_col = $proj['description'];
        $proj_ts_col = $proj['created_ts'];
    }

    if(empty($project_confirm)) {
        die ('<h1>Page not found!</h1>');
    }


if (isset($_POST["msg"]) && isset($_POST["email"])) {
    $email = $_POST["email"];
    $body = $_POST["msg"];
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

        mail($to,$subject,$message,$headers);
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>The Most Fun Way of Work</title>
        <link rel="shortcut icon" type="image/png" href="img/logo_sm_dothis.png" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <link href='http://fonts.googleapis.com/css?family=Amatic+SC:700' rel='stylesheet' type='text/css'>
        <link type="text/css" rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><div id="brand"></div>Do This</a>
                    <div id="text-center" class="navbar-right"><p>
                        <?php if (!isset($_SESSION['user'])){
                            echo ('Login here');
                        } else {
                            echo ('Logout here');
                        }
                        ?>
                        <i class="fa fa-share fa-fw"></i></p>
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                <li class="page-scroll">
                <a href="#about">What is do this</a>
                </li>
                <li class="page-scroll">
                <a href="#features">Features</a>
                </li>
                <li class="page-scroll">
                <a href="#register">Register</a>
                </li>
                <li class="page-scroll">
                <a href="#contact">Contact us</a>
                </li>
                </ul>
                    <div id="nav-hidden" class="nav navbar-nav navbar-right">
                        <hr>
                        <form role="form" method="post">
                            <div class="form-group">
                            <?php 
                                if (!isset($_SESSION['user'])){
                                    echo ('<h1>Let&apos;s do this!</h1>
                                <input type="text" class="form-control" name="username" placeholder="Username" />
                                <input type="password" class="form-control" name="password" placeholder="Password" />
                                <button class="btn btn-default" type="submit">Login</button>');
                                } else {
                                    echo ('<button id="logout_collapse" class="btn btn-default">Logout</button>
                                <h2>OR</h2>
                                <button id="to_dashboard_collapse" class="btn btn-default">Back to dashboard</button>');
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div id="general" class="container">
            <div class="row">
                <div class="col-md-3">
                    <button id="to_dashboard" type="button" class="btn btn-default col-md-12" onclick="location: dashboard.php"><span class="glyphicon glyphicon-hand-left"></span> Back to Dashboard</button>
                    <div id="new_project" class="col-md-12">
                        <span id="briefcase" class="glyphicon glyphicon-briefcase"></span>
                        <h1>Project <?php echo $proj_title_col ?></h1><hr>
                        <h3><?php echo $proj_desc_col ?></h3>
                        <button type="submit" class="btn btn-default" style="display: none">Save changes</button>
                    </div>
                    <button id="setting" type="button" class="btn btn-default col-md-12" data-container="body" data-toggle="popover" data-placement="bottom" data-content=""><span class="glyphicon glyphicon-cog"></span> SETTING</button>
                </div>
            </div>
        </div>
        
    <div id="setting_options" class="popover">
        <ul id="proj_list">
            <li class="btn btn-primary" data-toggle="modal" data-target="#basicModal_invite">Invite people</li>
            <li data-toggle="modal" data-target="#basicModal_edit" style="cursor: pointer">Edit project</li>
            <li data-toggle="modal" data-target="#basicModal_delete" style="cursor: pointer">Delete project</li>
        </ul>
    </div>
    
    <!-- Hidden modal #1 for invitation -->
    <div class="modal fade" id="basicModal_invite" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 id="message" class="centering">Invite people to your project</h1>
                </div>
                <div class="modal-body centering">
                    <div id="form-section" class="dash-form">
                        <form id="proj-reg-form" class="navbar-form" method="post">
                            <input type="text" class="form-control" id="invite_email" name="email" placeholder="Email address"><br>
                            <textarea type="text" class="form-control" id="invite_msg" name="msg" placeholder="Message"></textarea><br><hr>
                            <button type="submit" class="btn btn-default">SEND</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Hidden modal #2 for edit -->    
    <div class="modal fade" id="basicModal_edit" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 id="edit_message" class="centering">Edit your project</h1>
                </div>
                <div class="modal-body centering">
                    <div id="form-section" class="dash-form">
                        <form id="proj-edit-form" class="navbar-form" method="post">
                            <input type="text" class="form-control" id="edit_title" value="<?php echo $proj_title_col; ?>"><br>
                            <textarea type="text" class="form-control" id="edit_description"><?php echo $proj_desc_col; ?></textarea><br><hr>
                            <button type="submit" class="btn btn-default">SAVE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <!-- Hidden modal #3 for delete -->    
    <div class="modal fade" id="basicModal_delete" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 id="delete_message" class="centering">Deleting project <?php echo $proj_title_col; ?></h1>
                </div>
                <div class="modal-body centering">
                    <div id="form-section" class="dash-form">
                        <button id="delete" class="btn btn-success">Go ahead!</button>
                        <span id="space"></span>
                        <button id="cancel" class="btn btn-danger">No way!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    </body>

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>

<script>
$(function(){
    $('#setting').popover({
        html: true,
        trigger: "click",
        placement: "bottom",
        title: "<h2>Options</h2>",
        content: function() {
            return $('#setting_options').html();
        }
    });
    
    $('#proj-edit-form').submit(function(){
        var patt_projname = /^[a-zA-Z0-9]+/;
        var patt_description = /^[a-zA-Z0-9]+/;
        var proj_name = $('#edit_title').val();
        var description = $('#edit_description').val();

        if (!patt_projname.test(proj_name)){
            $('#edit_message').html('Please fill out the title');
            return false;
        } else {
            $('#edit_message').html('Edit your project');
        }

        if (!patt_description.test(description)){
            $('#edit_message').html('Please fill out the description');
            return false;
        } else {
            $('#edit_message').html('Edit your project');
        }

        //AJAX call
        var data = {
            'proj_id': <?php echo $proj_id ?>,
            'proj_name': proj_name,
            'description': description,
        }

        $.post('ajax/proj_edit.php', data, 
            function(response){
                if (response == 1) {
                    $('#edit_message').html('Saving');
                    $('.modal-body').html('').html('<i class="fa fa-spinner fa-spin fa-5x"></i>').animate({
                        opacity: 1
                        }, 2000, function(){
                            $('#basicModal_edit').modal('toggle');
                            location.reload();
                        });
                } else {
                    $('#edit_message').html('Something went wrong :<');
                }
            }
        );
        return false;
    });
    
    $('#delete').click(function(){
        var data = {
            'proj_id': <?php echo $proj_id ?>,
        }

        $.post('ajax/proj_delete.php', data, 
            function(response){
                if (response == 1) {
                    $('#delete_message').html('deleting');
                    $('.modal-body').html('').html('<i class="fa fa-spinner fa-spin fa-5x"></i>').animate({
                        opacity: 1
                        }, 2000, function(){
                            $('#basicModal_delete').modal('toggle');
                            window.location.href = 'dashboard.php';
                        });
                } else {
                    $('#delete_message').html('Something went wrong :<');
                }
            }
        );
        return false;         
    });
    
    $('#cancel').click(function(){
        $('#basicModal_delete').modal('toggle');
    });
    
    $('#to_dashboard').click(function(){
        window.location.href = 'dashboard.php';
        return false;
    });

});

</script>

<script src="js/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
</html>