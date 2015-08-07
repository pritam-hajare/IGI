<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
 <span>Functionality under construction :) </span>
 <a href="index.php">Back</a>

<?php include('_footer.php'); ?>