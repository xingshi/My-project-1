<!DOCTYPE html> 
<html lang="en">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<title><?php wp_title(); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="author" content="" />
		
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
	</head>
	<body>
	<?php $current_uri = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Logo and title goes here...</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <?php
					
				wp_nav_menu(array(
					'theme-location' => 'nav-head',
					'container' => 'div',
					'container_class' => 'collapse navbar-collapse navbar-right navbar-ex1-collapse',
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
				<span class="rego">Welcome Back <a href="#"><?php echo $current_user->user_firstname.' '.$current_user->user_lastname ?></a></span>
				<span class="rego"><a href="<?php echo wp_logout_url($current_uri); ?>">Sign Out</a></span>
			<?php } else { ?>
				<span class="rego"><a href="<?php echo wp_registration_url($current_uri); ?>">Register</a></span>
				<span class="rego ender"><a href="#" data-toggle="dropdown" class="dropdown-toggle login_button" id="show_login">Log In <b class="caret"></b></a>
					<div class="dropdown-menu">
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
    					    <input class="submit_button btn btn-default" type="submit" value="Login" name="submit">
    					    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
    					</form>
    				</div>
				</span>
				
			<?php } ?>
			</div>
        </div>
        <!-- /.container -->
    </nav>

