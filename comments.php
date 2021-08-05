<?php

 
$show_per_page = 10;
$comments_query = new WP_Comment_Query;
$comments = $comments_query->query(array(
    'post_id' => get_the_id(),
    'number' => $show_per_page 
));


if ( $comments ) {
   
    foreach ( $comments as $comment ) {
        
?>
<div class="user-info mb-4">
   
<?php 
        
        if(wp_get_attachment_image(get_field('photo', 'user_'.$comment->user_id))){
            $img = wp_get_attachment_image(get_field('photo', 'user_'.$comment->user_id));
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
<h1><?php echo $comment->comment_author; ?></h1>
<p class="mb-0 candidate-location"><span class="dashicons dashicons-location mr-0 pt-1"></span>
            <span><?php
             $location = get_field('location', 'user_'.$comment->user_id);
             $country = $location['country'];
             $state = $location['state'];
             $city = $location['city'];
            if($city){echo $city . ', ';}
            if($state){echo $state . ', ';}
            echo $country; 
             ?></span></p>
    <div class="job-application-btn-wrap">
<a class="application-btn mt-2 mr-2" href="mailto:<?php echo $comment->comment_author_email; ?>?Subject=Re: Your Job application">E-mail candidate</a>
<a class="application-btn mt-2 mr-2" href="<?php echo get_author_posts_url($comment->user_id);  ?>" target="_blank">View resume</a>
    </div>
</div>
<p class="mt-3"><?php echo $comment->comment_content; ?></p>



</div>





<?php

    }
   
}else{//no applications
}

?>