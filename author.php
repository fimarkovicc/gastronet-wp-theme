<?php
if(!is_user_logged_in()){
    wp_redirect(site_url('/'));
}
global $wp_query;
$curauth = $wp_query->get_queried_object();

if($curauth->roles[0] == 'candidate'){// show candidate profile
    get_header();


?>
<div class="content single-user">

<div class="container pb-4">
<?php
if(get_field('first_name') == ''){
    echo '<p class="no-data-alert mt-5">You have not filled your profile information.<a class="alert-link" href="'.site_url('/candidate-edit-profile').'"> Update your profile <span class="dashicons dashicons-arrow-right-alt pt-1"></span></a></p>';
    exit;
}
?>
<div class="user-info mt-4">

        <?php 
        
        if(wp_get_attachment_image(get_field('photo'))){
            $img = wp_get_attachment_image(get_field('photo'));
        ?>
        <div class="single-user-photo-wrap d-flex align-items-center justify-content-center"><?php echo $img; ?></div>
        <?php
            
        }else{?>
            <div class="single-user-photo-wrap">
            <span class="dashicons dashicons-admin-users" style="font-size:90px; width:auto; height:auto; color:#00ACEE; margin:0 auto; display:block;"></span>
            </div>
            <?php
        }
        
        ?>
    
            

<div class="single-user-text">    
<h1><?php the_field('first_name'); ?> <?php the_field('last_name'); ?>
<p class="mb-0 candidate-location"><span class="dashicons dashicons-location ml-2 pt-2"></span>
            <span><?php
             $location = get_field('location');
             $country = $location['country'];
             $state = $location['state'];
             $city = $location['city'];
            if($city){echo $city . ', ';}
            if($state){echo $state . ', ';}
            echo $country; 
             ?></span></p>
</h1>

 <p class="mt-2">
        <?php
       foreach(get_field('skills') as $skill){
        ?>
        <span class="skill"><?php echo get_term($skill)->name; ?></span>
        
        <?php
        
        }
        ?>
    </p>
</div>




</div>
<?php if(!current_user_can('candidate')){ ?>
    <a class="btn job-archive-item-more mb-4" href="mailto:<?php echo $curauth->user_email; ?>?Subject=Contact from Gastronet">E-mail candidate</a>
    <?php }; ?> 

<?php
if(get_field('introduction')){//check if resume is filled out
?>
<div class="user-resume">
<h2>Resume</h2>
<div class="user-info mt-4">
    <p>
    <?php the_field('introduction'); ?>
    </p>
</div>
<h4>Employment history</h4>
<div class="user-info mt-4">
    <?php

    // check if the repeater field has rows of data
    if( have_rows('work_experience') ):
    
         // loop through the rows of data
        while ( have_rows('work_experience') ) : the_row();
    
            // display a sub field value
    ?>
    <h3><?php the_sub_field('employer'); ?>, <span class="employer-location"><?php the_sub_field('location'); ?></span></h3>
    <p class="position">Position: <?php the_sub_field('position_title'); ?></p>
    
    <p class="date my-2"><?php the_sub_field('start_date'); ?>
        - 
    <?php if(!get_sub_field('current_job')){ ?>
    <?php the_sub_field('end_date'); ?>
    <?php }else{ ?>
    <?php if(get_sub_field('current_job')){echo 'current job';}; ?></p>
    <?php } ?>
    <p><?php the_sub_field('about_the_position'); ?></p>
    <hr>
    <?php
    
        endwhile;
    
    else :
    
        // no rows found
        echo 'No data.';
    endif;
    
    ?>
    
</div>
<h4>Education</h4>
<div class="user-info mt-4">
    <?php

    // check if the repeater field has rows of data
    if( have_rows('education') ):
    
         // loop through the rows of data
        while ( have_rows('education') ) : the_row();
    
            // display a sub field value
    ?>
    <h3><?php the_sub_field('institution'); ?>, <span class="employer-location"><?php the_sub_field('location'); ?></span class="employer-location"></h3>
    
    <p class="position">Title: <?php the_sub_field('title'); ?></p>
    
    <?php if(get_sub_field('currently_undergoing')){ ?>
    <p class="date my-2">Currently undergoing</p>
    <?php }else{ ?>
        <p class="date my-2"><?php the_sub_field('date_finished'); ?></p>
    <hr>
    <?php } ?>
    
    <?php
    
        endwhile;
    
    else :
    
        // no rows found
        echo 'No data.';
    endif;
    
    ?>    
</div>
<?php
    if(have_rows('additional_skills_and_expertise')){
?>
<h4>Additional skills and expertise</h4>
<div class="user-info mt-4 mb-4">
<?php
// check if the repeater field has rows of data
    if( have_rows('additional_skills_and_expertise') ):
    
         // loop through the rows of data
        while ( have_rows('additional_skills_and_expertise') ) : the_row();
    
            // display a sub field value
    ?>
    
    <p><?php the_sub_field('skill'); ?></p>
 


    
    <?php
    
        endwhile;
    
    else :
    
        // no rows found
        echo 'No data.';
    endif;

    }

?>

</div>

</div>
<?php
}
?>


</div>

</div>
<?php

get_footer();
}

