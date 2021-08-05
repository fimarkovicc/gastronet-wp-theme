<?php
if(is_user_logged_in()){
get_header();
?>
<div class="content">
<div class="container">
<h1 class="text-center my-4">Browse Candidates</h1>  

<form action="<?php echo esc_url(site_url('/candidates')); ?>" method="get">
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

<div class="row py-4 mx-0">

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

$current_page = get_query_var('paged') ? (int) get_query_var('paged') : 1;
$users_per_page = 15;

$query = new WP_User_Query(array(
    'role' => 'candidate',
    'number' => $users_per_page,
    'paged' => $current_page,
    'meta_query' => array(
        'key' => 'first_name',
        'value' => '',
        'compare' => '!='
    ),
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
    
));

$total_users = $query->get_total();
$num_pages = ceil($total_users / $users_per_page); 


if($query->results){
foreach($query->results as $user){

    $location = $user->location;
    $country = $location['country'];
    $state = $location['state'];
    $city = $location['city'];
?>
<div class="col-sm-6 col-md-4 col-lg-3 px-1">
<div>
    <div class="candidate p-4 d-flex flex-column mb-2">
        <?php 
        
        if($img_atts = wp_get_attachment_image_src( $user->photo, $default )){
            $img_atts = wp_get_attachment_image_src( $user->photo, $default );
            $img_src = $img_atts[0];?>
            <div class="candidate-photo-wrap mb-3" style="background: url('<?php echo $img_src; ?>') no-repeat center center; background-size:90px;"></div>
            <?php
        }else{?>
            <div class="candidate-photo-wrap mb-3">
            <span class="dashicons dashicons-admin-users" style="font-size:80px; width:auto; height:auto; color:#00ACEE;"></span>
            </div>
            <?php
        }
        
        ?>
        
        <h4 class="mb-3"><?php echo $user->first_name.' '.$user->last_name; ?></h4>
        <p class="d-flex align-items-top justify-content-center mb-0 candidate-location"><span class="dashicons dashicons-location pt-1 mr-1"></span>
            <span><?php
            if($city){echo $city . ', ';}
            if($state){echo $state . ', ';}
            echo $country; 
             ?></span></p>
            <hr>
            
        <p>
        <?php
       foreach($user->skills as $skill){
        ?>
        <span class="skill"><?php echo get_term($skill)->name; ?></span>
        
        <?php
        
        }
        ?>
    </p>
     <?php
     
        
        ?>                        
        <a href="<?php echo get_author_posts_url( $user->id ); ?>" class="mt-auto candidate-more">view details</a>
        <?php
        
        ?>
    </div>
</div>
</div>
<?php    
}
?>

<?php
}else{
    echo '<p class="no-data-alert mx-auto">No results.</p>';
}
?>

<?php
wp_reset_postdata();
?>
</div>
<div class="pagination">
<?php
        // Previous page
        if ( $current_page > 1 ) {
            echo '<a href="'. add_query_arg(array('paged' => $current_page-1)) .'"><span class="dashicons dashicons-arrow-left-alt2"></span> Previous</a>';
        }

        // Next page
        if ( $current_page < $num_pages ) {
            echo '<a href="'. add_query_arg(array('paged' => $current_page+1)) .'">Next <span class="dashicons dashicons-arrow-right-alt2"></span></a>';
        }
        ?>
</div>
</div>
</div>
<?php
get_footer();
}
?>