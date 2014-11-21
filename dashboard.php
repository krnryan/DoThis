<?php require_once 'backend/sessions.php';
    require_once 'backend/proj_functions.php';
    require_once 'backend/user_functions.php';

    $users = get_user($_SESSION['user']['user_id']);
    foreach($users as $user) {
        $firstname = $user['firstname'];
        $profile_pic = $user['picture'];
    }

    $projects = get_proj();
    $count = get_proj_count($_SESSION['user']['user_id']);
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
                    <h1>Hello, <span style="font-size: 1.3em;"><?php echo $firstname; ?></span>.</h1>
                    <div id="profile-picture centered">
                        <img style="border: 8px solid black" class="img-responsive img-circle" src="img/profile/<?php echo $profile_pic ?>"/>
                    </div>
                    <div>
                    <h1>Welcome to your dashboard!</h1>
                        <?php
                            if($count == 0){
                                echo '<h1>You have no ongoing project.</h1>';
                            } elseif($count == 1){
                                echo '<h1>Good luck on your <span style="font-size: 1.3em;">'.$count.'</span> project! :></h1>';
                            }else {
                                echo '<h1>Good luck on your <span style="font-size: 1.3em;">'.$count.'</span> projects! :></h1>';
                            } ?>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div id="dash-panel">
            <button id="new_project" type="button" class="btn btn-default col-md-6"><i class="fa fa-plus-circle fa-5x"></i><h1>NEW PROJECT</h1></button>
            <button id="listofproj" type="button" class="btn btn-default col-md-6" data-container="body" data-toggle="popover" data-placement="bottom" data-content=""><i class="fa fa-folder-open-o fa-5x"></i><h1>Project list</h1></button>
            <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <div class="modal-header">
                            <h1 id="message" class="centering">Create new project</h1>
                        </div>
                        <div class="modal-body centering">
                            <div id="form-section" class="dash-form">
                                <form id="proj-reg-form" class="navbar-form text-center" method="post">
                                    <input type="text" class="form-control" id="proj_title" placeholder="Project title"><br>
                                    <textarea type="text" class="form-control" id="description" placeholder="Short description of project"></textarea><br><hr>
                                    <button type="submit" class="btn btn-default">Create</button>
                                </form>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        
        
    <div id="project_list" style="display: none">
        <ul id="proj_list">
        <?php
            if($count == 0){
                echo '<h1>EMPTY</h1>';
            } else {
                foreach($projects as $project){
                    echo '<li><a href="project.php?id='.$project['proj_id'].'">'.$project['title'].'</a></li>';
                }
            }
        ?>
        </ul>
    </div>
    </body>

<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>

<script>
$(function(){
    $('#new_project').click(function(){
        $('#basicModal').modal({backdrop: 'static'});
    });

    $('#proj-reg-form').submit(function(){
        var patt_projname = /^[a-zA-Z0-9]+/;
        var patt_description = /^[a-zA-Z0-9]+/;
        var proj_name = $('#proj_title').val();
        var description = $('#description').val();

        if (!patt_projname.test(proj_name)){
            $('#message').html('Please fill out the title');
            return false;
        } else {
            $('#message').html('Create new project');
        }

        if (!patt_description.test(description)){
            $('#message').html('Please fill out the description');
            return false;
        } else {
            $('#message').html('Create new project');
        }

        //AJAX call
        var data = {
            'proj_name': proj_name,
            'description': description
        }

        $.post('ajax/proj_registration.php', data, 
            function(response){
                if (response == 1) {
                    $('#message').html('New project is on its way');
                    $('.modal-body').html('').html('<i class="fa fa-spinner fa-spin fa-5x"></i>').animate({
                        opacity: 1
                        }, 2000, function(){
                            $('#proj-reg-form').each(function(){
                                this.reset()
                            });
                            $('#basicModal').modal('toggle');
                            location.reload();
                        });
                } else {
                    $('#message').html('Something went wrong :<');
                }
            }
        );
        return false;
    });

    $('#listofproj').popover({
        html: true,
        trigger: "click",
        placement: "bottom",
        title: "<h2>List</h2>",
        content: function() {
            return $('#project_list').html();
        }
    });
});
</script>

<script src="js/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</html>