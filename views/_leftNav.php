<script type="text/javascript" src="libraries/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//$('ul ul').hide();
		//$('ul li a').click(function() {
		   // $('ul ul').hide('slow');
	        //$(this).parent().find('ul').toggle('slow');
		//});
	});
</script>
<div id="left-panel">
        	<div class="left-navigation">
            	<ul>
                	<li <?php if (isset($active) && $active == 'manage_groups') { ?> class="active" <?php } else { ?> class="" <?php } ?> ><a href="#"><span class="icons"><img src="libraries/css/images/institute-icon.png"/></span>Manage Groups <span class="expand-menu">+</span></a>
                    	<ul>
                        	<li><a href="groups.php">Groups</a></li>
                            <li><a href="groups.php?action=addGroup">Add Group</a></li>
                        </ul>
                    </li>
                    <li <?php if (isset($active) && $active == 'users') { ?> class="active" <?php } else { ?> class="" <?php } ?> ><a href="#"><span class="icons"><img src="libraries/css/images/user-icon.png"/></span>Manage Users <span class="expand-menu">+</span></a>
                    	<ul>
                        	<li><a href="users.php">Users</a></li>
                            <li><a href="users.php?action=adduser">Add User</a></li>
                        </ul>
                    </li>
                    <li <?php if (isset($active) && $active == 'files') { ?> class="active" <?php } else { ?> class="" <?php } ?> ><a href="#"><span class="icons"><img src="libraries/css/images/document-icon.png"/></span>Manage Document <span class="expand-menu">+</span></a>
                    	<ul>
                        	<li><a href="files.php">Files</a></li>
                            <li><a href="files.php?action=uploadFile">Upload File</a></li>
                        </ul>
                    </li>
                    <li <?php if (isset($active) && $active == 'keywords') { ?> class="active" <?php } else { ?> class="" <?php } ?>><a href="#"><span class="icons"></span>Manage Keywords <span class="expand-menu">+</span></a>
                    	<ul>
                        	<li><a href="keywords.php">Keywords</a></li>
                            <li><a href="keywords.php?action=addKeywords">Add Keywords</a></li>
                        </ul>
                    </li>
                    <!--  <li><a href="#"><span class="icons"></span>Manage Instistute <span class="expand-menu">+</span></a></li> -->
                </ul>
            </div>
        </div>