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
                <?php get_sidebar() ?>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 story-content">
            	<form action="" id="addStoryForm" method="POST">
				    <div class="form-group">
				        <label for="storyName"><?php _e('Story Name:', 'framework') ?></label>
				        <input type="text" name="storyName" id="storyName" class="form-control" />
				    </div>
				    <div class="form-group">
				        <label for="storyContent"><?php _e('Story Content:', 'framework') ?></label>
    					<textarea name="storyContent" id="storyContent" rows="8" cols="30" class="form-control"></textarea>
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

    //initiate tinyMCE
    tinymce.init({
        selector: "#storyContent",
        theme: "modern",
        height: 300,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons", 
    });


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

});
</script>
<?php get_footer(); ?>