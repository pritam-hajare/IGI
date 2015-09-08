<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<!-- show registration form, but only if we didn't submit already -->
<?php $data = $Keywords->getKeywordData($keyid); 
	if (!$Keywords->editkeywords_successful) { ?>
	<div id="main-content">
	<h2>Edit Keyword</h2><br>
<form method="post" action="Keywords.php" name="groupsform">
    <div>
    <label for="keyword">Keyword</label>
    <input id="keyword" type="text" pattern="[a-zA-Z0-9]{2,64}" name="keyword" value="<?php echo $data->keywords; ?>" required />
    </div><br>
	<input type="hidden" name="keyid" id="keyid" value="<?php echo $keyid; ?>" />
	<input type="hidden" name="original_keyword" id="original_keyword" value="<?php echo $data->keywords; ?>" />
	<div>
    <input type="submit" name="editkeywords" value="Update Keyword" />
    </div>
</form>
</div>
<?php } ?>
<?php include('_footer.php'); ?>
