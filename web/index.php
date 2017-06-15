<?php

    session_start();

	$errStringRegister = "";
	$errStringLogin = "";

    if(isset($_SESSION['id']))
    {
        header("Location: chat.php");
    }
    else if(isset($_POST['submitLogin']))
    {
		include "../src/login.php";
		$password = "";

		$password = getCorrectInput($_POST["password"]);
		$salt = sha1(md5($password));
		$password = md5($salt.$password);

		$fields = array("username"=>$_POST['username'],"pass"=>$password);
		$result = login($fields);

		if($result)
		{
			$_SESSION['id'] = $result[0]['uid'];

			header("Location: chat.php");
		}
		else
			$errStringLogin = "* Invalid credentials";
    }

    else if(isset($_POST['submitRegister']))
    {
		$passwordSignUp = $passwordSignUp_confirm = "";
		$usernameSignUp = $emailSignUp = "";
		$usernameSignUp = getCorrectInput($_POST["usernameSignUp"]);
		$emailSignUp = getCorrectInput($_POST["emailSignUp"]);

		$passwordSignUp = getCorrectInput($_POST["passwordSignUp"]);
		$salt = sha1(md5($passwordSignUp));
		$passwordSignUp = md5($salt.$passwordSignUp);
		$passwordSignUp_confirm = getCorrectInput($_POST["passwordSignUp_confirm"]);
		$salt = sha1(md5($passwordSignUp_confirm));
		$passwordSignUp_confirm = md5($salt.$passwordSignUp_confirm);

		if($passwordSignUp != $passwordSignUp_confirm)
		{
			$errStringRegister = "* Passwords do not match!";
		}
		else
		{
			include "../src/register.php";

			/*associative array with keys as the column name of table and their values as the values inserted by the user in the registration form*/
			$fields = array("username"=>$usernameSignUp,"email"=>$emailSignUp,"pass"=>$passwordSignUp);
 			$result = register($fields);
			if($result === true)
			{
				header("Location: index.php#tologin");
			}
			else if($result === false)
			{
				$errStringRegister = "* This username already exists";
			}
		}

  }

  function getCorrectInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>

<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Envoy</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Login and Registration Form" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />

      	<link rel="shortcut icon" type="image/png" href="images/Envoy.png"/>

        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style3.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
		<style>
			.error {color: #FF0000;}
			body{
					background-color:#d2d2d2 !important;
			}

		</style>
    </head>

    <body >
        <div class="container">

          <div id="particles-js" style="height:100%; width:100%; position:fixed;">
            <script src="js/particles.min.js"></script>
              <script src="js/app.js"></script>
            </div>

            <!-- Codrops top bar -->
            <div class="codrops-top">
                <div class="clr"></div>
            </div><!--/ Codrops top bar -->
            <header>
                <h1> <span>Envoy!</span></h1>
            </header>
            <section>
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  action="" method="post" autocomplete="on">
                                <h1>Log in</h1>
                                <p>
                                    <label for="username" class="uname" data-icon="u" > Username </label>
                                    <input id="username" name="username" required="required" type="text" placeholder="Enter your Username"/>
                                </p>
                                <p>
                                    <label for="password" class="youpasswd" data-icon="p"> Password </label>
                                    <input id="password" name="password" required="required" type="password" placeholder="Password" />
									<span class="error" id="passErrorHolder"><?php echo $errStringLogin;?></span>
                                </p>

                                <p class="login button">
                                    <input name="submitLogin" type="submit" value="Login" />
								</p>
                                <p class="change_link">
									Not Registered yet ?
									<a href="#toregister" class="to_register">Register here</a>
								</p>
                            </form>
                        </div>

                        <div id="register" class="animate form">
                          <p><span class="error"></span></p>
                            <form  action=""  method="post">
                                <h1> Sign up </h1>
                                <p>
                                    <label for="usernameSignUp" class="uname" data-icon="u"> Username</label>
                                    <input id="usernameSignUp" name="usernameSignUp" required="required" type="text" placeholder="Enter your username" />
                                </p>
                                <p>
                                    <label for="emailSignUp" class="youmail" data-icon="e" > Email</label>
                                    <input id="emailSignUp" name="emailSignUp" required="required" type="email" placeholder="Enter your mail Id"/>
                                </p>
                                <p>
                                    <label for="passwordSignUp" class="youpasswd" data-icon="p"> Password </label>
                                    <input id="passwordSignUp" name="passwordSignUp" required="required" type="password" placeholder="Password"/>
                                </p>
                                <p>
                                    <label for="passwordSignUp_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="passwordSignUp_confirm" name="passwordSignUp_confirm" required="required" type="password" placeholder="Password"/>
									<span class = "error" id="passErrorHolder"><?php echo $errStringRegister;?></span>
                                </p>

                                <p class="signin button">
									<input name="submitRegister" type="submit" value="Sign up"/>
								</p>
                                <p class="change_link">
									Already a member ?
									<a href="#tologin" class="to_register"> Log in </a>
								</p>
                            </form>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </body>
</html>
