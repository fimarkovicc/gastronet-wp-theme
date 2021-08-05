<?php
if(!is_user_logged_in()){
    wp_redirect(site_url('/'));
    exit;
}
if(current_user_can('candidate')){
    wp_redirect(site_url('/'));
    exit;
}
if(current_user_can('employer') OR current_user_can('agency')){
get_header();

$userid = get_current_user_id(); 

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $query = new WP_Query(array(
        'post_type' => 'job',
        'post_status' => 'publish',
        'paged' => $paged,
        'author' => $userid,
        'posts_per_page' => '15'
    ));
?>
<div class="content my-jobs">
<div class="container pb-4">
    <h1 class="text-center my-4">My jobs</h1>
<?php
if($query->have_posts()){
    while($query->have_posts()){
        $query->the_post();
		$location = get_field('location');
		$state = $location['state'];
		$country = $location['country'];
		$city = $location['city'];
        
?>
<div class="item">
                        <h3 class="mb-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p>
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
                        <p class="job-desc">
                            <?php echo wp_trim_words(get_field('about'), '70', '...'); ?>
                        </p>
    <?php
    $args = array(
        'post_id' => get_the_id(),   // Use post_id, not post_ID
        'count'   => true // Return only the count
    );
    $comments_count = get_comments( $args );
    if($comments_count == 0){
        $disabled = ' disabled';
    }else{
        $disabled = '';
    }
    ?>
                        <button class="btn job-archive-item-more mr-1 btn-show-applications<?php echo $disabled; ?>">Applications (<?php echo $comments_count; ?>)</button>
						<a href="<?php the_permalink(); ?>" class="btn job-archive-item-more mr-1">Edit job</a>
						
                        <?php 
                        $postid = get_the_id();
                        $deletelink = get_delete_post_link($postid, '', true);
                        
                        ?>
                         <a href="<?php echo $deletelink; ?>" class="btn job-archive-item-more mr-1">Delete job</a>
                        
                        
                        <div class="job-applications-container hidden">
                           
                            
                        

                            <div class="job-applications-container-inner">
                    
                                <button class="btn job-archive-item-more mr-1 btn-hide-applications"><a href="<?php echo site_url('/my-jobs'); ?>">Close</a></button>
                        
                            <button class="btn job-archive-item-more mr-1 load-more-applications" data-count="<?php echo $comments_count; ?>" data-pid="<?php echo get_the_id(); ?>">Load more applications</button>
                  
                            <div class="job-applications-container-inner-load">
                                
                        <?php comments_template('/comments.php', false); ?>
                       
                        

                    </div>
                    </div>
</div>

                    </div>
<?php
}
?>
<div class="pagination">
    <?php 
        echo paginate_links( array(
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'total'        => $query->max_num_pages,
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 2,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => sprintf( '<i></i> %1$s', __( '<span class="dashicons dashicons-arrow-left-alt2"></span> Previous', 'text-domain' ) ),
            'next_text'    => sprintf( '%1$s <i></i>', __( 'Next <span class="dashicons dashicons-arrow-right-alt2"></span>', 'text-domain' ) ),
            'add_args'     => false,
            'add_fragment' => '',
        ) );
    ?>
</div>
<?php


wp_reset_postdata();

}else{
    echo '<p class="no-data-alert">You have no posted jobs. <a class="alert-link" href="'.site_url('/new-job').'">Create a job listing<span class="dashicons dashicons-arrow-right-alt pt-1"></span></a></p>';
}

?>
</div>
</div>
<?php
    
get_footer();
}
?>