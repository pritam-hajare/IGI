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
            		<span>
                	Welcome to Archival and Retrieval System of Indira Group of Institutes. Here, a simple and an advance search, based on Keywords and Tags may lead you to a desired visual content. To archive new photographs or any visual content, please follow norms set for the system. Systematically archived visual content is the key to the success of this system.
                	</span>
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
