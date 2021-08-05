<?php
function scripts_and_styles() {
  wp_enqueue_script('poppers.js', get_theme_file_uri('/js/poppers-1.14.7.js'), NULL, true);
  wp_enqueue_script('bootstrap.js', get_theme_file_uri('/js/bootstrap-4.3.1.js'), array('jquery'), NULL, true);
  wp_enqueue_script('lightslider.js', get_theme_file_uri('/js/lightslider.js'), array('jquery'), NULL, false);
  wp_enqueue_script('custom.js', get_theme_file_uri('/js/custom.js'), array('jquery'), NULL, true);

  wp_enqueue_style('bootstrap.css', get_theme_file_uri('/css/bootstrap-4.3.1.css'));
  wp_enqueue_style('lightslider.css', get_theme_file_uri('/css/lightslider.css'));
  wp_enqueue_style('google_fonts', '//fonts.googleapis.com/css?family=Poppins:400,500,700&display=swap');
  wp_enqueue_style('dashicons');
  wp_enqueue_style('style.css', get_stylesheet_uri());

  wp_localize_script('custom.js', 'customData', array(
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));
}
add_action('wp_enqueue_scripts', 'scripts_and_styles');

function login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style.css' );
}
add_action( 'login_enqueue_scripts', 'login_stylesheet' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return get_bloginfo('name');
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

// Theme support
register_nav_menus(
  array(
  'primary-menu' => __( 'Primary Menu' ),
  'secondary-menu' => __( 'Secondary Menu' )
  )
);

//// Taxonomies

// Register Custom Taxonomy
function custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Skills', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Skill', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Skills', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
  register_taxonomy( 'skill', array( 'post', 'job' ), $args );
  
  $labels = array(
		'name'                       => _x( 'Job type', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Job type', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Job type', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'view_item'                  => __( 'View Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Items', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Items list', 'text_domain' ),
		'items_list_navigation'      => __( 'Items list navigation', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'Job type', array( 'post', 'job' ), $args );

}
add_action( 'init', 'custom_taxonomy', 0 );



// Custom post types

add_action('init', 'custom_post_types');

function custom_post_types(){
  register_post_type('job', array(
	  'show_in_rest' => true,
    'supports' => array('title', 'comments'),
    'rewrite' => array('slug' => 'jobs'),
    'has_archive' => true,
    'public' => true,
    'map_meta_cap' => true,
	'capability_type' => 'job',
    'labels' => array(
      'name' => 'Jobs',
      'add_new_item' => 'Add New Job',
      'edit_item' => 'Edit Job',
      'all_items' => 'All Jobs',
      'singular_name' => 'Job'
    ),
    'menu_icon' => 'dashicons-megaphone'
  ));
}

// Disable admin bar for users

add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

// Restrict wp-admin access to users, and redirect from backend when email or password change

function restrict_wp_admin() {
	if ( is_admin() && !current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_redirect( esc_url(site_url('/')) );
		exit;
	}
}
add_action( 'profile_update', 'restrict_wp_admin' );



// Login redirect

if(!current_user_can('administrator')):
 add_filter('login_redirect', 'user_login_redirect');

  function user_login_redirect(){

      return esc_url(site_url('/'));
      exit;  

  }
endif;

// default comments on for cpt job

function default_comments_on( $data ) {
    if( $data['post_type'] == 'job' ) {
        $data['comment_status'] = 'open';
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'default_comments_on' );


// Remove the logout link in comment form
add_filter( 'comment_form_logged_in', '__return_empty_string' );


// register google maps api key for acf

function my_acf_google_map_api( $api ){
  $api['key'] = 'xxx';
  return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

// delete old photo when user uploads new photo
function wpse_83587_delete_image( $value, $post_id, $field  ) {
    $old_value = get_field( $field['name'], $post_id, false );

    if ( $old_value && ( int ) $old_value !== ( int ) $value )
        wp_delete_attachment( $old_value, true );

    return $value;
}

add_filter( 'acf/update_value/type=image', 'wpse_83587_delete_image', 10, 3 );

//custom rest hob applications

function wpse_20160421_get_author_meta($object, $field_name, $request) {

    $user_data = get_userdata($object['author']); // get user data from author ID.

    $array_data = (array)($user_data->data); // object to array conversion.

    $array_data['first_name'] = get_user_meta($object['author'], 'first_name', true);
    $array_data['last_name']  = get_user_meta($object['author'], 'last_name', true);
    $photoid  = get_user_meta($object['author'], 'photo', true);
    $array_data['photo']  = wp_get_attachment_image($photoid);
    $array_data['location']  = get_user_meta($object['author'], 'location', true);

    // prevent user enumeration.
    unset($array_data['user_login']);
    unset($array_data['user_pass']);
    unset($array_data['user_activation_key']);

    return array_filter($array_data);

}

function wpse_20160421_register_author_meta_rest_field() {

    register_rest_field('comment', 'author_meta', array(
        'get_callback'    => 'wpse_20160421_get_author_meta',
        'update_callback' => null,
        'schema'          => null,
    ));

}
add_action('rest_api_init', 'wpse_20160421_register_author_meta_rest_field');

// Change to and from email settings

function change_from_email( $original ) {
	return get_option('admin_email');;
}
add_filter( 'wp_mail_from', 'change_from_email' );

function change_from_name( $original ) {
	return get_bloginfo('name');
}
add_filter( 'wp_mail_from_name', 'change_from_name' );






