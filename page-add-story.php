<?php
/**
 * Template Name: Create Stories
 */

	acf_form_head();
 
	get_header(); 
 
	the_post();
?>
    <div class="container padding-container">
        <div class="page-header">
            <h1>TELL</h1>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
            	<?php 
 		
					$args = array(
						'post_id' => 'new',
						'field_groups' => array( 121 )
					);
 		
					acf_form( $args ); 
 		
				?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>