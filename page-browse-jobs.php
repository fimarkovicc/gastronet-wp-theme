<?php
get_header();
?>
<div class="content">
<div class="container">  
<h1 class="text-center my-4">Browse Jobs</h1>  

<form action="<?php echo esc_url(site_url('/browse-jobs')); ?>" method="get">
	<div class="row mx-0">
		<div class="col-lg-4 px-1">
	<div class="form-group flex-fill">
    <label class="sr-only" for="country">Country select</label>
    <input name="country" type="text" class="form-control flex-fill" id="country" placeholder="Country" required>
	</div>
		</div>
		<div class="col-lg-4 px-1">
	<div class="form-group flex-fill">
    <label class="sr-only" for="state">State select</label>
    <input name="state" type="text" class="form-control flex-fill" id="state" placeholder="State/region (optional)">
	</div>
	</div>
		<div class="col-lg-3 px-1">
	<div class="form-group flex-fill">
    <label class="sr-only" for="city">City select</label>
    <input name="city" type="text" class="form-control flex-fill" id="city" placeholder="City/town (optional)">
	</div>
	</div>
	<div class="col-lg-1 px-1 text-right">
  	<button type="submit" class="btn job-archive-filter-btn">Filter</button>
	  </div>
	  </div>
</form>
<section class="latest-jobs py-4">
<?php 

if(!empty($_GET['country'])){
	$country = sanitize_text_field($_GET['country']);
}
if(!empty($_GET['state'])){
	$state = sanitize_text_field($_GET['state']);
}else{
	$state = 'null';
}
if(!empty($_GET['city'])){
	$city = sanitize_text_field($_GET['city']);
}else{
	$city = 'null';
}

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$args = array(
	'posts_per_page' => 15,
	'paged' => $paged,
	'post_type'=> 'job',
	'post_status' => 'publish',
	'meta_query' => array(
		'relation' => 'OR',
		
			array(
				'key' => 'location',
				'value' => $country,
				'compare' => 'LIKE'
			),
			array(
				'key' => 'location',
				'value' => $state,
				'compare' => 'LIKE'
			),
			array(
				'key' => 'location',
				'value' => $city,
				'compare' => 'LIKE'
			)
	)
		);

$query = new WP_Query($args);

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
	<a href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$location['lat'].','.$location['lng']; ?>" target="_blank"><span class="job-location d-flex align-items-center mr-2 float-md-right mt-3 mt-md-0"><span class="dashicons dashicons-location mr-2"></span><?php 
	if($city){echo $city . ', ';}
	if($state){echo $state . ', ';}
	echo $country;
	?></span></a>
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

						$author_id=$post->post_author;
						
						$text = 'views details';

						if(get_current_user_id() == $author_id){
							$text = 'edit';
						}

						?>
						<a href="<?php the_permalink(); ?>" class="btn job-archive-item-more"><?php echo $text; ?></a>
						
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
}else{
	echo '<p class="no-data-alert mx-auto">No jobs found.</p>';
};



	
wp_reset_postdata();



?>
</section>

</div>
</div>
<?php
get_footer();
?>