<?php
/**
 * Plugin Name: TTM - Before After Image
 * Plugin URI:https://wordpress.org/plugins/ttm-before-after-image/
 * Description: Need to show the differences between two images? Makes it easy with TTM before After image.
 * Version: 1.0.1
 * Author: Preyantechnosys
 * Author URI: https://wordpress.org/themes/author/preyantechnosys/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: ttm-before-after
 * Domain Path: /languages
 * Requires at least: 6.6
 * Requires PHP: 7.4
 */

// ABSPATH
if (!defined('ABSPATH')) {
    exit();
}

define( 'TTMBAI_VERSION', '1.0.1' );
define( 'TTMBAI_DIR', trailingslashit( dirname( __FILE__ ) ) );
define( 'TTMBAI_URI', plugins_url( '', __FILE__ ) );
define( 'TTMBAI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

class TTMBAI_Before_After_Image {
    
    public function __construct(){

		add_action( 'wp_enqueue_scripts', array($this, 'ttmbai_before_after_image_foucs_scripts'), 999 ); 
        
        if ( did_action( 'elementor/loaded' ) ) {
            add_action( 'elementor/editor/before_enqueue_scripts', array($this, 'ttmbai_before_after_image_foucs_scripts') );
        }
		
		require_once TTMBAI_DIR . 'custom-post-types/tm-before-after.php';
		require_once TTMBAI_DIR . 'admin/action.php';
		require_once TTMBAI_DIR . 'admin/ttm-metabox.php';

        /* Adding shortcode for before after image  */
        add_shortcode('ttm-before-after', array( $this, 'ttmbai_before_afetr_shortcode' ));
    }
    
    /* Enqueue css and js for frontend  */
    public function ttmbai_before_after_image_foucs_scripts() {
        
        wp_enqueue_style( 'ttm_style_path', plugin_dir_url( __FILE__ ) . 'assets/css/before-after-img.css'); 
        wp_enqueue_style( 'ttm-style', plugin_dir_url( __FILE__ ) . 'assets/css/ttm-style.css'); 
        wp_enqueue_style( 'ttm-style', plugin_dir_url( __FILE__ ) . 'assets/css/ttm-admin-main.css'); 
        wp_enqueue_script( 'eventMove', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.event.move.js', array('jquery'));
        wp_enqueue_script( 'ttm_style_path', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.before-after-img.js', array('jquery','eventMove'));
        wp_enqueue_script( 'ttm_custom_js', plugin_dir_url( __FILE__ ) . 'assets/js/ttm-custom-js.js', array('jquery','ttm_style_path'), null, true );       
        wp_localize_script('ttm_custom_js','ttm_constant_obj',
            array( 
                'ajax_url'  => admin_url( 'admin-ajax.php' ),
                'site_url' => plugin_dir_url(__FILE__)
            )
        );
    }

    /*
     metabox included
    */
    public function ttmbai_meta_fields(){
        require_once('admin/ttm-metaboxs.php');
    }

    /*
    * ttmbai_before_afetr_shortcode callback
    */
    public function ttmbai_before_afetr_shortcode( $atts, $content = null ){

        extract( shortcode_atts(array(
            'id' => ''
        ), $atts) );
        
        ob_start();
        
        $before_image         = get_post_meta( $id, 'ttm_before_image', true);
        $after_image          = get_post_meta( $id, 'ttm_after_image', true);
        $orientation          = !empty(get_post_meta( $id, 'ttm_image_styles', true)) ? get_post_meta( $id, 'ttm_image_styles', true) : 'horizontal';
        $offset               = !empty(get_post_meta( $id, 'ttm_default_offset', true)) ? get_post_meta( $id, 'ttm_default_offset', true) : '0.5';
        $before_label         = !empty(get_post_meta( $id, 'ttm_before_label', true)) ? get_post_meta( $id, 'ttm_before_label', true) : '';
        $after_label          = !empty(get_post_meta( $id, 'ttm_after_label', true)) ? get_post_meta( $id, 'ttm_after_label', true) : '';
        $overlay              = !empty(get_post_meta( $id, 'ttm_no_overlay', true)) ? get_post_meta( $id, 'ttm_no_overlay', true) : 'no';
        $move_slider_on_hover = !empty(get_post_meta( $id, 'ttm_move_slider_on_hover', true)) ? get_post_meta( $id, 'ttm_move_slider_on_hover', true) : 'no';
        $click_to_move        = !empty(get_post_meta( $id, 'ttm_click_to_move', true)) ? get_post_meta( $id, 'ttm_click_to_move', true) : 'no';
        $ttm_img_alt       = get_post_meta( $id, 'ttm_img_alt', true) ? get_post_meta( $id, 'ttm_img_alt', true) : '';
        $after_img_alt        = get_post_meta( $id, 'after_img_alt', true) ? get_post_meta( $id, 'after_img_alt', true) : '';

        if(get_post_status($id) == 'publish' ) :
        ?>

        <?php do_action('ttm_before_slider', $id); ?>

        <div class="ttm-before-after-image-container <?php echo esc_attr('slider-'.$id.''); ?> <?php if(get_post_meta($id, 'ttm_custom_color', true) == 'yes') echo esc_html('ttm-custom-color'); ?>" ttm-orientation="<?php echo esc_attr($orientation); ?>" ttm-default-offset="<?php echo esc_attr($offset); ?>" ttm-before-label="<?php echo esc_attr__( $before_label,'ttm-before-after' ); ?>" ttm-after-label="<?php echo esc_attr__( $after_label,'ttm-before-after' ); ?>" ttm-overlay="<?php echo esc_attr($overlay); ?>" ttm-move-slider-on-hover="<?php echo esc_attr($move_slider_on_hover); ?>" ttm-click-to-move="<?php echo esc_attr($click_to_move); ?>">
            
            <img src="<?php echo esc_url($before_image); ?>" alt="<?php echo esc_attr( $ttm_img_alt ); ?>">
            <img src="<?php echo esc_url($after_image); ?>" alt="<?php echo esc_attr( $after_img_alt ); ?>">
           
        </div>

        <?php do_action('ttm_after_slider', $id); ?>

        <style type="text/css">
            <?php $ttm_before_label_background= !empty(get_post_meta($id, 'ttm_before_label_background', true)) ? get_post_meta($id, 'ttm_before_label_background', true) : '';

            $ttm_before_label_color= !empty(get_post_meta($id, 'ttm_before_label_color', true)) ? get_post_meta($id, 'ttm_before_label_color', true) : '';

            $ttm_after_label_background= !empty(get_post_meta($id, 'ttm_after_label_background', true)) ? get_post_meta($id, 'ttm_after_label_background', true) : '';

            $ttm_after_label_color= !empty(get_post_meta($id, 'ttm_after_label_color', true)) ? get_post_meta($id, 'ttm_after_label_color', true) : '';

            ?><?php if( !empty($ttm_before_label_background) || !empty($ttm_before_label_color)) {
                ?>.<?php echo esc_attr('slider-'.$id.' ');

                ?>.ttm-before-label::before {
                    background: <?php echo esc_attr($ttm_before_label_background);
                    ?>;
                    color: <?php echo esc_attr($ttm_before_label_color);
                    ?>;
                }

                <?php
            }

            ?><?php if( !empty($ttm_after_label_background) || !empty($ttm_after_label_color)) {
                ?>.<?php echo esc_attr('slider-'.$id.' ');

                ?>.ttm-after-label::before {
                    background: <?php echo esc_attr($ttm_after_label_background);
                    ?>;
                    color: <?php echo esc_attr($ttm_after_label_color);
                    ?>;
                }

                <?php
            }

            ?>

        </style>
        <?php
        endif;   
        return ob_get_clean();
    }
    
}

new TTMBAI_Before_After_Image();