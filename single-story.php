<?php
  get_header(); 
?>
<div class="container padding-container">
    <div class="page-header">
        <h2 id="timeline"><?php echo $post->post_title; ?></h2>
    </div>
    <div class="row single-row">
        <div class="col-lg-12 col-md-12 col-sm-12">
        	<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
					the_content( );
				endwhile;
			?>
        </div>
    </div>
</div>
<?php get_footer(); ?>