<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Indira Group of Institutes</title>

<link href="libraries/css/style.css" rel="stylesheet" />
</head>

<body class="dashboard-page">
<div class="page">
<!-- header :: start -->
	<div class="header">
        <div class="logo left">
            <img src="libraries/css/images/logo.png" />
        </div>
        
        <div class="user-info right">
        	<div class="user-name left">
            	<span>Hello!</span>
                <span class="username"><a href="edit.php"><?php echo $_SESSION['user_fullname']?></a><br></span>
            </div>
            
            <div class="user-avatar right">
            	<img src="libraries/css/images/avatar.png" />
            </div>
            <a href="index.php?logout" class="log-out">Log out</a>
        </div>
    </div>
<!-- header :: End -->
	<div class="container">
    	<div class="container-inner">
		<?php include('_leftNav.php'); ?>
