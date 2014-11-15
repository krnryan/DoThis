<?php
require_once 'backend/proj_functions.php';
require_once 'backend/user_functions.php';
require_once 'backend/invite_function.php';

    if (isset($_GET["id"]) && !empty($_GET["id"]) && isset($_GET["email"])) {
            $invite_id = $_GET["id"];
            $invite_email = $_GET["email"];
        } else {
            die("No page specified!");
        }

    $invt_result = confirm_invitation($invite_id);

    if($invt_result == false) {
        die("No invitation specified!");
    }

    foreach($invt_result as $invt_info){
        $admin_id = $invt_info['admin_id'];
        $project_id = $invt_info['project_id'];
        $project_title = $invt_info['title'];
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<title>The Most Fun Way of Work</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
	                <a class="navbar-brand" href="http://dothis.ryanmingyuchoi.com"><div id="brand"></div>Do This</a>
                    <div id="text-center" class="navbar-right"><p>
                        <?php if (!isset($_SESSION['user'])){
                                    echo ('Login here');
                                } else {
                                    echo ('Logout here');
                                }
                        ?>
                    <i class="fa fa-share fa-sm"></i></p></div>
	            </div>
                
	            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	                <ul class="nav navbar-nav navbar-right">
	                    <li class="page-scroll">
	                        <a href="http://dothis.ryanmingyuchoi.com#about">What is do this</a>
	                    </li>
	                    <li class="page-scroll">
	                        <a href="http://dothis.ryanmingyuchoi.com#features">Features</a>
	                    </li>
	                    <li class="page-scroll">
	                        <a href="http://dothis.ryanmingyuchoi.com#register">Register</a>
	                    </li>
	                    <li class="page-scroll">
	                        <a href="http://dothis.ryanmingyuchoi.com#contact">Contact us</a>
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
        
        <div id="register" class="container scrollpoint">
            <div class="block">
                <div class="centered">
                    <div id="choice">
                        <h1 class="text-center">Welcome to</h1>
                        <img class="img-responsive" alt="Responsive image" src="img/logo_sm_dothis.png"/>
                        <h1 class="text-center">You are invited to join project<br>
                                <span style="font-size: 2em"><?php echo $project_title ?></span></h1>
                        <div id="button-container" class="text-center">
                            <button type="button" id="btn-reg" class="btn btn-danger btn-lg">JOIN</button>
                        </div>
                    </div>
                    <div id="form-section">
                        <form id="reg-form" class="navbar-form text-center" style="display: none" method="post">
                            <h1 class="centering">You are about to join project<br>
                                <span style="font-size: 2em"><?php echo $project_title ?></span></h1>
                            <h1 id="message" class="centering">Let's Do This!</h1>
                                <input type="text" class="form-control" id="fullname" placeholder="Full name"><br>
                                <input type="text" class="form-control" id="username" placeholder="Username"><br>
                                <input type="password" class="form-control" id="password" placeholder="Password"><br>
                                <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $invite_email ?>" readonly><br>
                            
                            <button type="submit" class="btn btn-default">JOIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script>
            $(function(){
                $('#btn-reg').click(function(){
                    $('#choice').animate({
                        opacity: 0
                    }, 500, function(){
                        $('#choice').attr('style', 'display: none');
                        $('#reg-form').attr('style', '');
				    });
                });
                
                $('#username').blur(function(){
                    var user_field = $(this);
                    var data = {
                        'user_id': $(this).val()
                    }
                    $.post('ajax/unique_check.php', data,
                        function(response){
                            if(response == 2){
                                user_field.removeClass('alert-danger').removeClass('alert-success');
                                $('#message').html('Let&apos;s Do This!');
                            }
                            else if(response == 1) {
                                user_field.removeClass('alert-danger').addClass('alert-success');
                                $('#message').html('Let&apos;s Do This!');
                            }  else {
                                user_field.removeClass('alert-success').addClass('alert-danger');
                                $('#message').html('That username is already in use!');
                            }
                        }
                    );
                });

                $('#email').blur(function(){
                    var user_field = $(this);
                    var data = {
                        'user_email': $(this).val()
                    }
                    $.post('ajax/unique_check.php', data,
                        function(response){
                            if(response == 2){
                                user_field.removeClass('alert-danger').removeClass('alert-success');
                                $('#message').html('Let&apos;s Do This!');
                            }
                            else if(response == 1) {
                                user_field.removeClass('alert-danger').addClass('alert-success');
                                $('#message').html('Let&apos;s Do This!');
                            } else {
                                user_field.removeClass('alert-success').addClass('alert-danger');
                                $('#message').html('That email is already in use');
                            }
                        }
                    );
                });
                
                $('#reg-form').submit(function(){
                    var patt_fullname = /^[a-zA-Z]+/;
                    var patt_username = /^[a-zA-Z0-9]{6,20}$/;
                    var patt_password = /^[a-zA-Z0-9]{6,12}$/;
                    var patt_password2 = /[A-Z]+/;
                    var patt_password3 = /[0-9]+/;
                    var patt_email = /^[a-zA-Z0-9\.]+@[a-zA-Z0-9]+\.[a-z]{2,4}$/;
                    
                    var fullname = $('#fullname').val();
                    var username = $('#username').val();
                    var password = $('#password').val();
                    var email = $('#email').val();

                    if (!patt_fullname.test(fullname)){
                        $('#message').html('Please fill out your fullname');
                        return false;
                    } else {
                        $('#message').html('Let&apos;s Do This!');
                    }

                    if (!patt_username.test(username)){
                        $('#message').html('Username requires min 6, max 20 length');
                        return false;
                    } else {
                        $('#message').html('Let&apos;s Do This!');
                    }

                    if (!patt_password.test(password)){
                        $('#message').html('Password requires min 6, max 12 length');
                        return false;
                    } else {
                        $('#message').html('Let&apos;s Do This!');
                    }

                    if (!patt_password2.test(password)){
                        $('#message').html('Password requires at least one Cap letter');
                        return false;
                    }

                    if (!patt_password3.test(password)){
                        $('#message').html('Password requires at least one number');
                        return false;
                    } else {
                        $('#message').html('Let&apos;s Do This!');
                    }

                    if (!patt_email.test(email)){
                        $('#message').html('Email is invalid');
                        return false;
                    } else {
                        $('#message').html('Let&apos;s Do This!');
                    }
                    
                    //AJAX call
                    var data = {
                        'user_fullname': fullname,
                        'user_id': username,
                        'user_password': password,
                        'user_email': email,
                        'project_id': <?php echo $project_id ?>,
                    }

                    $.post('ajax/registration.php', data, 
                        function(response){
                            if (response == 1) {
                                $('#form-section').html('').html('<h1>Registering YOU</h1><i class="fa fa-spinner fa-spin fa-5x"></i>').animate({
                                    opacity: 1
                                }, 2000, function(){
                                    $('#reg-form').each(function(){
                                        this.reset();
                                    });
                                    <?php delete_invitation($invite_id) ?>
                                    location.href="dashboard.php";
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
    </body>
</html>