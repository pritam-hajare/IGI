<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<?php $allFiles = $files->getFiles();
//echo '<pre>'; print_r($allFiles); die();
	if (!empty($allFiles)) { 
?>
<script type="text/javascript" src="libraries/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="libraries/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="libraries/css/jquery.dataTables.css"/>
<style>
	tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
<div id="main-content">
<h2>All Files</h2><br>
<table id="example" width="100%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
        <thead>
            <tr>
                <th>File</th>
                <th>Keywords</th>
                <th>Tags</th>
                <th>Caption</th>
                <th>Createdate</th>
                <th>Updateddate</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
 		<tfoot>
        <tr>
                <th>File</th>
                <th>Keywords</th>
                <th>Tags</th>
                <th>Caption</th>
                <th>Createdate</th>
                <th>Updateddate</th>
                <th>Status</th>
                <th>Action</th>
         </tr>
 		</tfoot>
        <tbody>
        <?php foreach ($allFiles as $K=>$v){
        		$fileid = $v['fileid']; 
        		$date = date_create($v['createdate']);
        		$fileDate = date_format($date, 'd-m-Y');
        		$filePath = $v['filepath'].'/'.$fileDate.'/'.$fileid.'_'.$v['filename'];
        		$filePath = str_replace('\\', '/', $filePath);
        	?>
            <tr>
                <td><img src="<?php echo $filePath; ?>" alt="<?php echo $v['filename']; ?>" height="50" width="50" /><br><?php echo $v['filename']?></td>
                <td><?php echo $v['keywords']; ?></td>
                <td><?php echo $v['tags']; ?></td>
                <td><?php echo $v['caption']; ?></td>
                <td><?php echo $v['createdate'];?></td>
                <td><?php echo $v['updatedate'];?></td>
                <td><?php echo $v['active'] ? 'Yes' : 'No'; ?></td>
                <td><a href="<?php echo "users.php?action=editUser&user_id=$fileid"; ?>" target="_blank" /> Edit</a></td>
            </tr>
         <?php }?>   
        </tbody>
    </table></div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $('#example thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            that
                .search( this.value )
                .draw();
        } );
    } );
} );
</script>

    <a href="index.php">Back</a>

<?php include('_footer.php'); ?>
