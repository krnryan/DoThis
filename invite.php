<?php
require_once 'backend/proj_functions.php';
require_once 'backend/user_functions.php';
require_once 'backend/invite_function.php';
    logout_session();

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
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
	        <div class="container">
	                <a class="navbar-brand" href="http://dothis.ryanmingyuchoi.com"><div id="brand"></div>Do This</a>
	        </div>
	    </nav>
        
        <div id="register" class="container scrollpoint">
            <div class="block">
                <div class="centered">
                    <div id="choice">
                        
                        <?php
                        if(isset($_POST['username']) AND isset($_POST['password'])) {
                            $result = login_user($_POST['username'], $_POST['password']);
                            if(is_array($result)) {
                                 if($_SESSION['user']['email'] == $invite_email) {
                                    add_user_proj($project_id, $_SESSION['user']['user_id']);
                                    delete_invitation($invite_id);
                                    header('Location: dashboard.php');
                                } else {
                                echo ('<div id="login_alert" class="alert alert-danger" role="alert">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <span class="sr-only">Error:</span> Email does not match!</div>');
                                    false;
                                }
                            } else {
                                echo ('<div id="login_alert" class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error:</span> Please check your Username and/or password!</div>');
                                false;
                            }
                        }
                        ?>
                        
                        <h1 class="text-center">Welcome to</h1>
                        <img class="img-responsive" alt="Responsive image" src="img/logo_sm_dothis.png"/>
                        <h1 class="text-center">You are invited to join project<br>
                                <span style="font-size: 2em"><?php echo $project_title ?></span></h1>
                        <div id="button-container" class="text-center">
                            <button type="button" id="btn-reg" class="btn btn-danger btn-lg">JOIN</button>
                        </div>
                    </div>
                    <div id="form-section">
                        <?php
                        if(unique_check(email, $invite_email) == FALSE) {
                        echo ('
                        <form id="am-reg-form" class="navbar-form text-center" style="display: none" method="post">
                            <h1 class="centering">You are about to join project<br>
                                <span style="font-size: 2em">'.$project_title.'</span></h1>
                            <h1 id="message" class="centering">We found you as a registered user!</h1>
                                <input type="text" class="form-control" name="username" placeholder="Username"><br>
                                <input type="password" class="form-control" name="password" placeholder="Password"><br>
                                <input type="email" class="form-control" id="email" placeholder="Email" value="'.$invite_email.'" readonly><br>
                            
                            <button type="submit" class="btn btn-default">LOGIN</button>
                        </form>
                        ');
                        } else {
                        echo ('
                        <div id="big-form" style="display: none">
                            <div id="form-section">
                                <h1 class="centering">You are about to join project<br>
                                    <span style="font-size: 2em">'.$project_title.'</span></h1>
                                <h1 id="message" class="centering">Let&apos;s Do This!</h1>
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
                                        <input type="email" class="form-control" id="email" value="'.$invite_email.'" readonly><br>

                                    <button type="submit" class="btn btn-default">Create</button>
                                </form>
                            </div>
                        </div>
                        ');
                        }
                        ?>
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
                        $('#big-form').attr('style', '');
                        $('#am-reg-form').attr('style', '');
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
                        'project_id': <?php echo $project_id ?>,
                        'user_profile_pic': filename,
                    }
                    
                    $.post('ajax/registration.php', data, 
                        function(response){
                            if (response == 1) {
                                $('#upload').trigger('click');
                                $('#reg-form').each(function(){
                                        this.reset();
                                });
                                $('#big-form').html('').html('<h1>Registering YOU</h1><i class="fa fa-spinner fa-spin fa-5x"></i>').animate({
                                    opacity: 1
                                }, 200, function(){
                                    var data = {
                                        'invitation_id': '<?php echo $invite_id ?>',
                                    }

                                    $.post('ajax/invitation_delete.php', data, 
                                        function(response){
                                            if (response == 1) {
                                                location.href="dashboard.php";
                                            } else {
                                                $('#message').html('Something went wrong :<');
                                            }
                                    });
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

                        <form id="reg-form" class="navbar-form text-center" style="display: none" method="post">
                            <h1 class="centering">You are about to join project<br>
                                <span style="font-size: 2em">'.$project_title.'</span></h1>
                            <h1 id="message" class="centering">Let&apos;s Do This!</h1>
                                <input type="text" class="form-control" id="firstname" placeholder="First name"><br>
                                <input type="text" class="form-control" id="lastname" placeholder="Last name"><br>
                                <input type="text" class="form-control" id="username" placeholder="Username"><br>
                                <input type="password" class="form-control" id="password" placeholder="Password"><br>
                                <input type="email" class="form-control" id="email" placeholder="Email" value="'.$invite_email.'" readonly><br>
                            <button type="submit" class="btn btn-default">JOIN</button>
                        </form>