


<?php

acf_form_head();
get_header(); 
?>
<div class="content">
<div class="container-fluid profile-head">  
<h1 class="text-center py-4">Edit profile</h1>  
</div>
  <div class="container profile-container pt-3 pb-5">
  
<?php
if ( !is_user_logged_in()){ 
  echo 'You are not logged in. <br /> <a href="' . wp_login_url() .'">Log In &rarr;</a>';
 
  } elseif (current_user_can('agency')) {
 
      $options = array(
      'post_id' => 'user_'.$current_user->ID, 
      'field_groups' => array(190),
      'submit_value' => 'Update Profile',
      'updated_message' => __('
      <span onclick="this.remove()" class="mr-2">Profile updated<span class="dashicons dashicons-dismiss"></span></span><span><a href="'.get_author_posts_url( $current_user->ID ).'">View profile</a></span>
      ', 'acf')
      );
     
      
     
      acf_form( $options ); 
      }
?>
  </div>
        </div>
<?php
 get_footer();
?>



