	<?php get_header(); ?>
    <div class="intro-header">

        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Landing Page</h1>
                        <h3>A Template by Start Bootstrap</h3>
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                            <li><a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                            </li>
                            <li><a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                            </li>
                            <li><a href="#" class="btn btn-default btn-lg"><i class="fa fa-linkedin fa-fw"></i> <span class="network-name">Linkedin</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

    <!-- /.home content -->
    <div class="container home-container">
        <div class="row">
            <?php

            $posts = get_field('home_modules', 65);

            if( $posts ): ?>
                <?php foreach( $posts as $post ): ?>
                    <?php setup_postdata($post); ?>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading"><?php the_title(); ?></div>
                            <div class="panel-body">
                                <?php the_excerpt(); ?>
                                <a alt="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                    <span class="story-btn btn btn-primary">READ FULL STORY</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>    
    <!-- /.banner -->
	<?php get_footer(); ?>