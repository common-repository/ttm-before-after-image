<?php
// Exit if accessed directly

if (!defined('ABSPATH')) {
	exit();
}

function ttmbai_admin_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
	wp_enqueue_script( 'ttm-media-script' );
}

function ttmbai_admin_styles() {
    wp_enqueue_style('thickbox');
}
add_action('admin_print_scripts', 'ttmbai_admin_scripts');
add_action('admin_print_styles', 'ttmbai_admin_styles');

//Register Meta box
add_action('add_meta_boxes', function (){
    add_meta_box('ttm-img-metabox','Before After Image Options','ttmbai_img_metabox_callback','ttm-before-after','normal','high');
    add_meta_box('ttm_img_shortcode_metabox','Shortcode','ttmbai_shortcode_callback','ttm-before-after','side','high');
});

//Metabox content

if( !function_exists('ttmbai_img_metabox_callback') ){
function ttmbai_img_metabox_callback($post){
    ob_start();
?>
<div class="ttm-tab">
    <a class="ttm-img-tablinks active" onclick="ttm_option_tab(event, 'ttm_gallery_content')"><?php echo esc_html__('Content','ttm-before-after'); ?></a>
    <a class="ttm-img-tablinks" onclick="ttm_option_tab(event, 'ttm_gallery_style')"><?php echo esc_html__('Slider Style','ttm-before-after'); ?></a>
    <a class="ttm-img-tablinks" onclick="ttm_option_tab(event, 'ttm_gallery_options')"><?php echo esc_html__('Extra Options','ttm-before-after'); ?></a>
</div>


<div id="ttm_gallery_content" class="ttm-tabcontent" style="display: block;">
    <table class="ttm-option-table">

        <?php 
            $ttm_img_alt = get_post_meta( $post->ID, 'ttm_img_alt', true) ? get_post_meta( $post->ID, 'ttm_img_alt', true) : '';
            $after_img_alt = get_post_meta( $post->ID, 'after_img_alt', true) ? get_post_meta( $post->ID, 'after_img_alt', true) : '';
        ?>

        <tr class="ttm-row-before-image">
            <td class="ttm-option-label">
                <p><label><?php echo esc_html__('Before Image','ttm-before-after'); ?></label></p>
            </td>
            <td class="ttm-option-content">
                <input type="text" name="ttm_before_image" id="ttm_before_image" size="50" value="<?php echo esc_url(get_post_meta( $post->ID, 'ttm_before_image', true )); ?>" />
                <input class="ttm_button" id="ttm_before_image_upload" type="button" value="Upload Image">
                <img id="ttm_before_image_thumbnail" src="<?php echo esc_url(get_post_meta( $post->ID, 'ttm_before_image', true )); ?>">
                <?php 
                ob_start();
                ?>
                <div class="img-alt-tag">
                    <span><?php esc_html_e( 'Alter Text: ' ); ?></span>
                    <input type="text" name="ttm_img_alt" id="ttm_img_alt" value="<?php echo esc_attr( $ttm_img_alt ); ?>" />
                </div>
            </td>
        </tr>
        <tr class="ttm-row-after-image">
            <td class="ttm-option-label"><label for="ttm_before_after_method"> <p><label><?php echo esc_html__('After Image','ttm-before-after'); ?></label></p></td>
            <td class="ttm-option-content">
                <input type="text" name="ttm_after_image" id="ttm_after_image" size="50" value="<?php echo esc_url(get_post_meta( $post->ID, 'ttm_after_image', true )); ?>" />
                <input class="ttm_button" id="ttm_after_image_upload" type="button" value="Upload Image">
                <img id="ttm_after_image_thumbnail" src="<?php echo esc_url(get_post_meta( $post->ID, 'ttm_after_image', true )); ?>">
                <?php 
                ob_start();
                ?>
                 <div class="img-alt-tag">
                    <span><?php esc_html_e( 'Alter Text: ' ); ?></span>
                    <input type="text" name="after_img_alt" id="after_img_alt" value="<?php echo esc_attr( $after_img_alt ); ?>" />
                </div>
            </td>
        </tr>

        <tr class="ttm-row-orientation">
            <td class="ttm-option-label"><label><?php echo esc_html__('Select Direction','ttm-before-after'); ?></label></td>
            <td class="ttm-option-content">
                <ul class="orientation-style">
                    <?php 
                    $orientation = trim(get_post_meta( $post->ID, 'ttm_image_styles', true )) != '' ? get_post_meta( $post->ID, 'ttm_image_styles', true ) : 'horizontal';
                    ?>
                    <li><input type="radio" name="ttm_image_styles" id="ttm_image_styles1" value="vertical" <?php checked( $orientation, 'vertical' ); ?>> <label for="ttm_image_styles1"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../assets/image/vertical.png'); ?>" /></label></li>

                    <li><input type="radio" name="ttm_image_styles" id="ttm_image_styles2" value="horizontal" <?php checked( $orientation, 'horizontal' ); ?>> <label for="ttm_image_styles2"><img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'../assets/image/horizontal.png'); ?>" /></label></li>
                </ul>
            </td> 
        </tr>
       
    </table>
</div>

<div id="ttm_gallery_options" class="ttm-tabcontent">
    <table class="ttm-option-table">
        <tr class="ttm-row-b-label">
            <td class="ttm-option-label"><label for="ttm_before_label"><?php echo esc_html__('Before Label Text','ttm-before-after'); ?></label></td>
            <td class="ttm-option-content">
               <?php 
                $ttm_before_label = !empty(get_post_meta( $post->ID, 'ttm_before_label', true )) ? get_post_meta( $post->ID, 'ttm_before_label', true ) : '';
                ?>
                <input type="text" class="regular-text" placeholder="Before" name="ttm_before_label" id="ttm_before_label" value="<?php echo esc_html($ttm_before_label); ?>" >
            </td>
        </tr>
       
        <tr class="ttm-row-a-label">
            <td class="ttm-option-label"><label for="ttm_after_label"><?php echo esc_html__('After Label Text','ttm-before-after'); ?></label></td>
            <td class="ttm-option-content">
               <?php 
                $ttm_after_label = !empty(get_post_meta( $post->ID, 'ttm_after_label', true )) ? get_post_meta( $post->ID, 'ttm_after_label', true ) : '';
                ?>
                <input type="text" class="regular-text" placeholder="After" name="ttm_after_label" id="ttm_after_label" value="<?php echo esc_html($ttm_after_label); ?>">
            </td>
        </tr>

        <?php
        ob_start();
        ?>
        <tr class="ttm-row-offset">
            <td class="ttm-option-label"><label for="ttm_default_offset"><?php echo esc_html__('Offset Value','ttm-before-after'); ?></label></td>
            <td class="ttm-option-content">
               <?php 
                $ttm_default_offset = !empty(get_post_meta( $post->ID, 'ttm_default_offset', true )) ? get_post_meta( $post->ID, 'ttm_default_offset', true ) : '0.5';
                
                ?>
                <input type="text" class="regular-text" name="ttm_default_offset" id="ttm_default_offset" value="<?php echo esc_attr($ttm_default_offset); ?>">
            </td>
        </tr>
     
    </table>
</div>

<div id="ttm_gallery_style" class="ttm-tabcontent">
    <table class="ttm-option-table">
        <tr class="ttm-before-label-bg">
            <td class="ttm-option-label">
                <label for="ttm_before_label_background"><?php echo esc_html__('Before Label Background','ttm-before-after'); ?></label>
            </td>
            <?php 
            $ttm_before_label_background = !empty(get_post_meta( $post->ID, 'ttm_before_label_background', true )) ? get_post_meta( $post->ID, 'ttm_before_label_background', true ) : '';
            ?>
            <td class="ttm-option-content"><input id="ttm_before_label_background" class="ttm-color-field" type="text" name="ttm_before_label_background" value="<?php echo esc_attr($ttm_before_label_background); ?>" /></td>
        </tr>
        <tr class="ttm-before-label-color" >
            <td class="ttm-option-label">
                <label for="ttm_before_label_color"><?php echo esc_html__('Before Text Color','ttm-before-after'); ?></label>
            </td>
            <?php 
            $ttm_before_label_color = !empty(get_post_meta( $post->ID, 'ttm_before_label_color', true )) ? get_post_meta( $post->ID, 'ttm_before_label_color', true ) : '';
            ?>
            <td class="ttm-option-content"><input id="ttm_before_label_color" class="ttm-color-field" type="text" name="ttm_before_label_color" value="<?php echo esc_attr($ttm_before_label_color); ?>" /></td>
        </tr>
        <tr class="ttm-after-label-bg">
            <td class="ttm-option-label">
                <label for="ttm_after_label_background"><?php echo esc_html__('After Label Background','ttm-before-after'); ?></label>
            </td>
            <?php 
            $ttm_after_label_background = !empty(get_post_meta( $post->ID, 'ttm_after_label_background', true )) ? get_post_meta( $post->ID, 'ttm_after_label_background', true ) : '';
            ?>
            <td class="ttm-option-content"><input id="ttm_after_label_background" class="ttm-color-field" type="text" name="ttm_after_label_background" value="<?php echo esc_attr($ttm_after_label_background); ?>" /></td>
        </tr>
        <tr class="ttm-after-label-color">
            <td class="ttm-option-label">
                <label for="ttm_after_label_color"><?php echo esc_html__('After Text Color','ttm-before-after'); ?></label>
            </td>
            <?php 
            $ttm_after_label_color = !empty(get_post_meta( $post->ID, 'ttm_after_label_color', true )) ? get_post_meta( $post->ID, 'ttm_after_label_color', true ) : '';
            ?>
            <td class="ttm-option-content"><input id="ttm_after_label_color" class="ttm-color-field" type="text" name="ttm_after_label_color" value="<?php echo esc_attr($ttm_after_label_color); ?>" /></td>
        </tr>
    </table>
</div>
<?php
	// Noncename needed to verify where the data originated
	wp_nonce_field( 'ttm_meta_box_nonce', 'ttm_meta_box_noncename' );
?>
<?php

$contents = ob_get_clean();

echo trim(apply_filters( 'ttmbai_meta_fields', $contents, $post ));

}
}

