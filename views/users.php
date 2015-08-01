<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<!-- show user form, but only if we didn't submit already -->
<?php if (!$users->adduser_successful) { ?>
<form method="post" action="users.php" name="usersform">
	<label for="groupid">Groups</label>
	<select name="groupid">
  		<?php echo implode("\n", $users->getGroups()); ?>
	</select>
	<br><br>
    <label for="user_name">Username</label>
    <input id="user_name" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
	<br>
	<label for="user_firstname">First Name</label>
    <input id="user_firstname" type="text" name="user_firstname" required />
	<br>
	<label for="user_lastname">Last Name</label>
    <input id="user_lastname" type="text"  name="user_lastname" required />
	<br>
	<label for="user_mobile">Mobile</label>
    <input id="user_mobile" type="text" pattern="[0-9]{1,10}"  name="user_mobile" required />
	<br>
    <label for="user_email"><?php echo WORDING_REGISTRATION_EMAIL; ?></label>
    <input id="user_email" type="email" name="user_email" required />

    <label for="user_password_new"><?php echo WORDING_REGISTRATION_PASSWORD; ?></label>
    <input id="user_password_new" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

    <label for="user_password_repeat"><?php echo WORDING_REGISTRATION_PASSWORD_REPEAT; ?></label>
    <input id="user_password_repeat" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />

    <label>Moderator</label>
	<input type="checkbox" name="is_moderator" value="1" />
	<br>

    <input type="submit" name="addusers" value="Add User" />
</form>
<?php } ?>

    <a href="index.php">Back</a>

<?php include('_footer.php'); ?>