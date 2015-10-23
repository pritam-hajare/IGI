<?php

// check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once('libraries/password_compatibility_library.php');
}
// include the config
require_once('config/config.php');

// include the to-be-used language, english by default. feel free to translate your project and include something else
require_once('translations/en.php');

// include the PHPMailer library
require_once('libraries/PHPMailer.php');

// load the users class
require_once('classes/Users.php');

// so this single line handles the entire users process.
$users = new Users();
$active = 'users';
//echo '<pre>'; print_r($_POST); die();
if (isset($_GET["action"]) && $_GET["action"] == 'adduser' ) {
	// showing the user view (with the users form, and messages/errors)
	include("views/addUser.php");
}elseif(isset($_GET["action"]) && $_GET["action"] == 'editUser'){
	$user_id = $_GET["user_id"];
	include("views/editUser.php");
}else{
	include("views/users.php");
}
