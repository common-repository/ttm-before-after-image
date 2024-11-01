function ttm_option_tab(evt, cityName) {
    var i, ttm_tabcontent, ttm_tablinks;
    ttm_tabcontent = document.getElementsByClassName("ttm-tabcontent");
    for (i = 0; i < ttm_tabcontent.length; i++) {
        ttm_tabcontent[i].style.display = "none";
    }
    ttm_tablinks = document.getElementsByClassName("ttm-img-tablinks");
    for (i = 0; i < ttm_tablinks.length; i++) {
        ttm_tablinks[i].className = ttm_tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

/*
Conditional fields
*/
function ttm_before_after_method_conditional_field(){
    var ttm_before_after_method = jQuery('input:radio[name=ttm_before_after_method]:checked').val();
    if (ttm_before_after_method == 'method_2') {
        jQuery('.ttm-fade,.ttm-slider-alignment,.ttm-row-no-overlay,.ttm-row-click-to-move,.ttm_move_slider_on_hover,.ttm_on_scroll_slide,.ttm_auto_slide,.ttm_option_label,.ttm-row-offset,.ttm_filter_apply,.ttm_filter_style,.ttm-row-orientation, .ttm-row-template-style, .ttm-row-before-after-image, .ttm_filter_style, .ttm_filter_apply, .ttm-row-before-image, .ttm-row-after-image').show();
        jQuery('.ttm-mid-label-color,.ttm-mid-label-bg,.ttm-row-mid-label,.ttm-row-before-image, .ttm-row-after-image, .ttm-row-first-image,.ttm-row-second-image, .ttm-row-third-image').hide();
    } else if(ttm_before_after_method == 'method_1') {
        jQuery('.ttm-slider-alignment,.ttm-overlay-color, .ttm-row-click-to-move,.ttm_move_slider_on_hover,.ttm_on_scroll_slide,.ttm_auto_slide,.ttm_option_label,.ttm-row-offset,.ttm_filter_apply,.ttm_filter_style,.ttm-row-orientation, .ttm-row-template-style, .ttm-row-before-after-image, .ttm_filter_style, .ttm_filter_apply, .ttm-row-before-image, .ttm-row-after-image').show();
        jQuery('.ttm-mid-label-color,.ttm-mid-label-bg,.ttm-row-mid-label,.ttm-row-before-after-image, .ttm_filter_style, .ttm_filter_apply, .ttm-row-first-image,.ttm-row-second-image, .ttm-row-third-image').hide();
    }else if(ttm_before_after_method == 'method_3'){
        jQuery('.ttm-row-mid-label,.ttm-row-first-image, .ttm-row-second-image, .ttm-row-third-image,.ttm-mid-label-color,.ttm-mid-label-bg').show();
        jQuery('.ttm-fade,.ttm-slider-alignment,.ttm-row-click-to-move,.ttm_move_slider_on_hover,.ttm_on_scroll_slide,.ttm_option_label,.ttm-row-offset,.ttm_filter_apply,.ttm_filter_style,.ttm-row-orientation, .ttm-row-before-after-image, .ttm_filter_style, .ttm_filter_apply, .ttm-row-before-image, .ttm-row-after-image').hide();
        
        //hide for now 3 image
        jQuery('.ttm_slide_handle').hide();
    }
}

function ttm_auto_slide_conditional_field(){
    var ttm_auto_slide = jQuery('input:radio[name=ttm_auto_slide]:checked').val();
    if (ttm_auto_slide == 'true') {
        jQuery('.ttm_move_slider_on_hover').hide();
        //hide for now
        jQuery('.ttm_slide_handle').show();
		jQuery('.ttm_on_scroll_slide').hide();
    } else {
        jQuery('.ttm_move_slider_on_hover').show();
        jQuery('.ttm_slide_handle').hide();
		jQuery('.ttm_on_scroll_slide').show();
    }
	
}

function ttm_on_scroll_slide_conditional_field(){
    var ttm_on_scroll_slide = jQuery('input:radio[name=ttm_on_scroll_slide]:checked').val();
	var ttm_auto_slide = jQuery('input:radio[name=ttm_auto_slide]:checked').val();
	
    if (ttm_on_scroll_slide == 'true' || ttm_auto_slide == 'true') {
		jQuery('.ttm_default_offset_row').hide();
    } else {
		jQuery('.ttm_default_offset_row').show();
    }
	
}

function ttm_readmore_alignment_field(){
    var ttm_width = jQuery('#ttm_slider_info_readmore_button_width option:selected').val();
    if (ttm_width == 'full-width') {
        jQuery('.ttm_slider_info_readmore_alignment').hide();
    } else {
        jQuery('.ttm_slider_info_readmore_alignment').show();
    }
}

//label outside image condtional display
function ttm_label_outside_conditional_display(){
    var ttm_label_outside_option = jQuery('input:radio[name=ttm_image_styles]:checked').val();
    if(ttm_label_outside_option == 'vertical'){
        jQuery('.ttm_label_outside').show();
    }else{
        jQuery('.ttm_label_outside').hide();
    }
}

jQuery('input:radio[name=ttm_image_styles]').on('change',function(){
    ttm_label_outside_conditional_display();
});



jQuery('input:radio[name=ttm_on_scroll_slide]').on('change', function () {
    ttm_on_scroll_slide_conditional_field();
});

jQuery('input:radio[name=ttm_auto_slide]').on('change', function () {
    ttm_auto_slide_conditional_field();
	ttm_on_scroll_slide_conditional_field();
    var ttm_before_after_method = jQuery('input:radio[name=ttm_before_after_method]:checked').val();
    if( ttm_before_after_method == 'method_3' ){
        //hide for now - 3 image
        jQuery('.ttm_slide_handle').hide();
        jQuery('.ttm_on_scroll_slide').hide();
        jQuery('.ttm_move_slider_on_hover').hide();
    }
});

jQuery('input:radio[name=ttm_before_after_method]').on('change', function () {
    ttm_before_after_method_conditional_field();
});

jQuery(document).ready(function(){
    ttm_on_scroll_slide_conditional_field();
	ttm_auto_slide_conditional_field();
	ttm_readmore_alignment_field();
    ttm_label_outside_conditional_display();
    ttm_before_after_method_conditional_field();
});

jQuery('#ttm_slider_info_readmore_button_width').on('change', function(){
	ttm_readmore_alignment_field();
});

// Uploading files
var ttm_before_file_frame;
jQuery('#ttm_before_image_upload').on('click', function (e) {
    e.preventDefault();

    // If the media frame already exists, reopen it.
    if ( ttm_before_file_frame ) {
        ttm_before_file_frame.open();
        return;
    }

    // Create the media frame.
    ttm_before_file_frame = wp.media.frames.ttm_before_file_frame = wp.media({
        title: jQuery(this).data('uploader_title'),
        button: {
            text: jQuery(this).data('uploader_button_text'),
        },
        multiple: false // Set to true to allow multiple files to be selected
    });

    // When a file is selected, run a callback.
    ttm_before_file_frame.on('select', function () {
        // We set multiple to false so only get one image from the uploader
        attachment = ttm_before_file_frame.state().get('selection').first().toJSON();

        var url = attachment.url;

        //var field = document.getElementById("podcast_file");
        var field = document.getElementById('ttm_before_image');
        var thumbnail = document.getElementById('ttm_before_image_thumbnail');
        //get and place the alter title of uploaded image
        var alt = document.getElementById('ttm_img_alt');
        alt.value = attachment.alt;
        field.value = url;
        thumbnail.setAttribute('src',url);
    });

    // Finally, open the modal
    ttm_before_file_frame.open();
});


var ttm_after_file_frame;
jQuery('#ttm_after_image_upload').on('click', function (e) {
    e.preventDefault();

    // If the media frame already exists, reopen it.
    if (ttm_after_file_frame) {
        ttm_after_file_frame.open();
        return;
    }

    // Create the media frame.
    ttm_after_file_frame = wp.media.frames.ttm_after_file_frame = wp.media({
        title: jQuery(this).data('uploader_title'),
        button: {
            text: jQuery(this).data('uploader_button_text'),
        },
        multiple: false // Set to true to allow multiple files to be selected
    });

    // When a file is selected, run a callback.
    ttm_after_file_frame.on('select', function () {
        // We set multiple to false so only get one image from the uploader
        attachment = ttm_after_file_frame.state().get('selection').first().toJSON();

        var url = attachment.url;
    
        var field = document.getElementById('ttm_after_image');
        var thumbnail = document.getElementById('ttm_after_image_thumbnail');

        //get and place the alter title of uploaded image
        var alt = document.getElementById('after_img_alt');
        alt.value = attachment.alt;
                field.value = url;
        thumbnail.setAttribute('src',url);
    });

    // Finally, open the modal
    ttm_after_file_frame.open();
});

/*
Color picker
*/
jQuery('.ttm-color-field').each(function () {
    jQuery(this).wpColorPicker();
});




//opacity range slider
var slider = document.querySelector("#ttm-wm-opacity");
var output = document.querySelector(".ttm-wm-range-val");
if(slider){
    output.innerHTML = slider.value;

    slider.oninput = function() {
      output.innerHTML = this.value;
      slider.setAttribute( 'value',this.value);
    }
}
(jQuery);
