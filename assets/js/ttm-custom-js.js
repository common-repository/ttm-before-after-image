; (function ($) { 
    'use strict';

    $(window).on('load', function () { 
        $(".ttm-before-after-image-container").each(function () {
            if ($(this).attr('ttm-move-slider-on-hover') == 'no') {
                var moveSliderHover = false;
            } else {
                var moveSliderHover = true;
            }

            if ($(this).attr('ttm-overlay') == 'yes') {
                var overlay = false;
            } else {
                var overlay = true;
            }
                                                                          
            if ($(this).attr('ttm-click-to-move') == 'no') {
                var clickToMove = false;
            } else {
                var clickToMove = true;
            }
            
            $(this).ttm({
                orientation: $(this).attr('ttm-orientation'),
                default_offset_pct: $(this).attr('ttm-default-offset'),
                before_label: $(this).attr('ttm-before-label'),
                after_label: $(this).attr('ttm-after-label'),
                no_overlay: overlay,
                move_slider_on_hover: moveSliderHover,
                click_to_move: clickToMove
            });         

            //Label OutSide
            var ttmLabelOutside = $(this).data('label_outside');
            var orientation = $(this).attr('ttm-orientation');
            if (ttmLabelOutside == true && orientation == 'vertical') {
                $('.ttm-outside-label-wrapper.ttm-before-after-image-vertical .ttm-before-after-image-container').css('margin', 50 + 'px' + ' auto');

                $('.ttm-outside-label-wrapper.ttm-before-after-image-vertical .ttm-before-after-overlay>.ttm-before-label').css('display', 'none');
                $('.ttm-outside-label-wrapper.ttm-before-after-image-vertical .ttm-before-after-overlay .ttm-after-label').css('display', 'none');
            }
             
            $(window).trigger("resize.ttm");
        });
        
    });
    
    $(window).on('scroll', function () {
        $(window).trigger("resize.ttm");
    });
    $(document).on('load', function () {
        $(document).trigger("resize.ttm");
    });
 
})(jQuery);
