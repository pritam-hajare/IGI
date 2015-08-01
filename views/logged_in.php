<?php include('_header.php'); ?>

<?php
// if you need the user's information, just put them into the $_SESSION variable and output them here
echo WORDING_YOU_ARE_LOGGED_IN_AS . $_SESSION['user_name'] . "<br />";
//echo WORDING_PROFILE_PICTURE . '<br/><img src="' . $login->user_gravatar_image_url . '" />;
//echo WORDING_PROFILE_PICTURE . '<br/>' . $login->user_gravatar_image_tag;
?>

<div>
    <a href="index.php?logout"><?php echo WORDING_LOGOUT; ?></a><br>
    <a href="edit.php"><?php echo WORDING_EDIT_USER_DATA; ?></a><br>
    <?php if( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'] ){?>
    <a href="groups.php">Add Groups</a><br>
    <a href="users.php">Add User</a><br>
	<a href="keywords.php">Add Keywords</a><br>
    <?php }?>
</div>

<?php include('_footer.php'); ?>
