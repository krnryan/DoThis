<?php
require_once 'backend/sessions.php';
require_once 'backend/proj_functions.php';
require_once 'backend/user_functions.php';
require_once 'backend/invite_function.php';
require_once 'backend/task_functions.php';

if (isset($_GET["id"]) && !empty($_GET["id"])) {
		$proj_id = $_GET["id"];
	} else {
		die("No page specified!");
	}
    
    $current_user = $_SESSION['user']['user_id'];

	$project = get_proj($proj_id);
    $project_confirm = confirm_project($proj_id, $current_user);
    $users = get_user($current_user);
    $user_infos = get_users_eachproj($proj_id);

    foreach($users as $user) {
        $firstname = $user['firstname'];
    }

    foreach($project as $proj) {
        $proj_title_col = $proj['title'];
        $proj_desc_col = $proj['description'];
        $proj_ts_col = $proj['created_ts'];
        $proj_admin = $proj['admin_id'];
    }

    if(empty($project_confirm)) {
        die ('<h1>Page not found!</h1>');
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
        <nav class="navbar navbar-default navbar-fixed-top project_nav">
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
                <a href="index.php#about">What is do this</a>
                </li>
                <li class="page-scroll">
                <a href="index.php#features">Features</a>
                </li>
                <li class="page-scroll">
                <a href="index.php#register">Register</a>
                </li>
                <li class="page-scroll">
                <a href="index.php#contact">Contact us</a>
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
        
        <div id="project-panel">
            <div class="block">
                <div class="centered">
                    <button id="to_dashboard" type="button" class="btn btn-default" onclick="location: dashboard.php"><span class="glyphicon glyphicon-hand-left"></span> Back to Dashboard</button>
                    <div id="new_project">
                        <span id="briefcase" class="glyphicon glyphicon-briefcase"></span>
                        <h1>Project <?php echo $proj_title_col ?></h1><hr>
                        <h3><?php echo $proj_desc_col ?></h3>
                    </div>
                    <?php
                    if($proj_admin == $current_user){
                        echo ('<button id="setting" type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="bottom" data-content=""><span class="glyphicon glyphicon-cog"></span> SETTING</button>');
                    }
                    ?>
                </div>
            </div>
        </div>
        <div id="task-panel">
        <?php
        foreach($user_infos as $user_info) {
        echo ('
            <div id="panel">
                <div id="worker-panel">
                    <div id="worker-panel-left">
                        <div class="fit">
                            <span id="user_name" style="font-size: 1.2em">'.$user_info['firstname'].'</span>
                            ');
                                if ($user_info['picture'] == ''){
                                    echo ('<br><i class="fa fa-user fa-4x"></i>');
                                } else {
                                    echo ('<i class="fa-stack fa-3x"><img class="fa-stack-1x img-responsive img-circle" src="img/profile/'.$user_info['picture'].'"/>');
                                }
                            echo ('
                            </i>
                        </div>
                    </div>
                    <div id="worker-panel-right">
                        <div class="fit">
                            <p style="font-size: 1.2em">');
                                if ($user_info['is_admin'] == 1) {
                                    echo ('ADMIN');
                                } else {
                                    echo ('MEMBER');
                                }
                            echo ('
                            </p>
                            <a class="cursor emailtomem" style="color: black"><i class="fa fa-envelope fa-2x"></i></a>
                        </div>
                    </div>
                    <p id="member_email" style="display: none">'.$user_info['email'].'</p>
                </div>
                <a class="cursor newtask" style="color: black;');
                if($user_info['user_id'] == $current_user){
                    echo (' ');
                } else {
                    echo ('visibility: hidden');
                }
                echo ('
                    ">
                    <div id="add_task">
                        <div id="fit_two" class="centered">
                            <i class="fa fa-plus"></i>
                            <h4>New task</h4>
                        </div>
                    </div>
                </a>
                ');
                $tasks = get_task($user_info['user_id']);
                foreach($tasks as $task) {
                    echo ('<div id="task"><div id="fit_three" class="centered"><h1>'.$task['task_title'].'</h1><p>'.$task['task_list'].'</p></div></div>');
                }
            echo ('</div>
        ');
        }
        ?>
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
                <div id="email-form-section">
                    <div class="modal-header">
                        <h1 id="email_message" class="centering">Invite people to your project</h1>
                    </div>
                    <div class="modal-body centering">
                        <div id="form-section" class="dash-form">
                            <form id="invitation-form" class="navbar-form" method="post">
                                <input type="text" class="form-control" id="email_email" name="email" placeholder="Email address (separate each email with comma)"><br>
                                <textarea type="text" class="form-control" id="email_msg" name="msg" placeholder="Message"></textarea><br><hr>
                                <button type="submit" class="btn btn-default">SEND</button>
                            </form>
                        </div>
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
        
    <div class="modal fade" id="basicModal_email" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div id="email-form-section-two">
                    <div class="modal-header">
                        <h1 id="email_message" class="centering">Say "Hello" to <span id="mem_name"></span></h1>
                    </div>
                    <div class="modal-body centering">
                        <div class="dash-form">
                            <form id="email-form" class="navbar-form text-center" method="post">
                                <input type="text" class="form-control" id="email_from" value="<?php echo $_SESSION['user']['email'] ?>" readonly><br>
                                <input type="text" class="form-control" id="email_to" readonly><br>
                                <input type="text" class="form-control" id="email_subject" placeholder="Subject"><br>
                                <textarea type="text" class="form-control" id="email_msg_two" placeholder="Say something"></textarea><br><hr>
                                <button type="submit" class="btn btn-default">"HELLO"</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <div class="modal fade" id="basicModal_new_task" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div id="task-form-section">
                    <div class="modal-header">
                        <h1 id="task_message" class="centering">Create new task!</h1>
                    </div>
                    <div class="modal-body centering">
                        <div class="dash-form">
                            <form id="task-form" class="navbar-form text-center" method="post">
                                <input type="text" class="form-control" id="task_title" placeholder="Task title"><br>
                                <textarea type="text" class="form-control" id="task_list" placeholder="To do list"></textarea><br><hr>
                                <button type="submit" class="btn btn-default">CREATE</button>
                            </form>
                        </div>
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
        placement: "right",
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
    
    $('#invitation-form').submit(function(){
        var patt_email = /^(\s*,?\s*[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})+\s*$/;
        var patt_msg = /^[a-zA-Z]+/;

        var email = $('#email_email').val();
        var msg = $('#email_msg').val();

        if (!patt_email.test(email)){
            $('#email_message').html('Email is invalid');
            return false;
        } else {
            $('#email_message').html('Invite people to your project');
        }

        if (!patt_msg.test(msg)){
            $('#email_message').html('Please fill out the message');
            return false;
        } else {
            $('#email_message').html('Invite people to your project');
        }

        //AJAX call
        var data = {
            'email_email': email,
            'email_msg': msg,
            'firstname': '<?php echo $firstname ?>',
            'project_id': <?php echo $proj_id ?>,
        }

        $.post('ajax/invitation_email.php', data, 
            function(response){
                if (response == 1) {
                    $('#email-form-section').html('').html('<div class="centering"><h1>Sending invitation email</h1><i class="fa fa-spinner fa-spin fa-5x"></i></div>').animate({
                        opacity: 1
                    }, 2000, function(){
                        $('#email-form').each(function(){
                            this.reset();
                        });
                        location.reload();
                    });

                } else {
                    $('#email_message').html('Something went wrong :<');
                }
            }
        );

        return false;
    });
    
    $('#cancel').click(function(){
        $('#basicModal_delete').modal('toggle');
    });
    
    $('.emailtomem').click(function(){
        var name = $(this).parent().parent().parent().find('#user_name').html();
        var email = $(this).parent().parent().parent().find('#member_email').html();
        $('#basicModal_email').modal('toggle');
        $('#basicModal_email').find('#mem_name').html(name);
        $('#basicModal_email').find('#email_to').attr('value', email);
    });
    
    $('#to_dashboard').click(function(){
        window.location.href = 'dashboard.php';
        return false;
    });
    
    $('#email-form').submit(function(){
        var patt_subject = /^[a-zA-Z]+/;
        var patt_msg = /^[a-zA-Z]+/;
        
        var email_from = $('#email_from').val();
        var subject = $('#email_subject').val();
        var msg = $('#email_msg_two').val();
        var email_to = $('#email_to').val();

        if (!patt_subject.test(subject)){
            $('#email_message').html('Please fill out the subject');
            return false;
        } else {
            $('#email_message').html('Say "Hello"!');
        }

        if (!patt_msg.test(msg)){
            $('#email_message').html('Please fill out the message');
            return false;
        } else {
            $('#email_message').html('Say "Hello"!');
        }

        //AJAX call
        var data = {
            'email_email': email_from,
            'email_subject': subject,
            'email_msg': msg,
            'email_to': email_to,
        }

        $.post('ajax/email_btw_user.php', data, 
            function(response){
                if (response == 1) {
                    $('#email-form-section-two').html('').html('<div class="centering"><h1>Saying Hi</h1><i class="fa fa-spinner fa-spin fa-5x"></i></div>').animate({
                        opacity: 1
                    }, 2000, function(){
                        $('#email-form').each(function(){
                            this.reset();
                        });
                        $('#basicModal_email').modal('toggle');
                    });

                } else {
                    $('#email_message').html('Something went wrong :<');
                }
            }
        );

        return false;
    });

    $('.newtask').click(function(){
        $('#basicModal_new_task').modal('toggle');
    });
    
    $('#task-form').submit(function(){
        var patt_title = /^[a-zA-Z]+/;
        var patt_list = /^[a-zA-Z]+/;

        var title = $('#task_title').val();
        var list = $('#task_list').val();

        if (!patt_title.test(title)){
            $('#task_message').html('Please fill out the title');
            return false;
        } else {
            $('#task_message').html('Create new task!');
        }

        if (!patt_list.test(list)){
            $('#task_message').html('Please fill out the list');
            return false;
        } else {
            $('#task_message').html('Create new task!');
        }

        //AJAX call
        var data = {
            'project_id': <?php echo $proj_id ?>,
            'user_id': <?php echo $current_user ?>,
            'task_title': title,
            'task_list': list,
        }

        $.post('ajax/task_registration.php', data, 
            function(response){
                if (response == 1) {
                    $('#task-form-section').html('').html('<div class="centering"><h1>Creating task</h1><i class="fa fa-spinner fa-spin fa-5x"></i></div>').animate({
                        opacity: 1
                    }, 2000, function(){
                        $('#task-form').each(function(){
                            this.reset();
                        });
                        location.reload();
                    });

                } else {
                    $('#task_message').html('Something went wrong :<');
                }
            }
        );

        return false;
    });
});

</script>

<script src="js/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
</html>