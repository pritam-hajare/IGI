<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<!-- show user form, but only if we didn't submit already -->
<?php $data = $users->getUserData($user_id);  
	if (!$users->edituser_successful) { ?>
	<div id="main-content">
	<h2>Edit Group</h2><br>
<form method="post" action="users.php" name="usersform">
	<div>
	<label for="groupid">Groups</label>
	<select name="groupid">
  		<?php echo implode("\n", $users->getGroups($data->groupid)); ?>
	</select>
	</div><br>
	<div>
    <label for="user_name">Username:</label>
    <span><b><?php echo $data->user_name; ?></b></span>
	</div><br>
	<div>
	<label for="user_firstname">First Name</label>
    <input id="user_firstname" type="text" name="user_firstname" value="<?php echo $data->user_firstname; ?>" required />
	</div><br>
	<div>
	<label for="user_lastname">Last Name</label>
    <input id="user_lastname" type="text"  name="user_lastname" value="<?php echo $data->user_firstname; ?>" required />
	</div><br>
	<div>
	<label for="user_mobile">Mobile</label>
    <input id="user_mobile" type="text" pattern="[0-9]{1,10}"  name="user_mobile" value="<?php echo $data->user_mobile; ?>" required />
	</div><br>
	<div>
    <label for="user_email">Email</label>
    <input id="user_email" type="email" name="user_email" value="<?php echo $data->user_email; ?>" required />
	</div><br>
    <!--  <label for="user_password_new"><?php echo WORDING_REGISTRATION_PASSWORD; ?></label>
    <input id="user_password_new" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

    <label for="user_password_repeat"><?php echo WORDING_REGISTRATION_PASSWORD_REPEAT; ?></label>
    <input id="user_password_repeat" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" /> -->
	<div>
    <label>Moderator</label>
	<input type="checkbox" name="is_moderator" value="1" <?php echo ($data->is_moderator) ? 'checked' : '' ?> />
	</div><br>
	<div>
	<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
    <input type="submit" name="edituser" value="Update User" />
    </div>
</form>
</div>
<?php } ?>

<?php include('_footer.php'); ?>
