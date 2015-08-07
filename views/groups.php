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

<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Group Name</th>
                <th>Description</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
 		<tfoot>
        <tr>
                <th>Group Name</th>
                <th>Description</th>
                <th>Created Date</th>
                <th>Action</th>
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
