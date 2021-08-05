<?php
get_header();
if(is_user_logged_in()):
?>
<div class="content">
<div class="container-fluid account-head">  
<h1 class="text-center py-4">Account</h1>  
</div>
    <div class="container account-container pt-3 pb-5">
<?php

$current_user = wp_get_current_user();
$user_email = $current_user->user_email;

?>




<div class="form-group">
<label for="username">Username</label>
<input type="text" name="username" value="<?php echo esc_html($current_user->user_login); ?>" class="form-control" disabled>
<small class="form-text text-muted">Username cannot be changed.</small>
</div>

<div class="form-group">
<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" alt="<?php echo esc_attr('Reset Password'); ?>" class="btn btn-outline mb-2">
    <?php echo esc_html('Reset Password'); ?>
</a>

<small class="form-text text-muted">A new password reset link will be sent to your e-mail.</small>
</div>

<form action="<?php the_permalink(); ?>" method="post">
<div class="form-group">
<label for="e-mail">E-mail</label>
<input type="email" class="form-control" value="<?php echo sanitize_email($current_user->user_email); ?>" name="email" id="email">
<small class="form-text text-muted">If you change this we will send you an email at your new address to confirm it. <strong>The new address will not become active until confirmed.</strong></small>
<button class="btn btn-outline mt-3" type="submit">Change E-mail</button>
</div>

</form>
<?php

send_confirmation_on_profile_email();

if (isset( $_POST['email'])) {
    $new_email = sanitize_email($_POST['email']);

    // check if user is really updating the value
    if ($user_email != $new_email) {   
        
        if(!is_email($new_email)){
            echo '<span class="form-text alert alert-warning">Input a valid e-mail address.</span>';
        }
        

        // check if email is free to use
        if (email_exists($new_email)){

            // email already taken
            echo '<span class="form-text alert alert-warning">That e-mail address is not available.</span>';
            

        } else {
            $_POST['user_id'] = $current_user->ID;
            send_confirmation_on_profile_email();
            echo '<span class="form-text alert alert-success">User update email ink sent to new email for verification.</span>';
        }   
    }else{
    //same email
    echo '<span class="form-text alert alert-warning">The email you entered is the same as your current email.</span>';
    }
}

echo do_shortcode( '[plugin_delete_me /]' );


else:
    echo 'You are not logged in. <br /> <a href="' . wp_login_url() .'">Log In &rarr;</a>';
endif;

?>
</div>
</div>
<?php

get_footer();
?>




