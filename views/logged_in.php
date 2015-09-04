<?php include('_header.php'); ?>

<?php
// if you need the user's information, just put them into the $_SESSION variable and output them here
//echo WORDING_YOU_ARE_LOGGED_IN_AS . $_SESSION['user_name'] . "<br />";
//echo WORDING_PROFILE_PICTURE . '<br/><img src="' . $login->user_gravatar_image_url . '" />;
//echo WORDING_PROFILE_PICTURE . '<br/>' . $login->user_gravatar_image_tag;
?>
            <div class="main-content">
            	<div>
            	<p>
                	Indira College of Engineering and Management, established in 2007, is a venture of SCES. The institute is approved by All India Council of Technical Education (AICTE), New Delhi and Govt. of Maharashtra and affiliated to the University of Pune. The post globalization era in India has resulted in fast pace development activities, shaping mighty economic developments.
                </p>
                </div>
            </div>

<!--div>
    <a href="index.php?logout"><?php echo WORDING_LOGOUT; ?></a><br>
    <a href="edit.php"><?php echo WORDING_EDIT_USER_DATA; ?></a><br>
    <?php if( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'] ){?>
    <a href="users.php">Users</a><br>
    <a href="groups.php">Groups</a><br>
    <a href="groups.php?action=addGroup">Add Groups</a><br>
    <a href="users.php?action=adduser">Add User</a><br>
	<a href="keywords.php?action=addKeywords">Add Keywords</a><br>
	<a href="keywords.php">Keywords</a><br>
	<a href="files.php">Files</a><br>
	<a href="files.php?action=uploadFile">Upload File</a>
    <?php }?>
</div-->

<?php include('_footer.php'); ?>
