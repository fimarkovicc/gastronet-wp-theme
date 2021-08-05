<?php 

if(!current_user_can('employer') AND !current_user_can('agency')){  
    wp_redirect( esc_url(site_url('/')));
    exit;
}




	
       
    acf_form_head();

    get_header();

    ?>
    
    
    <div class="content new-job">
    <div class="container-fluid p-0 text-center">

<?php
//Check if profile is filled out
if(get_field('business_name', 'user_'.get_current_user_id()) == ''){
    if(current_user_can('employer')){
        echo '<p class="no-data-alert mt-5">Your profile page is empty. You must complete your profile before posting jobs. <a href="'.site_url('/employer-edit-profile').'" class="alert-link"> Got to your edit profile page <span class="dashicons dashicons-arrow-right-alt pt-1"></span></a></p>';
    }else if(current_user_can('agency')){
        echo '<p class="no-data-alert mt-5">Your profile page is empty. You must complete your profile before posting jobs. <a href="'.site_url('/agency-edit-profile').'" class="alert-link"> Got to your edit profile page <span class="dashicons dashicons-arrow-right-alt pt-1"></span></a></p>';
    }
    
    
    exit;
}
//check max number of posts
$maxPostEmployer = 99;
$maxPostAgency = 99;
$postsNum = count_user_posts(get_current_user_id(), 'job');
if(
    current_user_can('employer') AND $postsNum >= $maxPostEmployer OR 
    current_user_can('agency') AND $postsNum >= $maxPostAgency
){
    echo '<p class="no-data-alert mt-5">You have reached the limit of ' . $postsNum . ' active job listings.</p>';
    exit;
}

?>
    <h1 class="py-4">Create a new job</h1>
    </div>
    <div class="container new-job-container pt-4 pb-4">
        <!--<p class="my-4 text-center job-counter-info">You have currently used <?php echo $postsNum; ?>/<?php if(current_user_can('employer')){echo $maxPostEmployer;}else{echo $maxPostAgency;} ?> available jobs listings.</p>-->
        
        <?php
        $myjobs = '/my-jobs';
        acf_form(array(
            'post_id'		=> 'new_post',
            'field_groups' => array(204),
            'post_title'	=> true,
            'new_post'		=> array(
                'post_type'		=> 'job',
                'post_status'	=> 'publish' 
            ),
            'return' => site_url( $myjobs ),
            'submit_value'  => __('Create New Job'),
            'updated_message' => __('<span onclick="this.remove()" class="mr-2">Job created<span class="dashicons dashicons-dismiss"></span></span><span><a href="'.site_url( $myjobs ).'">View jobs</a></span>', 'acf')
            
        ));
        
        ?>
	
    </div>
    </div>

    <?php get_footer();
    
       
    
  

?>