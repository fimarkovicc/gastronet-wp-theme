<?php 
// if(!is_user_logged_in()){
// 	wp_redirect(site_url('/'));
// 	exit;
// }
$author_id = get_post_field('post_author', $post_id);
$user_meta=get_userdata($author_id);
$user_role=$user_meta->roles;
///////////////////////////////////////////////////////////// if editing job post 
if(get_current_user_id() == $author_id){
	
	acf_form_head(); 
	?>
	<?php get_header(); ?>
	
	<div class="content new-job">
	<div class="container-fluid p-0 text-center job-edit">
		<h1 class="py-4">Edit job</h1>
		</div>	
			<div class="container pt-3 new-job-container pb-5">
	
				
				<?php 
				while ( have_posts() ) : the_post(); 
				?>
				
					
					
					<?php acf_form(array(
						'post_title'	=> true,
						'updated_message' => __('<span onclick="parentNode.remove()">Job listing updated<span class="dashicons dashicons-dismiss"></span></span>', 'acf')
					)); ?>
	
				<?php endwhile; ?>
	
			</div><!-- #content -->
		
	
	<?php get_footer(); 
	}else{ 

///////////////////////////////////////////////////////////// if viewing job post 
get_header();
?>
<div class="content single-job-view">
	<div class="container pb-5">
<?php

while ( have_posts() ){
	the_post();
?>
	<h1><?php the_title(); ?></h1>

	<div class="job-specs">
	<h3>Required skill level</h3>
	<p><span class="job-skill"><?php $skill = get_field('skill'); echo $skill->name; ?></span></p>
	<h3>Location</h3>
		<?php
		$location = get_field('location');
		$state = $location['state'];
		$country = $location['country'];
		$city = $location['city'];
		?>
		<p><a href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$location['lat'].','.$location['lng']; ?>" target="_blank"><span class="job-location"><?php 
								if($city){echo $city . ', ';}
								if($state){echo $state . ', ';}
								echo $country;
								?>
		<span class="dashicons dashicons-external"></span></span></a></p>

		<div style="max-width: 350px; max-height:350px;">
  <iframe width="100%" height="100%" 
    src="https://maps.google.com/maps?output=embed&amp;width=100%&amp;height=100%&amp;hl=en&amp;q=<?php echo $location['address']; ?>"
    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</div>


		<h3>About the job</h3>
		<p><?php the_field('about'); ?></p>
		<h3>Category</h3>
		<p><span class="">
                            <?php 
                                $types = get_field('type'); 
                                foreach($types as $type){
                                    echo '<span class="job-type ' . $type->slug . '">' . $type->name . '</span>'; 
                                }
                                
                                ?>
                            
							</span></p>
		<h3>Additional info</h3>
		<p class="single-job-meta">
			<?php
				if(get_field('live_in')){$livein = get_field('live_in');}
				if(get_field('work_permit_support')){$permit = get_field('work_permit_support');}
				if(get_field('transfer')){$transfer = get_field('transfer');}
			?>
			
			<span><span class="dashicons dashicons-<?php echo $livein; ?>"></span>Accomodation</span>
			<span><span class="dashicons dashicons-<?php echo $permit; ?>"></span>Work permit/visa assistance</span>
			<span><span class="dashicons dashicons-<?php echo $transfer; ?>"></span>Payed transfer</span>
		</p>
		

	</div>
	<?php
};

///// Apply to job form
global $current_user;
$args = array(
	'user_id' => $current_user->ID,
	'post_id' => get_the_ID()
);
$usercomment = get_comments($args);
if(current_user_can('candidate')){
	if(!get_field('introduction', 'user_'.get_current_user_id())){
		
		echo '<button class="apply-to-job mt-4 pl-2 disabled"><span class="dashicons dashicons-edit pb-1"></span> Apply to this job</button><span class="d-block d-sm-inline small ml-sm-3 mt-3 mt-sm-0">You must fill in your resume before applying to jobs.</span>';
	}else if(count($usercomment) >= 1){
		$commentsgo = false;
		echo '<button class="applied-to-job mt-4 pl-2"><span class="dashicons dashicons-yes-alt pb-1"></span> You have applied to this job</button>';
	} else if(count($usercomment) < 1){
		$commentsgo = true;
		echo '<button class="apply-to-job mt-4 pl-2"><span class="dashicons dashicons-edit pb-1"></span> Apply to this job</button>';
	}
}
// check if user is candidate, has resume filled in and has not applied already to job
if(
	current_user_can('candidate') AND 
	get_field('first_name', 'user_'.get_current_user_id()) AND
	get_field('introduction', 'user_'.get_current_user_id()) AND 
	$commentsgo
){
	
	
	$args = array(
		
        'label_submit' => __( 'Send application', 'textdomain' ),
        'title_reply' => __( 'Enter your cover letter', 'textdomain' ),
        'comment_notes_after' => '<p>Your resume will be automatically attached to this cover letter</p>',
        'comment_field' => '<label class="sr-only" for="application">' . _x( 'Application', 'noun' ) . '</label><textarea id="comment" name="comment" aria-required="true"></textarea>',
	);
	
	echo '<div class="my-3 job-application hidden">';
	comment_form($args, $post_id);
	echo '<button class="cancel-job-application">Cancel</button></div>';
}





		$query_employer = new WP_User_Query(array(
			'include' => array($author_id)
		));
	?>
	
	<h1>About the <?php echo $user_role[0]; ?></h1>
	<?php
	
	
	if($query_employer->results){
		foreach($query_employer->results as $employer){
			
			
	?>
	<div class="employer-specs mb-3">
		<h3>Company Name</h3>
		<p class="company-name"><?php echo $employer->business_name; ?></p>
		<h3>Location</h3>
		<?php
		$location = $employer->location;
		$state = $location['state'];
		$country = $location['country'];
		$city = $location['city'];
		?>
		<p><a href="<?php echo 'https://www.google.com/maps/search/?api=1&query='.$employer->location['lat'].','.$employer->location['lng']; ?>" target="_blank"><span class="job-location"><?php 
								if($city){echo $city . ', ';}
								if($state){echo $state . ', ';}
								echo $country;
								?>
		<span class="dashicons dashicons-external"></span></span></a></p>

		

		<!--<div style="max-width: 350px; max-height:350px;">
  <iframe width="100%" height="100%" 
    src="https://maps.google.com/maps?output=embed&amp;width=100%&amp;height=100%&amp;hl=en&amp;q=<?php echo $location['address']; ?>"
    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</div>-->




		<?php if($employer->website): ?>
		<h3>Website</h3>
		<p class="employer-websitelink"><a href="<?php echo $employer->website; ?>" target="_blank"><?php echo $employer->website; ?></a></p>
		<?php endif; ?>

		<?php if($employer->about): ?>
		<h3>About</h3>
		<p><?php echo $employer->about; ?></p>
		<?php endif; ?>

		<?php
			
		?>
	</div>
	<?php
if(current_user_can('candidate')){
?>
	<a class="contact-employer-btn mt-2 pl-2 d-inline-block" href="mailto:<? echo get_the_author_meta('user_email'); ?>"><span class="dashicons dashicons-email pb-1"></span> Send email</a>
	<?php
}
?>

<?php
if(!is_user_logged_in()){
?>
	<a class="contact-employer-btn mt-2 pl-2 d-inline-block" href="<? echo wp_login_url(); ?>">Login to apply <span class="dashicons dashicons-arrow-right-alt"></span></a>
	<?php
}
?>

	<?php
		}
	}else{
		echo '<p>User does not exist.</p>';
	}
		wp_reset_postdata();
	?>
	


	</div>
</div>
</div>
<?php
get_footer();

}
?>