<?php include('_header.php'); ?>

<!-- show registration form, but only if we didn't submit already -->
<script type="text/javascript" src="libraries/js/jquery.js"></script>
<script type="text/javascript" src="libraries/js/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="libraries/css/jquery.autocomplete.css"/>
<script type="text/javascript" >
$(document).ready(function(){
	 $("#keywords").autocomplete("libraries/keywords.php", {
			selectFirst: true
		});
	});
</script>
<?php if (!$uploadFile->uploadfile_successful) { ?>
<form method="post" action="uploadFile.php" name="uploadfileform" enctype="multipart/form-data">
    <label for="igifile">Upload</label>
    <input type="file" name="igifile" /></br></br>

    <label for="keywords">Keywords</label>
    <input id="keywords" type="text" name="keywords" id="keywords" />

    <label for="caption">Caption</label>
    <input type="text" name="caption" id="caption" />

    <label for="tags">Tags</label>
    <input id="tags" type="text" name="tags"/>

    <input type="submit" name="uploadfile" value="Upload" />
</form>
<?php } ?>

    <a href="index.php">Back</a>

<?php include('_footer.php'); ?>
