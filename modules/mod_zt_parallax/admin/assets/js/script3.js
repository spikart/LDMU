jQuery(document).ready(function(){
    //console.log(jQuery('#jform_params_background_type').val());
    jQuery('#jform_params_asset-lbl').parent().parent().hide();

    var background_type = jQuery('#jform_params_background_type').parent().parent();

    //youtube
    var id_video = jQuery('#jform_params_video_id').parent().parent();
    var caption_youtube = jQuery('#jform_params_youtube-lbl').parent().parent().parent().parent();

    var control_bar = jQuery('#jform_params_showControls').parent().parent();
    var  quality = jQuery('#jform_params_quality').parent().parent();
    var loop = jQuery('#jform_params_loop').parent().parent();
    var ratio = jQuery('#jform_params_ratio').parent().parent();

    //upload
    var caption_upload = jQuery('#jform_params_upload-lbl').parent().parent().parent().parent();
    var image_poster = jQuery('#jform_params_image_poster_uploadV').parent().parent().parent();
    var overlay_color = jQuery('#jform_params_overlay_color_uploadV').parent().parent();
    var video_link_mp4 = jQuery('#jform_params_link_video_uploadV_mp4').parent().parent();
    var video_link_webm = jQuery('#jform_params_link_video_uploadV_webm').parent().parent();
    var video_width = jQuery('#jform_params_width_uploadV').parent().parent();
    var video_height = jQuery('#jform_params_height_uploadV').parent().parent();
    var video_sanbox_link = jQuery('#jform_params_linkSancyBox').parent().parent();
    var video_sanbox_enable = jQuery('#jform_params_showSancyBox').parent().parent();

    var video_sanbox_title = jQuery('#jform_params_iconTitle').parent().parent();
    var video_sanbox_tag = jQuery('#jform_params_iconSancyBox').parent().parent();
    var video_sanbox_tag_class = jQuery('#jform_params_classIconSancyBox').parent().parent();

    var set_min_height = jQuery('#jform_params_setMinHeight').parent().parent();

    //vimeo
    var opacity_video = jQuery('#jform_params_opacity').parent().parent();
    var mute_video = jQuery('#jform_params_mute').parent().parent();
    var caption_vimeo = jQuery('#jform_params_vimeo-lbl').parent().parent().parent().parent();
    var ratio_vimeo = jQuery('#jform_params_ratio_vimeo').parent().parent();


    //img
    var background_position = jQuery('#jform_params_background_position').parent().parent();
    var background_image = jQuery('#jform_params_background_image').parent().parent().parent();
    var background_parallax = jQuery('#jform_params_parallax_background').parent().parent();
    var background_repeat = jQuery('#jform_params_repeat_background').parent().parent();





    function load() {
        //youtube video
        id_video.hide();
        caption_youtube.hide();
        control_bar.hide();
        quality.hide();
        loop.hide();
        ratio.hide();

         //upload video
        caption_upload.hide();
        image_poster.hide();
        overlay_color.hide();
        video_sanbox_enable.hide();
        video_sanbox_link.hide();
        set_min_height.hide();

        video_sanbox_title.hide();
        video_sanbox_tag.hide();
        video_sanbox_tag_class.hide();

        video_link_mp4.hide();
        video_link_webm.hide();
        video_width.hide();
        video_height.hide();

        //video
        opacity_video.hide();
        mute_video.hide();
        caption_vimeo.hide();
        ratio_vimeo.hide();
        //image
        background_position.hide();
        background_image.hide();
        background_parallax.hide();
        background_repeat.hide();

        //console.log(jQuery('#jform_params_background_type').val());
        switch (jQuery('#jform_params_background_type').val()) {
            case 'vimeo':

                id_video.show();
                ratio_vimeo.show();
                caption_upload.show();

                //video_width.show();
                //video_height.show();


                //loop.show();
                //opacity_video.show();
                //mute_video.show();

                break;
            case 'upload':
                caption_upload.show();
                image_poster.show();
                overlay_color.show();

                video_sanbox_enable.show();
                checkSanbox(jQuery('#jform_params_showSancyBox').val());
                set_min_height.show();


                video_link_mp4.show();
                video_link_webm.show();
                //video_width.show();
                //video_height.show();
                opacity_video.show();
                mute_video.show();
                break;
            case 'youtube':
                id_video.show();
                caption_youtube.show();
                control_bar.show();
                quality.show();
                loop.show();
                ratio.show();
                opacity_video.show();
                mute_video.show();
                break;
            case 'image':
                background_position.show();
                background_image.show();
                background_parallax.show();
                background_repeat.show();

                opacity_video.show();
                overlay_color.show();
                break;
        }
    }
    function checkSanbox(check) {
        if(check=='true'){
            video_sanbox_link.show();

            video_sanbox_title.show();
            video_sanbox_tag.show();
            video_sanbox_tag_class.show();
        } else {
            video_sanbox_link.hide();

            video_sanbox_title.hide();
            video_sanbox_tag.hide();
            video_sanbox_tag_class.hide();
        }
    }
    jQuery('#jform_params_showSancyBox').on("change",function(){
        checkSanbox(jQuery('#jform_params_showSancyBox').val());
    });

    load();
    jQuery('#jform_params_background_type').on("change",function(){
        load();
    });
});
