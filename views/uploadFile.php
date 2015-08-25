<?php include('_header.php'); ?>
<?php if (!$uploadFile->uploadfile_successful) { ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <style>
  .ui-autocomplete-loading {
    background: white url("libraries/images/ui-anim_basic_16x16.gif") right center no-repeat;
  }
  </style>
    <script>
  $(function() {
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
 
    $( "#keywords" )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
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
  </script>
<form method="post" action="uploadFile.php" name="uploadfileform" enctype="multipart/form-data">
    <label for="igifile">Upload</label>
    <input type="file" name="igifile" /></br></br>
	<div class="ui-widget">
    <label for="keywords">Keywords</label>
    <input id="keywords" type="text" name="keywords"  />
	</div>
    <label for="caption">Caption</label>
    <input type="text" name="caption" id="caption" />

    <label for="tags">Tags</label>
    <input id="tags" type="text" name="tags"/>
    <input type="submit" name="uploadfile" value="Upload" />
</form>

<!--  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> 
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script> 
<script src="libraries/js/jquery.autocomplete.multiselect.js"></script> 
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"/>
<script type="text/javascript" >
$(document).ready(function(){
	 $("#keyword").autocomplete({
		 source : function( request, response ) {
			    $.ajax({
			        url: "libraries/keywords.php",
			        data: {q: request.term},
			        dataType: "json",
			        success: function( data ) {
			        	response(data);
			        }
			    });
			},
			multiselect: true,
			select: function(event, ui) { 
		        $("#keywords").val(ui.item.id) 
		    }
		});
	});
</script> -->
<?php } ?>

    <a href="index.php">Back</a>

<?php include('_footer.php'); ?>
