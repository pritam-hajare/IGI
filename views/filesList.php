<?php if(!( $_SESSION['is_admin'] ||  $_SESSION['is_moderator'])){
	echo 'You are not authorised to access this page.';exit;
}?>
<?php $allFiles = $files->getFiles();
//echo '<pre>'; print_r($allFiles); die();
	if (!empty($allFiles)) { 
?>
<table id="example" width="100%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
        <thead>
            <tr>
                <th>File</th>
                <th>Keywords</th>
                <th>Tags</th>
                <th>Caption</th>
                <th>Year</th>
                <th>Month</th>
                <th>Day</th>
                <!-- <th>Create date</th>
                <th>Updated date</th> -->
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
                <th>Year</th>
                <th>Month</th>
                <th>Day</th>
                 <!-- <th>Created date</th>
                <th>Updated date</th> -->
                <th>Status</th>
                <th>Action</th>
         </tr>
 		</tfoot>
        <tbody>
        <?php foreach ($allFiles as $K=>$v){
        		$fileid = $v['fileid']; 
        		$date = date_create($v['createdate']);
        		$fileDate = date_format($date, 'd-m-Y');
        		//$filePath = '\\'.$v['filepath'].'\\'.$fileDate.'\\'.$fileid.'_'.$v['filename'];
        		//$filePath = str_replace('/', '\\', $filePath);
				$filePath = '/'.$v['filepath'].'/'.$fileDate.'/'.$fileid.'_'.$v['filename'];
				$filePath = str_replace('\\', '/', $filePath);
        	?>
            <tr>
                <td iseditable="false"><a href="download.php?fileid=<?php echo $fileid ;?>" ><img src="thumb.php?src=<?php echo $filePath; ?>" alt="<?php echo $v['filename']; ?>" height="100" width="100" /></a><!-- <br><?php echo $v['filename']?> --></td>
                <td iseditable="true" inputname="keywords" inputtype="text"><?php echo $v['keywords']; ?></td>
                <td iseditable="true" inputname="tags" inputtype="text"><?php echo $v['tags']; ?></td>
                <td iseditable="true" inputname="caption" inputtype="text"><?php echo $v['caption']; ?></td>
                <td iseditable="true" inputname="year" inputtype="text"><?php echo $v['year']; ?></td>
                <td iseditable="true" inputname="month" inputtype="text"><?php echo $v['month']; ?></td>
                <td iseditable="true" inputname="day" inputtype="text"><?php echo $v['day']; ?></td>
                <!-- <td><?php echo date('d-m-Y', strtotime($v['createdate'])); ?></td>
                <td><?php echo !empty($v['updatedate']) ?  date('d-m-Y', strtotime($v['updatedate'])) : ''; ?></td> -->
                <td iseditable="true" inputname="active" inputtype="checkbox" status="<?php echo $v['active'] ? 'checked' : ''; ?>"><?php echo $v['active'] ? 'Yes' : 'No'; ?></td>
                <td><a class="editInline" href="javascript:void(0)" style="display: inline;" > Edit</a><a fileid="<?php echo $fileid; ?>" class="saveInline editStakeholder" onclick="_editFiles(this);" href="javascript:void(0)" style="display: none;">Save</a></td>
            </tr>
         <?php }?>   
        </tbody>
    </table>
<?php } ?>
<script type="text/javascript">
function editRow(row) {
    $('td:not(:last-child)',row).each(function() {
        if($.trim($(this).attr("isEditable")) == 'true'){
            if($(this).attr("inputType") == 'select'){
               // $(this).html('<select name='+$(this).attr("inputName")+' id='+$(this).attr("inputName")+'><option>'+$(this).html()+'</option></select>');
                var option = '<option value="">Select</option>';
                var selectedOption = $.trim($(this).html());
                var select = $('<select name='+$(this).attr("inputName")+' id='+$(this).attr("inputName")+'><option label="--Select--" value="0">--Select--</option></select>');
                var selectElement = $(this);
                $.ajax({
                    type: "POST",
                    async: false,
                    url: $(this).attr("selectOptions"),
                    dataType: "json",
                    success: function(data){
                        /*specific condition for account dropdown*/
                        if($.trim(selectElement.attr("inputName")) == 'accounts'){
                            $.each(data, function(key, value){
                                var group = $('<optgroup label="' + key + '" />');
                                $.each(value, function(k, v){
                                    if( selectedOption == $.trim(v)){
                                        $('<option label="'+v+'" value="'+k+'" selected />').html(v).appendTo(group);
                                    }else{
                                        $('<option label="'+v+'" value="'+k+'" />').html(v).appendTo(group);
                                    }
                                });
                                group.appendTo(select);
                            });
                            selectElement.html(select);
                        }else{
                            $.each(data, function(key, value) {
                                if( selectedOption == $.trim(value)){
                                    option = option+'<option value ='+key+' selected>'+value+'</option>';
                                }else{
                                    option = option+'<option value ='+key+' >'+value+'</option>';
                                }
                                 
                            });
                            selectElement.html('<select name='+selectElement.attr("inputName")+' id='+selectElement.attr("inputName")+'>'+option+'</select>');
                        }
                    }
                });
                
            }else if($(this).attr("inputType") == 'textarea'){
                $(this).html('<textarea name='+$(this).attr("inputName")+'  id='+$(this).attr("inputName")+'>'+ $.trim($(this).html()) + '</textarea>');
            }else if($(this).attr("inputType") == 'checkbox'){
                $(this).html('<input type="checkbox" name='+$(this).attr("inputName")+'  id='+$(this).attr("inputName")+' value="' + $.trim($(this).html()) + '" '+$(this).attr("status")+'/>');
            }else{
                $(this).html('<input type="text" size="10" name='+$(this).attr("inputName")+'  id='+$(this).attr("inputName")+' value="' + $.trim($(this).html()) + '"  class="'+$(this).attr("inputName")+'"/>');
            }
        }
    });
}

