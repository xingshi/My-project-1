<?php
/**
 * Template Name: My Story
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
        <h2 id="timeline"><?php echo $post->post_title; ?></h2>
        <div id="collapseall" class="collapse-btn">
          <button id="collapse-all" type="button" class="btn btn-info">Collapse All</button>
          <button id="expand-all" type="button" class="btn btn-info">Expand All</button>
        </div>
    </div>
    <div class="clear"></div>
    <ul id="timeline-content" class="timeline">
        <?php
            global $user_ID;
            function rand_color() {
              return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            }

            $args_story = array(
              'post_type' => 'story',
              'posts_per_page' => 5,
              'paged' => get_query_var('paged'),
              'post_status' => 'publish',
              'author' => $user_ID,
              'orderby' => 'date'
            );
            $story = new WP_Query( $args_story );

            if ( $story->have_posts() ) {
              $invert = 0;
              while ( $story->have_posts() ) {
                $story->the_post();
        ?>
        <li id="single-story" <?php echo ($invert % 2 != 0) ? "class='timeline-inverted'" : ""; ?> >
          <div class="timeline-badge" onclick="toggle_story(<?php the_ID(); ?>)" style="<?php echo "background-color:" . rand_color(); ?>"><i id="toggle-badge<?php the_ID(); ?>" class="glyphicon glyphicon-plus"></i>
          </div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title"><a href="<?php echo get_permalink( get_the_ID() ); ?>" alt="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h4>
              <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo get_the_date() . " By " . get_the_author(); ?></small></p>
            </div>
            <div class="timeline-body" id="toggle-content<?php the_ID(); ?>">
              <p><?php the_excerpt(); ?></p><a href="<?php echo get_permalink( get_the_ID() ); ?>" alt="<?php echo get_the_title(); ?>"><span class="story-btn btn btn-primary">READ FULL STORY</span></a>
            </div>
          </div>
        </li>
        
        <?php 
              $invert++;
              }
              echo "<div id='pagi-con'>";
              wp_pagenavi(array('query' => $story));
              echo "</div>";
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
<script>
jQuery( document ).ready(function($) {
  $('ul#timeline-content').infinitescroll({
    navSelector   : "#pagi-con",
    nextSelector  : "#pagi-con a.nextpostslink",
    itemSelector  : "#timeline-content #single-story",
    loading: {
      loadingText  : "Loading...", 
      finishedMsg: 'You have reached the end.',
      img: '<?php echo get_template_directory_uri()."/img/ajax-loader.gif"; ?>',
      msgText: "<em>Loading more content ...</em>",
    },
    animate      : false,        
    });

    $('#collapse-all').on('click', function() {
      jQuery( "div[id*='toggle-content']" ).slideUp( "slow" );
    });
    $('#expand-all').on('click', function() {
      jQuery( "div[id*='toggle-content']" ).slideDown( "slow" );
    });
});
  </script>
<?php get_footer(); ?>