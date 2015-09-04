<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<!-- show registration form, but only if we didn't submit already -->
<?php if (!$groups->addgroup_successful) { ?>
<div id="main-content">
<form method="post" action="groups.php" name="groupsform">
	<h2>Add Group</h2><br>
	<div>
    <label for="groupname">Group Name</label>
    <input id="groupname" type="text" pattern="[a-zA-Z0-9]{2,64}" name="groupname" required />
	</div><br>
	<div>
    <label for="description">Description</label>
    <input id="description" type="textarea" name="description" required />
	</div><br>
	<div>
    <input type="submit" name="addgroup" value="Add Groups" />
    </div>
</form>
</div>
<?php } ?>

<?php include('_footer.php'); ?>
