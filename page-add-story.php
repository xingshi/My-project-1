<?php
/**
 * Template Name: Create Stories
 */
	get_header(); 
	global $current_user;
    $response_err = '';
    
	if($current_user->ID > 0){
		if ( isset( $_POST['submitted'] ) && isset( $_POST['post_nonce_field'] ) ) {
 			if(wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce' )){
    			if ( trim( $_POST['storyName'] ) != '' && trim( $_POST['storyContent'] ) != '' ) {
    				$story_information = array(
    			    	'post_title' => wp_strip_all_tags( $_POST['storyName'] ),
    			    	'post_content' => $_POST['storyContent'],
    			    	'post_type' => 'story',
    			    	'post_status' => 'publish',
    			    	'post_author' => $current_user->ID,
                        'post_category' => array($_POST['storyCat']),
                        'tags_input' => explode(",", $_POST['storyTag']),
    			    	'comment_status' => 'open'
    				);
			
    				$status = wp_insert_post( $story_information );
    			}else{
                    $response_err = "You should not submit an empty story!";
                }
    		}
		}
	}
?>
    <div class="container padding-container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 page-header">
                <h2><?php echo $post->post_title; ?></h2>
            </div>
        </div>
        <?php if($current_user->ID > 0){ ?>
        <?php 
        	if( isset($status) && is_wp_error($status) ){	  		
        	echo '<div class="row">';
                echo '<div class="alert alert-danger fade in col-lg-12 col-md-12 col-sm-12">';
                  	echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                  	echo '<strong>Oops!</strong> You have errors.'.'<br />';
                  	foreach( $status->errors as $key=>$val ){
	 					foreach( $val as $k=>$v ){
	 						echo '<p class="error">'.$v.'</p>';
	 					}
	 				}
                echo '</div>';
            echo '</div>';
	 			
	 		}else if($response_err != ''){
                echo '<div class="row">';
                echo '<div class="alert alert-danger fade in col-lg-12 col-md-12 col-sm-12">';
                    echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                    echo '<strong>Oops!</strong> '.$response_err.'<br />';
                echo '</div>';
            echo '</div>';
            }else if ( isset( $_POST['submitted'] ) && isset( $_POST['post_nonce_field'] ) ){
	 			echo '<div class="row">';
                	echo '<div class="alert alert-success fade in col-lg-12 col-md-12 col-sm-12">';
                  		echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                  		echo '<strong>Success!</strong> You have added story.'.'<br />';
				    echo '</div>';
            	echo '</div>';
	 		}
        ?>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 story-content">
            	<form action="" id="addStoryForm" method="POST">
				    <div class="form-group">
				        <label for="storyName"><?php _e('Story Name:', 'framework') ?></label>
				        <input type="text" name="storyName" id="storyName" class="form-control" />
				    </div>
				    <div class="form-group">
				        <label for="storyContent"><?php _e('Story Content:', 'framework') ?></label>
				        <div id="alerts"></div>
    					<div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
    					  <div class="btn-group">
    					    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
    					      <ul class="dropdown-menu">
    					      </ul>
    					    </div>
    					  <div class="btn-group">
    					    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
    					      <ul class="dropdown-menu">
    					      <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
    					      <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
    					      <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
    					      </ul>
    					  </div>
    					  <div class="btn-group">
    					    <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
    					    <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
    					    <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
    					    <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
    					  </div>
    					  <div class="btn-group">
    					    <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
    					    <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
    					    <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
    					    <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
    					  </div>
    					  <div class="btn-group">
    					    <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
    					    <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
    					    <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
    					    <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
    					  </div>
    					  <div class="btn-group">
							  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
							    <div class="dropdown-menu input-append">
								    <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
								    <button class="btn btn-default" type="button">Add</button>
    					    </div>
    					    <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>
					
    					  </div>
    					  
    					  <div class="btn-group">
    					    <a class="btn" title="Insert picture (or just drag and drop)" id="pictureBtn"><i class="icon-picture"></i></a>
    					    <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
    					  </div>
    					  <div class="btn-group">
    					    <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
    					    <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
    					  </div>
    					  <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
    					</div>
    					<textarea style="display:none;" name="storyContent" id="storyContent" rows="8" cols="30" class="form-control"></textarea>
				        <div id="editor"></div>
				    </div>
                    <div class="form-group">
                        <label for="storyTag"><?php _e('Add Tags: (Use enter key to seperate each tag)', 'framework') ?></label>
                        <input type="text" name="storyTag" id="storyTag" class="form-control" data-role="tagsinput" />
                    </div>
                    <div class="form-group">
                        <label for="storyCat"><?php _e('Choose a Category:', 'framework') ?></label>
                        <?php wp_dropdown_categories(array('class' => 'form-control', 'hide_empty' => 0, 'name' => 'storyCat', 'hierarchical' => true)); ?>
                    </div>
				    <div class="form-group">
				        <input type="hidden" name="submitted" id="submitted" value="true" />
				        <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
				        <button class="btn btn-primary" type="submit"><?php _e('ADD STORY', 'framework') ?></button>
				    </div>
				</form>
            </div>
        </div>
        <?php }else{ ?>
        	<div class="row">
            	<div class="col-lg-8 col-md-8 col-sm-8">
            	<p>You need to Login first.</p>
            	</div>
            </div>
        <?php } ?>
    </div>
<script>
jQuery(document).ready(function($){
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top+13, left: editorOffset.left+$('#editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	$('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();
  });
</script>
<script>
jQuery(document).ready(function($){
    $("form#addStoryForm").bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            storyName: {
                message: 'The story name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The story name is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 5,
                        max: 100,
                        message: 'The story name must be more than 5 and less than 100 characters long'
                    },
                }
            },
        }
    });

	$('form#addStoryForm').on('submit', function(e){
        var story_content = $('#editor').html();
        $('#storyContent').val(story_content);
    });
    $('#editor').bind("DOMSubtreeModified",function(){
  		console.log('changed');
  		var story_realtime = $('#editor').html();
  		$('#storyContent').val(story_realtime);
	});
});
</script>
<?php get_footer(); ?>