<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<!-- show registration form, but only if we didn't submit already -->
<?php if (!$Keywords->addkeywords_successful) { ?>
<form method="post" action="Keywords.php" name="groupsform">
    <label for="keyword">Keyword</label>
    <input id="keyword" type="text" pattern="[a-zA-Z0-9]{2,64}" name="keyword" required />

    <input type="submit" name="Keyword" value="Add Keyword" />
</form>
<?php } ?>

    <a href="index.php">Back</a>

<?php include('_footer.php'); ?>
