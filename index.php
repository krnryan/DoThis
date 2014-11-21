<?php require_once 'backend/user_functions.php';

	if(isset($_FILES['picture'])){
		$picture = '';
		if(isset($_FILES['picture']) AND $_FILES['picture']['error'] == 0) {
            $time = round(time()/100);
	        move_uploaded_file($_FILES['picture']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/img/profile/'.$time.$_FILES['picture']['name']);
    	}
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
	<body id="top" class="scrollpoint">
		<nav class="navbar navbar-default navbar-fixed-top">
	        <div class="container">
	            <div class="navbar-header page-scroll">
	                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	                    <span class="sr-only">Toggle navigation</span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                    <span class="icon-bar"></span>
	                </button>
	                <a class="navbar-brand" href="#top"><div id="brand"></div>Do This</a>
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
	                        <a href="#about">What is do this</a>
	                    </li>
	                    <li class="page-scroll">
	                        <a href="#features">Features</a>
	                    </li>
	                    <li class="page-scroll">
	                        <a href="#register">Register</a>
	                    </li>
	                    <li class="page-scroll">
	                        <a href="#contact">Contact</a>
	                    </li>
	                </ul>
                    <div id="nav-hidden" class="nav navbar-nav navbar-right">
                        <hr>
                        <form role="form" method="post">
                            <div class="form-group">
                                <?php 
                                if (!isset($_SESSION['user'])){
                                    echo ('<h1 id="login_title">Let&apos;s do this!</h1>
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
		
		<div id="to_top" class="page-scroll" style="display: none">
			<a href="#top"><div class="img-circle" id="btn-top">
				<i class="fa fa-hand-o-up fa-lg"></i><br>TOP</div>
			</a>
		</div>
		
		<div id="main">
			<form role="form" method="post">
				<div id="login_box" class="form-group centering">
                    <?php 
                    if (!isset($_SESSION['user'])){
                        if(isset($_POST['username']) AND isset($_POST['password'])) {
                        $result = login_user($_POST['username'], $_POST['password']);
                        if(is_array($result)) {
                            header('Location: dashboard.php');
                        } else {
                            echo ('<div id="login_alert" class="alert alert-danger" role="alert">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error:</span> Please check your Username and/or password!</div>');
                            false;
                        } 
                    }
                        echo ('<h1>Let&apos;s do this!</h1>
                        <input type="text" class="form-control" name="username" placeholder="Username" />
                        <input type="password" class="form-control" name="password" placeholder="Password" />
                        <button class="btn btn-default" type="submit">Login</button>');
                    } else {
                        echo ('<button id="logout" class="btn btn-default">Logout</button>
                        <h2>OR</h2>
                        <button id="to_dashboard" class="btn btn-default">Back to dashboard</button>');
                    }
                    ?>
				</div>
			</form>
		</div>
		
		<div id="about" class="container scrollpoint">
            <h1 class="main_text text-center">Let's not do that. Let's <span class="fa quote fa-quote-left"></span>do this<span class="fa quote fa-quote-right"></span>!</h1>
            <div class="block">
                <div class="centered">
                    <h1 class="text-center">Simple. Fun. Easy.</h1>
                    <h1 class="text-center">The most fun way of managing projects and tasks!</h1>
                    <h1 class="text-center">Website is still under construction.</h1>
                    <h1 class="text-center">It started as a portfolio, but planning to expand ideas into real application</h1>
                </div>
            </div>
		</div>
        
		<div id="features" class="container scrollpoint">
            <div class="block">
                <div class="centered">
                    <h1 class="text-center">In the process of coding more features for you.</h1>
                    <h1 class="text-center">Thank you for your patience.</h1>
                </div>
            </div>
        </div>
        
		<div id="register" class="container scrollpoint">
            <div class="block">
                <div class="centered">
                    <div id="choice">
                        <img class="img-responsive" alt="responsive image" src="img/logo_sm_dothis.png"/>
                        <h1 class="text-center">I know you are not yet convinced..</h1>
                        <h1 class="text-center">But the door is opened for beta trial.</h1>
                        <div id="button-container" class="text-center">
                            <button type="button" id="btn-reg" class="btn btn-danger btn-lg">REGISTER</button>
                        </div>
                    </div>
                    <div id="big-form">
                        <div id="form-section" style="display: none">
                            <h1 id="message" class="centering">Let's Do This!</h1>
                            <form method="post" class="navbar-form text-center" enctype="multipart/form-data">
                                <div class="centered">
                                    <label style="font-size: 1.5em">Profile picture</label>
                                    <input type="file" name="picture" class="centering custom-file-input">
                                    <button id="upload" type="submit" class="btn btn-default" style="display: none">upload</button>
                                </div>
                            </form>
                            <form id="reg-form" class="navbar-form text-center" method="post">
                                    <input type="text" class="form-control" id="firstname" placeholder="First name"><br>
                                    <input type="text" class="form-control" id="lastname" placeholder="Last name"><br>
                                    <input type="text" class="form-control" id="username" placeholder="Username"><br>
                                    <input type="password" class="form-control" id="password" placeholder="Password"><br>
                                    <input type="email" class="form-control" id="email" placeholder="Email"><br>

                                <button type="submit" class="btn btn-default">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
		<div id="contact" class="container scrollpoint">
            <div class="block">
                <div class="centered">
                    <h1 class="text-center" style="font-size: 4em; color: #F3C100;">Ryan Mingyu Choi</h1>
                    <h1 class="text-center">Junior full-stack web developer</h1>
                    <h1 class="text-center">HTML5, CSS3, Bootstrap, Javascript, jQuery, PHP, mySQL, Git, GitHub, Photoshop</h1>
                    <h1 class="text-center">(Currently looking for an opportunities)</h1>
                    <button id="say_hi" type="submit" class="btn btn-default" style="font-size: 3em"><i class="fa fa-comment"></i><br/>Say "Hello"</button>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div id="email-form-section">
                        <div class="modal-header">
                            <h1 id="email_message" class="centering">Say "Hello" to Ryan!</h1>
                        </div>
                        <div class="modal-body centering">
                            <div class="dash-form">
                                <form id="email-form" class="navbar-form text-center" method="post">
                                    <input type="text" class="form-control" id="email_email" placeholder="Your email"><br>
                                    <input type="text" class="form-control" id="email_subject" placeholder="Subject"><br>
                                    <textarea type="text" class="form-control" id="email_msg" placeholder="Say something"></textarea><br><hr>
                                    <button type="submit" class="btn btn-default">"HELLO"</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
		<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script>
            $(function(){
                $('#say_hi').click(function(){
                    $('#basicModal').modal({backdrop: 'static'});
                });
                
                $('#btn-reg').click(function(){
                    $('#choice').animate({
                        opacity: 0
                    }, 500, function(){
                        $('#choice').attr('style', 'display: none');
                        $('#form-section').attr('style', '');
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
                    var patt_firstname = /^[a-zA-Z]+/;
                    var patt_lastname = /^[a-zA-Z]+/;
                    var patt_username = /^[a-zA-Z0-9]{6,20}$/;
                    var patt_password = /^[a-zA-Z0-9]{6,12}$/;
                    var patt_password2 = /[A-Z]+/;
                    var patt_password3 = /[0-9]+/;
                    var patt_email = /^[a-zA-Z0-9\.]+@[a-zA-Z0-9]+\.[a-z]{2,4}$/;
                    
                    var firstname = $('#firstname').val();
                    var lastname = $('#lastname').val();
                    var username = $('#username').val();
                    var password = $('#password').val();
                    var email = $('#email').val();
                    var timestamp = Math.round(new Date().getTime() / 100000);
                    var filename = $('input[name=picture]').val().replace(/(c:\\)*fakepath\\/i, timestamp);

                    if (!patt_firstname.test(firstname)){
                        $('#message').html('Please fill out your firstname');
                        return false;
                    } else {
                        $('#message').html('Let&apos;s Do This!');
                    }
                    
                    if (!patt_lastname.test(lastname)){
                        $('#message').html('Please fill out your lastname');
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
                        'user_firstname': firstname,
                        'user_lastname': lastname,
                        'user_id': username,
                        'user_password': password,
                        'user_email': email,
                        'user_profile_pic': filename,
                    }

                    $.post('ajax/registration.php', data, 
                        function(response){
                            if (response == 1) {
                                $('#upload').trigger('click');
                                $('#big-form').html('').html('<h1>Registering YOU</h1><i class="fa fa-spinner fa-spin fa-5x"></i>').animate({
                                    opacity: 1
                                }, 2000, function(){
                                    $('#reg-form').each(function(){
                                        this.reset();
                                    });
                                    location.href="dashboard.php";
                                });
                            } else {
                                $('#message').html('Something went wrong :<');
                            }
                        }
                    );

                    return false;
                });
                
                $('#email-form').submit(function(){
                    var patt_email = /^[a-zA-Z0-9\.]+@[a-zA-Z0-9]+\.[a-z]{2,4}$/;
                    var patt_subject = /^[a-zA-Z]+/;
                    var patt_msg = /^[a-zA-Z]+/;
                    
                    var email = $('#email_email').val();
                    var subject = $('#email_subject').val();
                    var msg = $('#email_msg').val();
                    
                    if (!patt_email.test(email)){
                        $('#email_message').html('Email is invalid');
                        return false;
                    } else {
                        $('#email_message').html('Say "Hello" to Ryan!');
                    }
                    
                    if (!patt_subject.test(subject)){
                        $('#email_message').html('Please fill out the subject');
                        return false;
                    } else {
                        $('#email_message').html('Say "Hello" to Ryan!');
                    }
                    
                    if (!patt_msg.test(msg)){
                        $('#email_message').html('Please fill out the message');
                        return false;
                    } else {
                        $('#email_message').html('Say "Hello" to Ryan!');
                    }
                    
                    //AJAX call
                    var data = {
                        'email_email': email,
                        'email_subject': subject,
                        'email_msg': msg,
                    }

                    $.post('ajax/email_from_user.php', data, 
                        function(response){
                            if (response == 1) {
                                $('#email-form-section').html('').html('<div class="centering"><h1>Saying Hi to Ryan</h1><i class="fa fa-spinner fa-spin fa-5x"></i></div>').animate({
                                    opacity: 1
                                }, 2000, function(){
                                    $('#email-form').each(function(){
                                        this.reset();
                                    });
                                    location.href="dashboard.php";
                                });

                            } else {
                                $('#email_message').html('Something went wrong :<');
                            }
                        }
                    );

                    return false;
                });
                
                $('#to_dashboard').click(function(){
                    window.location.href = 'dashboard.php';
                    return false;
                });
                
                $('#logout').click(function(){
                    window.location.href = 'backend/logout.php';
                    return false;
                });
                
                $('#to_dashboard_collapse').click(function(){
                    window.location.href = 'dashboard.php';
                    return false;
                });
                
                $('#logout_collapse').click(function(){
                    window.location.href = 'backend/logout.php';
                    return false;
                });
            });
        </script>
		  

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/script.js"></script>
	</body>
</html>