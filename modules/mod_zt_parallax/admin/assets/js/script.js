jQuery(document).ready(function(){
    //Slider source
	jQuery('#jform_params_asset-lbl').parent().hide();
    ZTSlideShow_SourceChange(jQuery('#jform_params_slider_source').val());
    jQuery('#jform_params_slider_source').change(function(){
        ZTSlideShow_SourceChange(jQuery(this).val());
    })
})
function ZTSlideShow_SourceChange(source){
    switch(source){
        case '1':
            jQuery('#jform_params_ztcategory').parents('li').css({display:'block'});
            jQuery('#jform_params_ztk2_categories').parents('li').css({display:'none'});
            jQuery('#jform_params_ztrss_link').parents('li').css({display:'none'});
            jQuery('#jform_params_ztexternal_link').parents('li').css({display:'none'});
            break;
        case '2':
           jQuery('#jform_params_ztcategory').parents('li').css({display:'none'});
            jQuery('#jform_params_ztk2_categories').parents('li').css({display:'block'});
            jQuery('#jform_params_ztrss_link').parents('li').css({display:'none'});
            jQuery('#jform_params_ztexternal_link').parents('li').css({display:'none'});
            break;
        case '3':
           jQuery('#jform_params_ztcategory').parents('li').css({display:'none'});
            jQuery('#jform_params_ztk2_categories').parents('li').css({display:'none'});
            jQuery('#jform_params_ztrss_link').parents('li').css({display:'block'});
            jQuery('#jform_params_ztexternal_link').parents('li').css({display:'none'});
            break; 
        case '4':
           jQuery('#jform_params_ztcategory').parents('li').css({display:'none'});
            jQuery('#jform_params_ztk2_categories').parents('li').css({display:'none'});
            jQuery('#jform_params_ztrss_link').parents('li').css({display:'none'});
            jQuery('#jform_params_ztexternal_link').parents('li').css({display:'block'});
            break;
            
    }
}