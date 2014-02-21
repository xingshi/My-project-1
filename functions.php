<?php
		//$current_uri = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];    
	//echo substr($current_uri, 0, -1);
	//echo admin_url( 'admin-ajax.php' );
	//Styles
	function get_styles () {
		wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
		wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
		wp_enqueue_style('fontawesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.css');
		wp_enqueue_style('bootstrapValidator', get_template_directory_uri() . '/css/bootstrapValidator.min.css');
	}
	add_action('wp_enqueue_scripts', 'get_styles');
	
	//Scripts
	function get_scripts () {
		wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-1.10.2.js');
		wp_enqueue_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.js');
		wp_enqueue_script('ajax_register', get_template_directory_uri() . '/js/ajax-registration.js');
		wp_enqueue_script('bootstrapValidator', get_template_directory_uri() . '/js/bootstrapValidator.min.js');
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

	function restrict_admin(){
		if(defined('DOING_AJAX') && DOING_AJAX === true){
			$isAjax = true;
		}else{
			$isAjax = false;
		}
		
		//if not administrator, kill WordPress execution and provide a message
		if ( !$isAjax && ! current_user_can( 'manage_options' ) ) {
			wp_die( __('You are not allowed to access this part of the site') );
		}
	}
	add_action( 'admin_init', 'restrict_admin', 1);


	// handle login start 
	function ajax_login_init(){

    wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');

    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => '',
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
        echo json_encode(array('loggedin'=>false, 'message'=>__('<p class="error">Wrong username or password.</p>')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
	}

	// registration form error check 
	/*
	add_action('register_post', 'binda_register_fail_redirect', 99, 3);

	function binda_register_fail_redirect( $sanitized_user_login, $user_email, $errors ){
	    //this line is copied from register_new_user function of wp-login.php
	    $errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );
	    //this if check is copied from register_new_user function of wp-login.php
	    if ( $errors->get_error_code() ){
	        //setup your custom URL for redirection
	        $redirect_url = get_bloginfo('url') . '/register';
	        //add error codes to custom redirection URL one by one
	        foreach ( $errors->errors as $e => $m ){
	            $redirect_url = add_query_arg( $e, '1', $redirect_url );    
	        }
	        //add finally, redirect to your custom page with all errors in attributes
	        wp_redirect( $redirect_url );
	        exit;   
	    }
	}*/

	// lost passowrd error check
	add_action('lostpassword_post', 'validate_reset', 99, 3);

	function validate_reset(){
		if(isset($_POST['user_login']) && !empty($_POST['user_login'])){
			$email_address = $_POST['user_login'];
			if(filter_var( $email_address, FILTER_VALIDATE_EMAIL )){
				if(!email_exists( $email_address )){
					wp_redirect( 'register/?userexist=false' );
       				exit;
				}
			}else{
					$username = $_POST['user_login'];
					if ( !username_exists( $username ) ){
           				wp_redirect( 'register/?userexist=false' );
           				exit;
           			}
				} 
			
		}else{
			wp_redirect( 'register/?lostempty=true' );
			exit;   
		}
	}

	// Registration ajax 

	function st_handle_registration(){
	  
		if( $_POST['action'] == 'register_action' ) {
	  
			$error = '';
	  	
			$uname = trim( $_POST['username'] );
	 		$email = trim( $_POST['mail_id'] );
	 		$pswrd = $_POST['passwrd'];
	 		$repswrd = $_POST['repasswrd'];
	  	
			if( empty( $_POST['username'] ) )
	 			$error .= '<p class="error">Enter Username</p>';
	  	
			if( empty( $_POST['mail_id'] ) )
	 			$error .= '<p class="error">Enter Email Id</p>';
	 		elseif( !filter_var($email, FILTER_VALIDATE_EMAIL) )
	 			$error .= '<p class="error">Enter Valid Email</p>';
	  	
			if( empty( $_POST['passwrd'] ) || empty( $_POST['repasswrd'] ) )
				$error .= '<p class="error">Password should not be blank</p>';
	
			if( $_POST['passwrd'] != $_POST['repasswrd'] )
				$error .= '<p class="error">Password does not match</p>';
	  	
			if( empty( $error ) ){
				$status = wp_create_user( $uname, $pswrd ,$email );
				if( is_wp_error($status) ){	  		
					$msg = '';  		
	 				foreach( $status->errors as $key=>$val ){
	 					foreach( $val as $k=>$v ){
	 						$msg = '<p class="error">'.$v.'</p>';
	 					}
	 				}
					echo $msg;
	 			}else{
					$msg = '<p class="success">Registration Successful, Please Sign In</p>';
	 				echo $msg;
	 			}
			}else{
				echo $error;
	 		}
	 			die(1);
		}
	}

	add_action( 'wp_ajax_register_action', 'st_handle_registration' );
	add_action( 'wp_ajax_nopriv_register_action', 'st_handle_registration' );
	?>