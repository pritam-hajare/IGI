<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<!-- show registration form, but only if we didn't submit already -->
<?php $data = $groups->getGroupData($groupid);  
	if (!$groups->editgroup_successful) { ?>
<form method="post" action="groups.php" name="groupsform">
    <label for="groupname">Group Name</label>
    <input id="groupname" type="text" pattern="[a-zA-Z0-9]{2,64}" name="groupname" value="<?php echo $data->groupname; ?>" required />

    <label for="description">Description</label>
    <input id="description" type="textarea" name="description" value="<?php echo $data->description?>" required />
	<input type="hidden" name="groupid" id="groupid" value="<?php echo $groupid; ?>" />
	<input type="hidden" name="original_groupname" id="original_groupname" value="<?php echo $data->groupname; ?>" />
    <input type="submit" name="editgroup" value="Update Group" />
</form>
<?php } ?>

    <a href="index.php">Back</a>

<?php include('_footer.php'); ?>