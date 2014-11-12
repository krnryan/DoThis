<?php require_once 'backend/sessions.php'; ?>

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
                <div id="new_project" class="col-md-2">
                    <i class="fa fa-folder-open-o fa-5x"></i>
                    <h1>NEW PROJECT</h1>
                </div>
        <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
                        <h1 id="message">New project</h1>
                    </div>
		            <div class="modal-body">
                        <div id="form-section" class="dash-form">
                            <form id="proj-reg-form" class="navbar-form text-center" method="post">
                                <h1 id="message">Create project</h1>
                                <input type="text" class="form-control" id="proj_title" placeholder="Project title"><br>
                                <textarea type="text" class="form-control" id="description" placeholder="Short description of project"></textarea></textarea><br>
                        </div>
                    </div>
		            <div class="modal-footer"><button type="submit" class="btn btn-default">Create</button></div>
                    </form>
		    	</div>
		  	</div>
		</div>
    
        <div id="project_list">
            <h1>List of your projects</h1>
            <ul id="proj_list">
                <?php 
                    require_once 'backend/proj_functions.php';
                    $projects = get_proj();
                    foreach($projects as $project){
                        echo '<li><a href="project.php?id='.$project['proj_id'].'">'.$project['title'].'</a></li>';
                    }
                ?>
            </ul>
        </div>
        </div>
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
                $('#message').html('Create project');
            }

            if (!patt_description.test(description)){
                $('#message').html('Please fill out the description');
                return false;
            } else {
                $('#message').html('Create project');
            }

            //AJAX call
            var data = {
                'proj_name': proj_name,
                'description': description
            }

            $.post('ajax/proj_registration.php', data, 
                function(response){
                    if (response == 1) {
                        $('#message').html('New project on the way');
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
    });
</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</html>