jQuery(document).ready(function($) {
    
    // Perform AJAX login on form submit
    $('form#login').on('submit', function(e){
        $("span#loading-log").show();
        $('form#login p.status').show().text(ajax_login_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#login #username').val(), 
                'password': $('form#login #password').val(), 
                'security': $('form#login #security').val() },
            success: function(data){
                $("span#loading-log").hide();
                $('form#login p.status').html(data.message);
                if (data.loggedin == true){
                    document.location.href = ajax_login_object.redirecturl;
                }
            },
            error:  function(error){
                $("span#loading-log").hide();
                $('form#login p.status').html("<p class='error'>seems error occured, please try again later...</p>");
            }
        });
        e.preventDefault();
    });


});

