<?php
/*
Template Name: Lost Password
*/
	get_header();
?>
<!-- Custom Login/Register/Password Code @ http://digwp.com/2010/12/login-register-password-code/ -->
<!-- Theme Template Code -->

<div class="container padding-container">

	<?php global $user_ID, $user_identity; get_currentuserinfo(); if (!$user_ID) { ?>

	<div class="row">


			<?php $reset = $_GET['reset']; if ($reset == true) { ?>

			<h3>Success!</h3>
			<p>Check your email to reset your password.</p>

			<?php } ?>

		<div id="tab3_login" class="tab_content_login col-lg-4">
			<h3>Lose something?</h3>
			<p>Enter your username or email to reset your password.</p>
			<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="wp-user-form">
				<div class="username form-group">
					<label for="user_login" class="hide"><?php _e('Username or Email'); ?>: </label>
					<input class="form-control" type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
				</div>
				<div class="login_fields">
					<?php do_action('login_form', 'resetpass'); ?>
					<input type="submit" name="user-submit" value="<?php _e('Reset my password'); ?>" class="btn btn-default user-submit" tabindex="1002" />
					<?php $reset = $_GET['reset']; if($reset == true) { echo '<p>A message will be sent to your email address.</p>'; } ?>
					<input type="hidden" name="redirect_to" value="register/?reset=true" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>
		</div>
	</div>

	<?php }else{ ?>
		<h3>Something is wrong</h3>
		<p>You are not suppose to see this info...</p>
	<?php } ?>

</div>

<!-- Custom Login/Register/Password Code @ http://digwp.com/2010/12/login-register-password-code/ -->
<?php get_footer(); ?>