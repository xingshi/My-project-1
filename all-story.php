<?php
/**
 * Template Name: All Story
 */
  get_header(); 
?>
<script>
    function toggle_story( id ) {
      jQuery( "#toggle-content" + id ).slideToggle( "slow" , function() {

        if ( jQuery( "#toggle-badge" + id ).hasClass('glyphicon-plus') ) {
          jQuery( "#toggle-badge" + id ).removeClass('glyphicon-plus').addClass('glyphicon-minus');
        } else if ( jQuery( "#toggle-badge" + id ).hasClass('glyphicon-minus') ) {
            jQuery( "#toggle-badge" + id ).removeClass('glyphicon-minus').addClass('glyphicon-plus');
        }
        
      });

      
    }
</script>
<div class="container padding-container">
    <div class="page-header">
        <h1 id="timeline"><?php echo $post->post_title; ?></h1>
    </div>
    <ul class="timeline">
        <?php

            function rand_color() {
              return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }

            $args_story = array(
              'post_type' => 'story',
              'posts_per_page' => -1,
              'post_status' => 'publish',
              'orderby' => 'date'
            );
            $story = new WP_Query( $args_story );

            if ( $story->have_posts() ) {
              $invert = 0;
              while ( $story->have_posts() ) {
                $story->the_post();
        ?>
        <li <?php echo ($invert % 2 != 0) ? "class='timeline-inverted'" : ""; ?> >
          <div class="timeline-badge" onclick="toggle_story(<?php the_ID(); ?>)" style="<?php echo "background-color:" . rand_color(); ?>"><i id="toggle-badge<?php the_ID(); ?>" class="glyphicon glyphicon-plus"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title"><?php echo get_the_title(); ?></h4>
              <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo get_the_date() . " By " . get_the_author(); ?></small></p>
            </div>
            <div class="timeline-body" id="toggle-content<?php the_ID(); ?>">
              <p><?php the_content(); ?></p>
            </div>
          </div>
        </li>
        <?php 
              $invert++;
              }
            } else {
              // no posts found
            }
            wp_reset_postdata();
        ?>
    </ul>
</div>
<script>
  jQuery( document ).ready(function($) {
    $( "#toggle-all" ).click(function() {
      $( "div[id*='toggle-content']" ).slideToggle( "slow" );
    });
  });
</script>
<?php get_footer(); ?>