/////////////////////// show employer/agency profile

if($curauth->roles[0] == 'employer' OR $curauth->roles[0] == 'agency'){

    get_header();  
?>
<div class="content single-user">
<div class="container pb-4">
<?php
if(get_field('business_name') == ''){
    echo '<p>You have not filled your profile information.</p>';
    exit;
}
?>
<div class="user-info mt-4">
   
    <?php 
    
    if(wp_get_attachment_image(get_field('logo'))){
        $img = wp_get_attachment_image(get_field('logo'));
    ?>
    <div class="single-user-photo-wrap d-flex align-items-center justify-content-center"><?php echo $img; ?></div>
    <?php
        
    }else{?>
        <div class="single-user-photo-wrap">
        <span class="dashicons dashicons-store" style="margin-top:18px; font-size:50px; width:auto; height:auto; color:#00ACEE; display:block;"></span>
        </div>
        <?php
    }
    
    ?>

        

<div class="single-user-text">    
<h1><?php the_field('business_name'); ?></h1>
<p class="mt-2 candidate-location"><span class="dashicons dashicons-location mr-0 pt-1"></span>
        <span><?php
         $location = get_field('location');
         $country = $location['country'];
         $state = $location['state'];
         $city = $location['city'];
        if($city){echo $city . ', ';}
        if($state){echo $state . ', ';}
        echo $country; 
         ?></span></p>

    <?php  
            if(get_field('website')){
    ?>
                <p class="mt-2"><?php the_field('website'); ?></p>
    <?php
            }
    ?>

</div>
<?php
if(get_field('about')){
    ?>
<p class="mt-3"><?php the_field('about'); ?></p>
    <?php
}
?>
</div>



<?php

$userid = $curauth->ID; 

if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) { 
    $paged = get_query_var('page');
} else {
    $paged = 1;
}

    $query = new WP_Query(array(
        'post_type' => 'job',
        'post_status' => 'publish',
        'paged' => $paged,
        'author' => $userid,
        'posts_per_page' => '15'
    ));
?>

<?php
if($query->have_posts()){
?>

    <h2 class="text-center my-4">Job listings</h2>
<?php
    while($query->have_posts()){
        $query->the_post();
		$location = get_field('location');
		$state = $location['state'];
		$country = $location['country'];
		$city = $location['city'];
        
?>
<section class="latest-jobs">
<div class="item">
                        <h3 class="mb-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="mb-3">
                            <span class="job-skill"><?php $skill = get_field('skill'); echo $skill->name; ?></span>
                            <span class="job-location d-flex align-items-center mr-2 float-md-right mt-3 mt-md-0"><span class="dashicons dashicons-location mr-2"></span><?php 
                            
							if($city){echo $city . ', ';}
							if($state){echo $state . ', ';}
                            echo $country;
                            ?></span>
                            <span class="d-block d-md-inline mt-3">
                            <?php 
                                $types = get_field('type'); 
                                foreach($types as $type){
                                    echo '<span class="d-inline-block job-type ' . $type->slug . '">' . $type->name . '</span>'; 
                                }
                                
                                ?>
                            
                            </span></p>
                        <p class="job-desc mb-3">
                            <?php echo wp_trim_words(get_field('about'), '70', '...'); ?>
						</p>
                        <?php
                        $author_id=$post->post_author;
						
						$text = 'views details';

						if(get_current_user_id() == $author_id){
							$text = 'edit';
						}
                        ?>
						<a href="<?php the_permalink(); ?>" class="btn job-archive-item-more"><?php echo $text; ?></a>
                        
						
                    </div>
                </section>
<?php
        
    }
   if ($query->max_num_pages > 1) : // custom pagination  ?>
        <?php
        $orig_query = $wp_query; // fix for pagination to work
        $wp_query = $query;
        ?>
        <nav class="prev-next-posts">
            <div class="prev-posts-link">
                <?php echo get_next_posts_link( 'Next page '. '<span class="dashicons dashicons-arrow-right-alt"></span>', $query->max_num_pages ); ?>
            </div>
            <div class="next-posts-link">
                <?php echo get_previous_posts_link( '<span class="dashicons dashicons-arrow-left-alt"></span> Previous page' ); ?>
            </div>
        </nav>
        <?php
        $wp_query = $orig_query; // fix for pagination to work
        endif;


wp_reset_postdata();

}else{
    echo '<p class="no-data-alert">Your job listings will appear below. You have no posted jobs yet. <a class="alert-link" href="'.site_url('/new-job').'">Create a job listing <span class="dashicons dashicons-arrow-right-alt pt-1"></span></a>.</p>';
}

?>
</div>
</div>
<?php
 
    get_footer();
}
?>