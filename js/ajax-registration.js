
/* Registration Ajax */
jQuery(document).ready(function($) {
	jQuery('#register-me').on('click',function(){
		$("span#loading-log").show();
		var action = 'register_action';
	  
		var username = jQuery("#st-username").val();
	 	var mail_id = jQuery("#st-email").val();
	 	var passwrd = jQuery("#st-psw").val();
	 	var repasswrd = jQuery("#st-psw-re").val();
	  
		var ajaxdata = {
			action: action,
	 		username: username,
	 		mail_id: mail_id,
	 		passwrd: passwrd,
	 		repasswrd: repasswrd,
		};
	  
		jQuery.post( ajax_login_object.ajaxurl, ajaxdata, function(res){
			$("span#loading-log").hide(); 
			jQuery("#error-message").html(res);
		});
	});
});