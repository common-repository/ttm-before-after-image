<?php  
// ABSPATH
if (!defined('ABSPATH')) {
    exit();
}

function ttmbai_cpt_before_after(){
	
        $ttm_publicly_queriable = is_array(get_option('ttm_tools')) && !empty(get_option('ttm_tools')['ttm_publicly_queriable']) ? get_option('ttm_tools')['ttm_publicly_queriable'] : '';
        if($ttm_publicly_queriable == 'on'){
            $ttm_publicly_queriable = false;
        }else{
            $ttm_publicly_queriable = true;
        }
        register_post_type( 'ttm-before-after',
            array(
                'labels' => array(
                    'name'               => _x( 'TTM Before After Image', 'ttm-before-after' ),
                    'singular_name'      => _x( 'TTM Before After Image', 'ttm-before-after' ),
                    'add_new'            => __( 'Add New', 'ttm-before-after' ),
                    'add_new_item'       => __( 'Add New Slider', 'ttm-before-after' ),
                    'new_item'           => __( 'New Slider', 'ttm-before-after' ),
                    'edit_item'          => __( 'Edit Slider', 'ttm-before-after' ),
                    'view_item'          => __( 'View Slider', 'ttm-before-after' ),
                    'all_items'          => __( 'All Sliders', 'ttm-before-after' ),
                    'search_items'       => __( 'Search Sliders', 'ttm-before-after' ),
                    'not_found'          => __( 'No slider found.', 'ttm-before-after' ),
                    'not_found_in_trash' => __( 'No slider found in Trash.', 'ttm-before-after' ),
                ),
                'public'              => false,
                'publicly_queryable'  => apply_filters( 'ttm_publicly_queryable', $ttm_publicly_queriable ),
                'show_ui'             => true,
                'exclude_from_search' => true,
                'show_in_nav_menus'   => false,
                'has_archive'         => false,
                'rewrite'             => false,
                'supports'            => apply_filters('ttm_post_type_supports', array('title')),
                'menu_icon'           => 'dashicons-image-flip-horizontal'
            )
        );

        // Register Custom Taxonomy
        $labels = array(
            'name'                       => _x( 'Categories', 'Taxonomy General Name', 'ttm-before-after' ),
            'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'ttm-before-after' ),
            'menu_name'                  => __( 'Category', 'ttm-before-after' ),
            'all_items'                  => __( 'All Items', 'ttm-before-after' ),
            'parent_item'                => __( 'Parent Item', 'ttm-before-after' ),
            'parent_item_colon'          => __( 'Parent Item:', 'ttm-before-after' ),
            'new_item_name'              => __( 'New Item Name', 'ttm-before-after' ),
            'add_new_item'               => __( 'Add New Item', 'ttm-before-after' ),
            'edit_item'                  => __( 'Edit Item', 'ttm-before-after' ),
            'update_item'                => __( 'Update Item', 'ttm-before-after' ),
            'view_item'                  => __( 'View Item', 'ttm-before-after' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'ttm-before-after' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'ttm-before-after' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'ttm-before-after' ),
            'popular_items'              => __( 'Popular Items', 'ttm-before-after' ),
            'search_items'               => __( 'Search Items', 'ttm-before-after' ),
            'not_found'                  => __( 'Not Found', 'ttm-before-after' ),
            'no_terms'                   => __( 'No items', 'ttm-before-after' ),
            'items_list'                 => __( 'Items list', 'ttm-before-after' ),
            'items_list_navigation'      => __( 'Items list navigation', 'ttm-before-after' ),
        );

        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );

        register_taxonomy( 'ttm_gallery', array( 'ttm-before-after' ), $args );
}
add_action( 'init', 'ttmbai_cpt_before_after', 8 );