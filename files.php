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
require_once('classes/Files.php');

// so this single line handles the entire users process.
$files = new Files();
$active = 'files';
if (isset($_GET["action"]) && $_GET["action"] == 'uploadFile' ) {
	// showing the user view (with the users form, and messages/errors)
	include("views/uploadFile.php");
}elseif (isset($_POST['type']) && $_POST['type'] == 'inline_edit_files') {
	$data = $_POST;
    if($files->uploadFileRecord($data)){
    	exit('success');
    }else{
    	exit('error');
    }
}elseif(isset($_GET["action"]) && $_GET["action"] == 'listFiles'){
	include("views/filesList.php");
}else{
	include("views/files.php");
}