<?php include('_header.php'); ?>
<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
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
<h2>Users</h2><br>
<table id="example" width="100%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
        <thead>
            <tr>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Is Moderator</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
 		<tfoot>
        <tr>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Is Moderator</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
         </tr>
 		</tfoot>
        <tbody>
        <?php $allUsers = $users->getUsers();
			if (!empty($allUsers)) { 
		?>
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
         <?php } ?>   
        </tbody>
    </table>
</div>
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

   <!-- <a href="index.php">Back</a> -->

<?php include('_footer.php'); ?>
