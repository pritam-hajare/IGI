<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<?php $allGroups = $groups->getGroups();
	if (!empty($allGroups)) { 
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
<h2>Groups</h2><br>
<table id="example" width="100%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
        <thead>
            <tr>
                <th scope="col">Group Name</th>
                <th scope="col">Description</th>
                <th scope="col">Created Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
 		<tfoot>
        <tr>
                <th scope="col">Group Name</th>
                <th scope="col">Description</th>
                <th scope="col">Created Date</th>
                <th scope="col">Action</th>
         </tr>
 		</tfoot>
        <tbody>
        <?php foreach ($allGroups as $K=>$v){ $groupid = $v['groupid']; ?>
            <tr>
                <td><?php echo $v['groupname']; ?></td>
                <td><?php echo $v['description']; ?></td>
                <td><?php echo $v['createdate']; ?></td>
                <td><a href="<?php echo "groups.php?action=editGroup&groupid=$groupid"; ?>" target="_blank" /> Edit</a></td>
            </tr>
         <?php }?>   
        </tbody>
    </table>
</div>
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

<?php include('_footer.php'); ?>
