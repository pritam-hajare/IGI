<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<!-- show registration form, but only if we didn't submit already -->
<?php if (!$Keywords->addkeywords_successful) { ?>
<div id="main-content">
<form method="post" action="keywords.php" name="groupsform">
	<h2>Add Keywords</h2><br>
	<div>
    <label for="keyword">Keyword</label>
    <input id="keyword" type="text" pattern="[a-zA-Z0-9]{2,64}" name="keyword" required />
	</div><br>
	<div>
    <input type="submit" name="addkeywords" value="Add Keyword" />
    </div>
</form>
</div>
<?php } ?>
<?php include('_footer.php'); ?>
