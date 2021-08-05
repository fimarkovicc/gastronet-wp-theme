<?php

  acf_form_head();
  get_header(); 
?>
<div class="content">
<div class="container-fluid p-0 text-center">
    <h1 class="py-4">Resume</h1>
    </div>
<div class="container profile-container pb-5">

<?php
if ( !is_user_logged_in()){ 
echo '<p>You are not logged in. <br /> <a href="' . wp_login_url() .'">Log In &rarr;</a></p>';
}else if(current_user_can('candidate') AND get_user_meta( $current_user->ID, 'first_name' , true )) {
    
    $options = array(
    'post_id' => 'user_'.$current_user->ID, 
    'field_groups' => array(236),
    'submit_value' => 'Update Resume',
    'updated_message' => __('<span onclick="this.remove()" class="mr-2">Resume updated<span class="dashicons dashicons-dismiss"></span></span><span><a href="'.get_author_posts_url( $current_user->ID ).'">View resume</a></span>', 'acf')
    );
   
    
   
    acf_form( $options ); 
    }else{
      echo '<p class="no-data-alert">You must complete and save your profile before editing your resume.<a href="'.site_url('/candidate-edit-profile').'" class="alert-link"> Got to your edit profile page <span class="dashicons dashicons-arrow-right-alt pt-1"></span></a></p>';
    }
?>

</div>
</div>
<?php
   get_footer();
?>

