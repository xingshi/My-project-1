<?php
		//$current_uri = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];    
	//echo substr($current_uri, 0, -1);
	//echo admin_url( 'admin-ajax.php' );
	//Styles
	function get_styles () {
		wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
		wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
		wp_enqueue_style('fontawesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.css');
	}
	add_action('wp_enqueue_scripts', 'get_styles');
	
	//Scripts
	function get_scripts () {
		wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-1.10.2.js');
		wp_enqueue_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.js');
	}
	add_action('wp_enqueue_scripts', 'get_scripts');	
	

	require_once('lib/walker.php');
	register_nav_menus(array(
		'nav-head' => 'The menu that shows in the header of the site.',
		'nav-footer' => 'The menu that shows in the footer of the site.'
	));
	
	function remove_admin_bar () {
		show_admin_bar(false);
	}
	add_action('after_setup_theme', 'remove_admin_bar');
	/*
	function restrict_admin(){
		//if not administrator, kill WordPress execution and provide a message
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __('You are not allowed to access this part of the site') );
		}
	}
	add_action( 'admin_init', 'restrict_admin', 1);
	*/
	// handle login start 
	function ajax_login_init(){

    wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');

    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Sending user info, please wait...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
	}

	// Execute the action only if the user isn't logged in
	if (!is_user_logged_in()) {
    	add_action('init', 'ajax_login_init');
	}

	function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
	}

	?>