<?php
get_header();
?>
<h1 class="about"><?php echo wp_title(''); ?></h1>
<div class="content privacy">
        
        <div class="container privacy-policy-container">
<?php

while(have_posts()){
    the_post();

    the_content();
?>
        </div>
</div>
<?php
}


get_footer();
?>