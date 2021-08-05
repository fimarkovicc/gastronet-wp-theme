<?php 
get_header();
?>
<div class="content">
<?php
if(!is_user_logged_in()){
?>
    <section class="header-container">
    <header class="container main-header">
        <div class="row">
                <div class="col-md-6">
                <h1>Where will great talent take you?</h1>
                <p class="py-4">We match professionals and businesses seeking specialized talent in the gastronomy industry.</p>
                <a href="<?php echo site_url('/wp-login.php?action=register'); ?>" class="btn py-1 px-2 p-md-3 header-action">GET STARTED it's free!</a>
        </div>
        </div>
    </header>
    </section>
<?php
}else{
?>
    <section class="map-header">
        <div class="map-header-inner">
        <div class="container py-5">
        
            <h1 class="text-center mb-4">Where will your talent take you?</h1>
    <div class="map-search w-75 mx-auto">
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
  	<button type="submit" class="btn job-archive-filter-btn">Go!</button>
	  </div>
	  </div>
</form>  
</div>          
        </div>
        </div>
    </section>
<?php
}
?>

    <section class="latest-jobs py-5">
        <div class="container">
            <h2 class="mb-5">Recent job postings</h2>
            <div class="row">
                <?php
                    $query = new WP_Query(array(
                        'post_type' => 'job',
                        'posts_per_page' => '7'
                    ));

                    while($query->have_posts()){
                        $query->the_post();

                        $location = get_field('location');
                        $country = $location['country'];
                        $state = $location['state'];
                        $city = $location['city'];
                        

                ?>

                <div class="col-12">
                    <div class="item">
                   
<h3 class="mb-3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                        
                        <p>
                            <span class="job-skill"><?php $skill = get_field('skill'); echo $skill->name; ?></span>
                            <span class="job-location d-flex align-items-center mr-2 float-md-right mt-3 mt-md-0"><span class="dashicons dashicons-location mr-2"></span>
                            <?php 
                            if($city){echo $city . ', ';}
                            if($state){echo $state . ', ';}
                            echo $country;
                            ?>
                        </span>
                            <span class="d-block d-md-inline mt-3">
                            <?php 
                                $types = get_field('type'); 
                                foreach($types as $type){
                                    echo '<span class="d-inline-block job-type ' . $type->slug . '">' . $type->name . '</span>'; 
                                }
                                
                                ?>
                            
                            </span></p>
                        <p class="job-desc">
                            <?php echo wp_trim_words(get_field('about'), '50', '...'); ?>
                        </p>
                    </div>
                </div>

                <?php
                    }
                    wp_reset_postdata();
                ?>

                

            </div>
            
<p class="text-center main-text mb-0"><a class="alert-link btn view-more-latest-btn" href="<?php echo site_url('/browse-jobs'); ?>">View All Jobs</a></p>
               
        </div>
    </section>
<?php
if(!is_user_logged_in()){
?>
    <section class="call-to-action text-center">
        <div class="row m-0">
            <div class="col-md-12 p-0">
                <div class="content-left p-4 p-sm-5">
                    <h2>Are you a restaurant owner?</h2>
                    <p>Don't let the new season start understaffed. Browse through hundreds of skilled workers resumes.</p>
                    <button class="btn"><a href="<?php echo site_url('/wp-login.php?action=register'); ?>">Sign Up</a></button>
                </div>
            </div>
            
        </div>
    </section>
<?php
}
?>

    <section class="featured-candidates py-5">
        <div class="container">
            <h2 class="mb-5">Browse professional candidates</h2>
            <ul id="lightSlider" class="d-flex">
                
                <?php
                $query = new WP_User_Query(array(
                        'role' => 'candidate',
                        'number' => '7',
                        'order' => 'DESC',
                        'orderby' => 'user_registered',
                        'meta_query' => array(
                        array(
                            'key' => 'first_name',
                            'compare' => '!=',
                            'value' => ''
                        ),
                        array(
                            'key' => 'photo',
                            'compare' => '!=',
                            'value' => ''
                        )
                        )
                    ));

                    foreach($query->results as $user){

                        $location = $user->location;
                        $country = $location['country'];
                        $state = $location['state'];
                        $city = $location['city'];
                    ?>
                    <li>
                        <div class="candidate p-4 d-flex flex-column h-100">
                            <?php 
                            
                            $img_atts = wp_get_attachment_image_src( $user->photo, $default );
                            $img_src = $img_atts[0];
                            ?><div class="candidate-photo-wrap mb-3" style="background: url('<?php echo $img_src; ?>') no-repeat center center; background-size:90px;">
                            
                    </div>
                            <h4 class="mb-3"><?php echo $user->first_name.' '.$user->last_name; ?></h4>
                            <p class="mb-0 candidate-location"><span class="dashicons dashicons-location pt-1 mr-1"></span>
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
                            <a href="<?php echo get_author_posts_url( $user->id ); ?>" class="mt-auto candidate-more">View details</a>
                        </div>
                    </li>
                    <?php    
                    }
                    wp_reset_postdata();
                ?>
            <?php if(!is_user_logged_in()){ ?>
                <li>
                    <div class="candidate p-4 d-flex flex-column h-100">
                        <div class="my-auto">
                        <h4 class="mb-3">Sign up to view
                            more profiles</h4>
                        <a href="<?php echo site_url('/wp-login.php?action=register'); ?>" class="btn py-1 px-2 candidate-action">Sign up</a>
                    </div>
                    </div>
                </li>
            <?php } ?>
                </ul>
                
        </div>
    </section>

    <section class="front-hiw">

    
    <div class="container text-center py-5">
        <h2 class="mb-5"><span>Candidates</span> - How it works</h2>
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="hiw-content">
                    <div class="hiw-img-wrap mb-4">
                        <img src="<?php echo get_theme_file_uri('/img/hiw-1.svg') ?>" alt="#">
                    </div>
                    
                    <h4>Create an account. It's free!</h4>
                    <p>There are no fees involved in signign up and using the service.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="hiw-content">
                    <div class="hiw-img-wrap mb-4">
                        <img src="<?php echo get_theme_file_uri('/img/hiw-2.svg') ?>" alt="#"  class="hiw-img-2">
                    </div>
                    
                    <h4>Complete your profile</h4>
                    <p>Fill in the required profile info. Create your personalized resume.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="hiw-content">
                    <div class="hiw-img-wrap mb-4">
                        <img src="<?php echo get_theme_file_uri('/img/hiw-3.svg') ?>" alt="#">
                    </div>
                    <h4>Browse jobs and employers</h4>
                    <p>Access the jobs listings directory, browse local jobs or anywhere on the globe.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="hiw-content">
                    <div class="hiw-img-wrap mb-4">
                        <img src="<?php echo get_theme_file_uri('/img/hiw-4.svg') ?>" alt="#">
                    </div class="hiw-img-wrap">
                    <h4>Apply for jobs</h4>
                    <p>Apply to jobs directly to employers or agencies. Send your cover letter and resume.</p>
                </div>
            </div>
        </div>

    </div>
</section>


<?php
if(!is_user_logged_in()){
?>
<section class="call-to-action text-center">
    <div class="row m-0">
        
        
        <div class="col-md-12 p-0">
            <div class="content-right p-4 p-sm-5">
                <h2>Employment agencies</h2>
                <p>Get the opportunity to reach thousands of chefs and waiting staff, locally or internationally.</p>
                <button class="btn"><a href="<?php echo site_url('/wp-login.php?action=register'); ?>">Post Job</a></button>
            </div>
        </div>
    </div>
</section>
<?php
}
?>

</div><!-- end content -->
<?php   
get_footer(); 
?>