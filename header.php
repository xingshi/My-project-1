<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<title><?php wp_title(); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="author" content="" />
		<meta name="google-site-verification" content="eNLL4F0x7IH6dzS7BCS5wwZmfIewlBp0cB289GOJAMs" />

		<!-- Styles -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,300,500,700' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
						 <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]-->
		<!-- Fav and touch icons -->
		<!--link rel="shortcut icon" href="../assets/ico/favicon.ico" />
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png" />
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png" />
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png" />
		<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png" /-->

		<?php wp_head(); ?>
		<script>
			jQuery(document).on('click', '.dropdown-menu', function (e) {
				// if has class "keep_open", dropdown will not close on click
				jQuery(this).hasClass('keep_open') && e.stopPropagation();

			});
			jQuery(document).ready(function($) {
				// mobile menu
				jQuery(".flexnav").flexNav();

				// scoll to top
				$("#toTop").scrollToTop(1000);
			});
		</script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-61288237-1', 'auto');
		  ga('send', 'pageview');
		
		</script>
	</head>
	<body>
	<?php $current_uri = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>
    <nav class="navbar navbar-default navbar-fixed-top top-nav-menu" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">iStory</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <?php
					
				wp_nav_menu(array(
					'theme-location' => 'nav-head',
					'container' => 'div',
					'container_class' => 'menu_bar collapse navbar-collapse navbar-left navbar-ex1-collapse',
					'menu_class' => 'nav navbar-nav',
					'container_id' => '',
					'depth' => 2,
					'walker' => new top_menu_walker()
				));
			?>
            <!-- /.navbar-collapse -->
            <div class="dropdown account-con">
            <?php if (is_user_logged_in()) { ?>
            	<?php global $current_user;
      				get_currentuserinfo();
				?>
				<span class="rego">Welcome Back <a href="<?php echo get_home_url(); ?>/edit-profile/"><?php echo $current_user->user_login; ?></a></span>
				<span class="rego"><a href="<?php echo wp_logout_url($current_uri); ?>">Sign Out</a></span>
			<?php } else { ?>
				<span class="rego"><a data-toggle="dropdown" class="dropdown-toggle" href="">SIGN UP <b class="caret"></b></a>
					<div class="dropdown-menu keep_open">
						<div class="error-message" id="error-message">Sorry Sign Up is currently disabled.</div>
						<!--div class="error-message" id="error-message"></div>
						<form method="post" id="register-form" name="st-register-form">
						<div class="form-group">
							<label for="st-username"><?php _e( 'Username', 'debate' ); ?></label>
							<input class="form-control" placeholder="Username" type="text" autocomplete="off" name="username" id="st-username" />
						</div>
						<div class="form-group">
							<label for="st-email"><?php _e( 'Email', 'debate' ); ?></label>
							<input class="form-control" type="text" placeholder="Email" autocomplete="off" name="mail" id="st-email" />
						</div>
						<div class="form-group">
							<label for="st-psw"><?php _e( 'Password', 'debate' ); ?></label>
							<input class="form-control" placeholder="Password" type="password" name="password" id="st-psw" />
						</div>
						<div class="form-group">
							<label for="st-psw-re"><?php _e( 'Confirm Password', 'debate' ); ?></label>
							<input class="form-control" placeholder="Confirm Password" type="password" name="re-password" id="st-psw-re" />
						</div>
							<input class="btn btn-primary" type="button" id="register-me" value="SIGN UP" />
							<span class="loading" style="display:none;" id="loading-log">
								<img src="<?php echo get_template_directory_uri(); ?>/img/loading.gif">
							</span>
						</form-->
					</div>
				</span>
				<span class="rego ender"><a href="#" data-toggle="dropdown" class="dropdown-toggle login_button" id="show_login">SIGN IN <b class="caret"></b></a>
					<div class="dropdown-menu keep_open">
						<form id="login" action="login" method="post">
    					    <p class="status"></p>
    					    <div class="form-group">
    					    	<label for="username">Username or Email</label>
    					    	<input class="form-control" placeholder="Enter UserName or Email" id="username" type="text" 	name="username">
    						</div>
    						<div class="form-group">
    					    	<label for="password">Password</label>
    					    	<input class="form-control" placeholder="Enter Password" id="password" type="password" name="password">
    					    </div>
    					    <div class="checkbox">
    							<label>
      								<input name="rememberme" id="rememberme" value="forever" tabindex="90" type="checkbox"> Remember Me?
    							</label>
  							</div>
    					    <a class="lost" href="<?php echo wp_lostpassword_url(); ?>">Lost your password?</a>
    					    <input class="submit_button btn btn-primary" type="submit" value="SIGN IN" name="submit">
    					    <span class="loading" style="display:none;" id="loading-log">
								<img src="<?php echo get_template_directory_uri(); ?>/img/loading.gif">
							</span>
    					    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
    					</form>
    				</div>
				</span>

			<?php } ?>
			</div>
        </div>
        <!-- /.container -->
    </nav>

    <div class="menu-button">Menu</div>
        <?php
        wp_nav_menu(array(
            'theme-location' => 'mobile-head',
            'container' => 'nav',
            'container_id' => 'no-display',
            'menu_class' => 'flexnav',
            'depth' => 2,
            'walker' => new mobile_menu_walker()
        ));
        ?>
	<a href="#top" id="toTop"></a>
