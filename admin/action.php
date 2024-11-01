<?php

if (!defined('ABSPATH')) {
	exit();
}

/**
 * Custom Post Type add Subpage to Custom Post Menu
 */

function ttmbai_before_afetr_options_page() {
    add_submenu_page(
        'edit.php?post_type=ttm-before-after', //$parent_slug
        'manage_options', //$capability
        'ttm_settings', //$menu_slug
        'ttmbai_settings_page_callback', //$function
        3
    );
}
add_action( 'admin_menu', 'ttmbai_before_afetr_options_page' );


function ttmbai_settings_page_callback() {

}

// Show column in the admin section
add_filter('manage_ttm-before-after_posts_columns', 'ttmbai_set_custom_columns', 10);  
add_action('manage_posts_custom_column', 'ttmbai_set_featured_image_column', 10, 2);  
add_action('manage_posts_custom_column', 'ttmbai_set_columns_shortcode', 10, 2);  

function ttmbai_set_custom_columns($columns) {
   $columns = array(
      'cb'			  => '<input type="checkbox" />',
      'title'		  => esc_html__('Title', 'ttm-before-after'),
      'before_image'  => esc_html__('Before Image', 'ttm-before-after'),
      'after_image'   => esc_html__('After Image', 'ttm-before-after'),
	  'ttm_shortcode' => esc_html__('Shortcode', 'ttm-before-after'),
   );
  return $columns;
}

// Show Featured image in the admin section
function ttmbai_set_featured_image_column($column_name, $id){ 

  //Before Image column in posts
  if($column_name === 'before_image') {
     $image_url = get_post_meta($id, 'ttm_before_image', true); 	
  	 $image_id = attachment_url_to_postid( $image_url );
  	 $before_image = wp_get_attachment_image( $image_id, 'thumbnail');
  	 echo wp_kses_post($before_image);
  }

  //After Image column in posts
  if($column_name === 'after_image') {
	$image_url = get_post_meta($id, 'ttm_after_image', true);
	$image_id = attachment_url_to_postid( $image_url );
	$after_image = wp_get_attachment_image( $image_id, 'thumbnail');
	echo wp_kses_post($after_image);
}
}

//Shortcode in column in posts
function ttmbai_set_columns_shortcode($column_name, $id){  
  if($column_name === 'ttm_shortcode') { 
   $post_id =	$id;
   $shortcode = 'ttm-before-after id="' . $post_id . '"';
      echo esc_attr('[' . $shortcode .']');   
  }  
}

/**
 *  admin scripts
 */
 
function ttmbai_media_enqueue_script() {
	wp_enqueue_media();
	wp_enqueue_script( 'ttm-media-script' );
	wp_enqueue_script( 'wp-color-picker-alpha', plugins_url( '../assets/js/wp-color-picker-alpha.min.js',__FILE__ ), array( 'wp-color-picker' ), null, true );   
	wp_enqueue_script( 'custom_js', plugins_url( '../assets/js/ttm-script.js', __FILE__ ), array('jquery','wp-color-picker','wp-color-picker-alpha'), null, true );
	wp_enqueue_style('ttm_admin_style', plugins_url( '../assets/css/ttm-admin-main.css', __FILE__ ));
}
add_action('admin_enqueue_scripts', 'ttmbai_media_enqueue_script');