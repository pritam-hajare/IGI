<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<?php $allUsers = $users->getUsers();
	if (!empty($users)) { 
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
                <th>User Name</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Is Moderator</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
 		<tfoot>
        <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Is Moderator</th>
                <th>Status</th>
                <th>Action</th>
         </tr>
 		</tfoot>
        <tbody>
        <?php foreach ($allUsers as $K=>$v){ $user_id = $v['user_id']; ?>
            <tr>
                <td><?php echo $v['user_name']; ?></td>
                <td><?php echo $v['user_email']; ?></td>
                <td><?php echo $v['user_firstname']; ?></td>
                <td><?php echo $v['user_lastname']; ?></td>
                <td><?php echo $v['is_moderator'] ? 'Yes' : 'No'; ?></td>
                <td><?php echo $v['user_active'] ? 'Yes' : 'No'; ?></td>
                <td><a href="<?php echo "users.php?action=editUser&user_id=$user_id"; ?>" target="_blank" /> Edit</a></td>
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
