<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<!-- show registration form, but only if we didn't submit already -->
<?php $data = $groups->getGroupData($groupid);  
	if (!$groups->editgroup_successful) { ?>

	<div id="main-content">
	<h2>Edit Group</h2><br>
	<form method="post" action="groups.php" name="groupsform">
	<div>
    <label for="groupname">Group Name</label>
    <input id="groupname" type="text" pattern="[a-zA-Z0-9]{2,64}" name="groupname" value="<?php echo $data->groupname; ?>" required />
	</div><br>
	<div>
    <label for="description">Description</label>
    <textarea id="description" name="description" required ><?php echo $data->description?></textarea>
	</div><br>
	<input type="hidden" name="groupid" id="groupid" value="<?php echo $groupid; ?>" />
	<input type="hidden" name="original_groupname" id="original_groupname" value="<?php echo $data->groupname; ?>" />
    <div>
    <input type="submit" name="editgroup" value="Update Group" />
    </div><br>
	</form>
	</div>
<?php } ?>
<?php include('_footer.php'); ?>