//Metabox shortcode
function ttmbai_shortcode_callback(){
    $ttm_scode = isset($_GET['post']) ? '[ttm-before-after id="'.$_GET['post'].'"]' : '';
    ?>
    <input type="text" name="ttm_display_shortcode" class="ttm_display_shortcode" value="<?php echo esc_attr($ttm_scode); ?>" readonly>
    <?php
}


//save all meta value

add_action('save_post', 'ttmbai_save_postdata');

function ttmbai_save_postdata ( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    if ( ! isset( $_POST[ 'ttm_meta_box_noncename' ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['ttm_meta_box_noncename'] ) ), 'ttm_meta_box_nonce' ) )
        return;

    if ( ! current_user_can( 'edit_posts' ) )
        return;

    if( isset($_POST['ttm_before_image']) ){
        update_post_meta( $post_id, 'ttm_before_image', esc_url_raw( $_POST['ttm_before_image'] ) );
    }
    if( isset($_POST['ttm_after_image']) ){
        update_post_meta( $post_id, 'ttm_after_image', esc_url_raw( $_POST['ttm_after_image'] ) );
    }
    if( isset($_POST['ttm_image_styles']) ){
        update_post_meta( $post_id, 'ttm_image_styles', esc_html( sanitize_text_field($_POST['ttm_image_styles'] )) );
    }
    if( isset($_POST['ttm_default_offset']) ){
        update_post_meta( $post_id, 'ttm_default_offset', esc_html( sanitize_text_field($_POST['ttm_default_offset'] )) );
    }
    if( isset($_POST['ttm_before_label']) ){
        update_post_meta( $post_id, 'ttm_before_label', esc_html( sanitize_text_field($_POST['ttm_before_label'] ) ) );
    }
    if( isset($_POST['ttm_after_label']) ){
        update_post_meta( $post_id, 'ttm_after_label', esc_html( sanitize_text_field($_POST['ttm_after_label'] )) );
    }
    if( isset($_POST['ttm_before_label_background']) ){
        update_post_meta( $post_id, 'ttm_before_label_background', esc_html( sanitize_text_field($_POST['ttm_before_label_background'] ) ) );
    } 
    if( isset($_POST['ttm_before_label_color']) ){
        update_post_meta( $post_id, 'ttm_before_label_color', esc_html( sanitize_hex_color($_POST['ttm_before_label_color'] ) ) );
    }
    if( isset($_POST['ttm_after_label_background']) ){
        update_post_meta( $post_id, 'ttm_after_label_background', esc_html( sanitize_text_field($_POST['ttm_after_label_background'] )) );
    }
    
    if( isset($_POST['ttm_after_label_color']) ){
        update_post_meta( $post_id, 'ttm_after_label_color', esc_html( sanitize_hex_color($_POST['ttm_after_label_color'] ) ) );
    }   
    if( isset($_POST['ttm_img_alt']) ){
        update_post_meta( $post_id, 'ttm_img_alt', esc_html( sanitize_text_field($_POST['ttm_img_alt'] )) );
    }
    if( isset($_POST['after_img_alt']) ){
        update_post_meta( $post_id, 'after_img_alt', esc_html( sanitize_text_field($_POST['after_img_alt'] )) );
    }

    do_action( 'ttm_save_post_meta', $post_id );

}