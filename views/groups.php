<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<!-- show registration form, but only if we didn't submit already -->
<?php if (!$groups->addgroup_successful) { ?>
<form method="post" action="groups.php" name="groupsform">
    <label for="groupname">Group Name</label>
    <input id="groupname" type="text" pattern="[a-zA-Z0-9]{2,64}" name="groupname" required />

    <label for="description">Description</label>
    <input id="description" type="textarea" name="description" required />

    <input type="submit" name="groups" value="Add Groups" />
</form>
<?php } ?>

    <a href="index.php">Back</a>

<?php include('_footer.php'); ?>