function saveRow(row) {
    row.find(".editInline").show();
    row.find(".saveInline").hide();
    $('td:not(:last-child)',row).each(function() {
         if($(this).find('select').length){
            if($(this).find('select').find(':selected').val() == 0 || $(this).find('select').find(':selected').val() == ''){
                $(this).html('');
            }else{
                $(this).html($(this).find('select').find(':selected').text());
            }
         }else if($(this).find('textarea').length){
            $(this).html($(this).find('textarea').val());
         }else if($(this).find('input[type=checkbox]').length){
            $(this).html($(this).find('input[type=checkbox]').prop("checked") == true ? 'Yes' : 'No');
         }else{
            $(this).html($(this).find('input').val());
         }
    });
}

function  _editFiles(row, type) {
	data = {};
    data['cache'] = 'false';
    data['type'] = 'inline_edit_files';
    data['fileid'] = $(row).attr('fileid');
    $('td:not(:last-child)',$(row).closest('tr')).each(function() {
        if($(this).find('select').length){
            data[$(this).find('select').attr('name')] = $(this).find('select').val();
        }else if($(this).find('input[type=text]').length){
            data[$(this).find('input').attr('name')] = $(this).find('input').val();
        }else if($(this).find('input[type=checkbox]').length){
            data[$(this).find('input').attr('name')] = $(this).find('input').prop("checked") == true ? 'Yes' : 'No';
        }
    });
    //console.log(data);
    $.post('files.php', data, function(resp){
        if ($.trim(resp) == 'error'){
            alert('Something went wrong, Please try again.');
            return false;
        }else if ($.trim(resp) == 'success'){
            alert('File updated successfully!!!');
            $('#allFiles').load('files.php?action=listFiles');
            saveRow($(row).closest('tr'));
        }
    });
}

function split( val ) {
    return val.split( /,\s*/ );
  }
  
function extractLast( term ) {
    return split( term ).pop();
  }
  
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $('#example thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" size="10" placeholder="Search '+title+'" />' );
    } );

    $('#example thead th').each( function () {
        var title = $('#example thead th').eq( $(this).index() ).text();
        $(this).html( title+'<br><input type="text" size="10" placeholder="Search '+title+'" />' );
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

        $( 'input', this.header() ).on( 'keyup change', function () {
            that
                .search( this.value )
                .draw();
        } );
    } );

    $(".saveInline").hide();
    $(".editInline").on('click', function() {
        $(this).closest('tr').find(".editInline").hide();
        $(this).closest('tr').find(".saveInline").show();
        editRow($(this).closest('tr'));
    });
} );

$(document).on('keydown.autocomplete', ".keywords", function() {
    $(this).autocomplete({
          source: function( request, response ) {
            $.getJSON( "libraries/keywords.php", {
          	  term: extractLast( request.term )
            }, response );
          },
          search: function() {
            // custom minLength
            var term = extractLast( this.value );
            if ( term.length < 2 ) {
              return false;
            }
          },
          focus: function() {
            // prevent value inserted on focus
            return false;
          },
          select: function( event, ui ) {
            var terms = split( this.value );
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( ", " );
            return false;
          }
        });
});
var availableTags = [
                     "January",
                     "February",
                     "March",
                     "April",
                     "May",
                     "June",
                     "July",
                     "August",
                     "September",
                     "October",
                     "November",
                     "Dec"
                   ];
$(document).on('keydown.autocomplete', ".month", function() {
    $(this).autocomplete({
          source: availableTags
        });
});

$('#example').on('draw.dt', function() {
	 $(".saveInline").hide();
	 $(".editInline").on('click', function() {
	     $(this).closest('tr').find(".editInline").hide();
	     $(this).closest('tr').find(".saveInline").show();
	     editRow($(this).closest('tr'));
	 });
});
</script>