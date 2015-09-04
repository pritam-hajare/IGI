<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>indira Group of Institutes</title>
	<link href="libraries/css/style.css" rel="stylesheet" />
</head>
<body>
<?php include('_message.php'); ?>
<div class="page">
	<div class="container">
<!-- Left side content :: start -->
    	<div class="left-side left">
        	<div class="logo">
            	<img src="libraries/css/images/logo.png" />
            </div>
            
            <div class="main-content">
            	<p>
                	Indira College of Engineering and Management, established in 2007, is a venture of SCES. The institute is approved by All India Council of Technical Education (AICTE), New Delhi and Govt. of Maharashtra and affiliated to the University of Pune. The post globalization era in India has resulted in fast pace development activities, shaping mighty economic developments.
                </p>
            </div>
        </div>
<!-- Right side content :: start -->    
    	<div class="right-side right">
        
        	<div class="sign-in-block">
        		<form method="post" action="index.php" name="loginform">
            	<div class="login-inputs">
                	<ul>
                    	<li class="username">
                        	<input type="text" name="user_name" id="user_name" placeholder="Username" required>
                        </li>
                        <li class="user-password">
                        	<input type="password" name="user_password" id="user_password" placeholder="Password" required>
                        </li>
                    </ul>
                </div>
                
                <div class="controls">
                	<a href="password_reset.php" class="forget-password">Forget password ?</a>
                    <input type="submit" name="login" value="Sign in" class="sign-in-btn"/>
                </div>
                
                <div class="remember-me">
                	<input type="checkbox" id="user_rememberme"  name="user_rememberme"/>
                    <label for="remember-me-checkbox">Keep me logged in for 2 weeks</label>
                </div>
                </form>
                <a href="register.php" class="user-register-link">Register new account </a>
            </div>
        
        </div>
    </div>
</div>

<!-- <form method="post" action="index.php" name="loginform">
    <label for="user_name"><?php echo WORDING_USERNAME; ?></label>
    <input id="user_name" type="text" name="user_name" required />
    <label for="user_password"><?php echo WORDING_PASSWORD; ?></label>
    <input id="user_password" type="password" name="user_password" autocomplete="off" required />
    <input type="checkbox" id="user_rememberme" name="user_rememberme" value="1" />
    <label for="user_rememberme"><?php echo WORDING_REMEMBER_ME; ?></label>
    <input type="submit" name="login" value="<?php echo WORDING_LOGIN; ?>" />
</form>

 <a href="register.php"><?php echo WORDING_REGISTER_NEW_ACCOUNT; ?></a>
<a href="password_reset.php"><?php echo WORDING_FORGOT_MY_PASSWORD; ?></a> -->

<?php include('_footer.php'); ?>
