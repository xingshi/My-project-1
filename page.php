<?php
  get_header(); 
?>
<div class="container padding-container">
    <div class="page-header">
        <h2 id="timeline"><?php echo $post->post_title; ?></h2>
    </div>
    <div class="row single-row">
        <div class="col-lg-2 col-md-2 col-sm-2">
            <?php get_sidebar() ?>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 story-content">
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