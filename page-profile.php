<?php
/**
 * Template Name: User Profile
 *
 * Allow users to update their profiles from Frontend.
 *
 */

get_header();

/* Get user info. */
global $current_user, $wp_roles;
get_currentuserinfo();
$error = array();    
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

    /* Update user password. */
    if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
        if ( $_POST['pass1'] == $_POST['pass2'] ){
            if(wp_check_password( $_POST['cur-pass'], $current_user->user_pass, $current_user->ID )){
                wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
                wp_set_auth_cookie( $current_user->ID ); 
            }else{
                $error[] = __('Current password is not correct.  Your password was not updated.', 'profile');
            }
        }else{
            $error[] = __('The passwords you entered do not match.  Your password was not updated.', 'profile');
        }
    }

    /* Update user information. */
    if ( !empty( $_POST['url'] ) )
        wp_update_user( array ( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['url'] ) ) ) ;
    if ( !empty( $_POST['email'] ) ){
        if (!is_email(esc_attr( $_POST['email'] )))
            $error[] = __('The Email you entered is not valid.  please try again.', 'profile');
        elseif(email_exists(esc_attr( $_POST['email'] ))){
            if (email_exists(esc_attr( $_POST['email'] )) != $current_user->ID) {
                $error[] = __('This email is already used by another user.  try a different one.', 'profile');
            }
        }
        else{
            wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
        }
    }

    if ( !empty( $_POST['firstname'] ) )
        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['firstname'] ) );
    if ( !empty( $_POST['lastname'] ) )
        update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['lastname'] ) );
    if ( !empty( $_POST['description'] ) )
        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );
}
?>
    <div class="container padding-container" id="post-<?php the_ID(); ?>">
        <div class="page-header col-lg-10 col-md-10 col-sm-10 row">
            <h2>Edit Profile</h2>
        </div>
        <?php if ( count($error) == 0 && 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user') { ?>
        <div class="row">
            <div class="alert alert-success fade in col-lg-6 col-md-6 col-sm-6">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Well done!</strong> You successfully update all fields.
            </div>
        </div>
        <?php }else if(count($error) > 0){ ?>
        <?php echo '<div class="row">';
                echo '<div class="alert alert-danger fade in col-lg-6 col-md-6 col-sm-6">';
                  echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                  echo '<strong>Oops!</strong> You have errors.'.'<br />';
                  echo implode("<br />", $error);
                echo '</div>';
              echo '</div>';
            } 
        ?>
        <div class="entry-content entry row col-lg-6 col-md-6 col-sm-6">
            <?php the_content(); ?>
            <?php if ( !is_user_logged_in() ) : ?>
                    <p class="warning">
                        <?php _e('You must be logged in to edit your profile.', 'profile'); ?>
                    </p><!-- .warning -->
            <?php else : ?>
                <form method="post" id="adduser" action="<?php the_permalink(); ?>">
                    <div class="form-group form-username">
                        <label for="username"><?php _e('User Name (This is login username, can not be changed)', 'profile'); ?></label>
                        <input readonly required="required" class="form-control text-input" name="user-tname" type="text" id="user-name" value="<?php the_author_meta( 'user_login', $current_user->ID ); ?>" />
                    </div><!-- .form-username -->
                    <div class="form-group form-username">
                        <label for="firstname"><?php _e('First Name', 'profile'); ?></label>
                        <input class="form-control text-input" name="firstname" type="text" id="firstname" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
                    </div><!-- .form-first name -->
                    <div class="form-username form-group">
                        <label for="lastname"><?php _e('Last Name', 'profile'); ?></label>
                        <input class="form-control text-input" name="lastname" type="text" id="lastname" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
                    </div><!-- .form-last name -->
                    <div class="form-email form-group">
                        <label for="email"><?php _e('E-mail * (This also can be used to log in)', 'profile'); ?></label>
                        <input class="form-control text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
                    </div><!-- .form-email -->
                    <div class="form-url form-group">
                        <label for="url"><?php _e('Website', 'profile'); ?></label>
                        <input class="form-control text-input" placeholder="http://" name="url" type="url" id="text" value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>" />
                    </div><!-- .form-url -->
                    <div class="form-password form-group">
                        <label for="cur-pass"><?php _e('Current Password * (You will need to log in again if you change password)', 'profile'); ?> </label>
                        <input class="form-control text-input" name="cur-pass" type="password" id="cur-pass" />
                    </div><!-- .form-password -->
                    <div class="form-password form-group">
                        <label for="pass1"><?php _e('Password *', 'profile'); ?> </label>
                        <input class="form-control text-input" name="pass1" type="password" id="pass1" />
                    </div><!-- .form-password -->
                    <div class="form-password form-group">
                        <label for="pass2"><?php _e('Repeat Password *', 'profile'); ?></label>
                        <input class="form-control text-input" name="pass2" type="password" id="pass2" />
                    </div><!-- .form-password -->
                    <div class="form-textarea form-group">
                        <label for="description"><?php _e('About Yourself', 'profile') ?></label>
                        <textarea class="form-control" name="description" id="description" rows="3" cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
                    </div><!-- .form-textarea -->

                    <?php 
                        //action hook for plugin and extra fields
                        do_action('edit_user_profile',$current_user); 
                    ?>
                    <p class="form-submit">
                        <input name="updateuser" type="submit" id="updateuser" class="btn btn-primary submit button" value="<?php _e('UPDATE PROFILE', 'profile'); ?>" />
                        <?php wp_nonce_field( 'update-user' ) ?>
                        <input name="action" type="hidden" id="action" value="update-user" />
                    </p><!-- .form-submit -->
                </form><!-- #adduser -->
            <?php endif; ?>
        </div><!-- .entry-content -->
    </div><!-- .hentry .post -->
<script>
jQuery(document).ready(function($){
    $("form#adduser").bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            firstname: {
                message: 'The first name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The first name is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The first name must be more than 3 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The first name can only consist of alphabetical, number, dot and underscore'
                    }
                }
            },
            lastname: {
                message: 'The last name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The last name is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The last name must be more than 3 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The last name can only consist of alphabetical, number, dot and underscore'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            url: {
                validators: {
                    uri: {
                        message: 'The input is not a valid URL'
                    }
                }
            },
            pass1: {
                validators: {
                    stringLength: {
                        min: 7,
                        message: 'The password must be more than 7 characters long'
                    },
                    identical: {
                        field: 'pass2',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
            pass2: {
                validators: {
                    stringLength: {
                        min: 7,
                        message: 'The password must be more than 7 characters long'
                    },
                    identical: {
                        field: 'pass1',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
        }
    });
}); 
</script>
<?php get_footer(); ?>