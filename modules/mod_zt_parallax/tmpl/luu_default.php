<?php
/**
 * @package Module ZT Parallax
 * @author ZooTemplate
 * @copyright(C) 2014 - ZooTemplate.com
 * @license PHP files are GNU/GPL
 **/
// no direct access
defined('_JEXEC') || die('Restricted access');
$document = JFactory::getDocument();
$document->addStyleSheet('//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css');
$document->addStylesheet(JURI::base()."/modules/mod_zt_parallax/assets/css/style.css");

//check version
$jversion = new JVersion;
$current_version = $jversion->getShortVersion();
if (version_compare($current_version, '3.0.0') <= 0){
    $document->addScript(JURI::root() . 'modules/mod_zt_parallax/assets/js/jquery-1.11.1.js');
    $document->addScript(JURI::root() . 'modules/mod_zt_parallax/assets/js/jquery.noConflict.js');
}

?>
    <style>
        #module_<?php echo $module_id;?> {
            padding-top:<?php echo $top_padding; ?>px;
            padding-bottom:<?php echo $bottom_padding; ?>px;
            color:<?php echo $text_color; ?>;
            overflow: hidden;
        //min-height: 500px;
        }
    </style>
<?php
echo '<div id="module_'.$module_id.'">';
//youtube
if($params->get('background_type', 'image') == 'youtube'){

    ?>
    <div class="default zt_parallax_wrap <?php echo $moduleclass_sfx; ?>" id="bgndEl">
        <a id="bgndVideo" href="http://www.youtube.com/watch?v=<?php echo $params->get('video_id', '')?>" class="movie {opacity:<?php echo $params->get('opacity', 1)?>, loop:<?php echo $params->get('loop', true)?>, bufferImg:false, isBgndMovie:{width:'window',mute:<?php echo $params->get('mute', true)?> },optimizeDisplay:true, showControls:<?php echo $params->get('showControls',false); ?>, ID:'bgndEl', ratio:'<?php echo $params->get('ratio','16/9'); ?>',quality:'<?php echo $params->get('quality', 'default')?>'}">Urban Abstract</a>
        <?php echo $text_content; ?>
    </div>
    <?php
    //vimeo video
} elseif($params->get('background_type', 'image') == 'vimeo') {
    // $document->addScript(JURI::base()."/modules/mod_zt_parallax/assets/js/vimeo.parallax.js");
    $document->addStyleSheet(JURI::base()."/modules/mod_zt_parallax/assets/css/style_vimeo.css");
    ?>
    <div class="zt_parallax_wrap" style="position: relative">
        <div class="video-bg" style="">
            <div class="vid-overlay" style="" ></div>
            <div class="zt-content">
                <?php echo $text_content; ?>
            </div>

            <iframe class="vid-bg" id="video_vimeo" src="http://player.vimeo.com/video/<?php echo $params->get('video_id', '')?>?api=1&autoplay=1&loop=1&playbar=0&&player_id=video_vimeo" style="">

            </iframe>
        </div>

    </div>
    <script>


        var f = jQuery('.zt_parallax_wrap iframe');
        var url = f.attr('src').split('?')[0];
        function post(action, value) {
            var data = { method: action };

            if (value) {
                data.value = value;
            }

            f[0].contentWindow.postMessage(JSON.stringify(data), url);
        }
        if (window.addEventListener){
            window.addEventListener('message', onMessageReceived, false);
        }
        else {
            window.attachEvent('onmessage', onMessageReceived, false);
        }
        function onMessageReceived(e) {
            var data = JSON.parse(e.data);
            switch (data.event) {
                case 'ready':
                    onReady();
                    break;

            }
        }

        function onReady() {
            post('setVolume','0');
            f.css("visibility","visible");
        }
        jQuery(document).ready(function(){
            var wrap = jQuery('.zt_parallax_wrap');
            var width_wrap = parseInt(wrap.css("width"));
            var height_wrap = parseInt(wrap.css("height"));
            var width_iframe = width_wrap * <?php echo floatval($params->get('ratio_vimeo', 1))?>;
            var height_iframe = width_iframe * 0.56;
            var left =(width_wrap - width_iframe)/2;

            var iframe_vimeo = wrap.find("iframe");
            iframe_vimeo.css("height",height_iframe);
            iframe_vimeo.css("max-height",height_iframe);
            iframe_vimeo.css("width",width_iframe);
            iframe_vimeo.css("max-width",width_iframe);

            var top = -1 * (height_iframe - height_wrap)/2 ;
            iframe_vimeo.css("top",top);
            iframe_vimeo.css("left",left);

            jQuery(window).scroll(function(){
                parallax(top);
            });

            function parallax(top) {
                var scrollTop = jQuery(window).scrollTop();
                var window_height = jQuery(window).height();
                //console.log(window_height)
                var wrap_offset_top = jQuery(wrap).offset().top;
                var  scroll_to_iframe = window_height - wrap_offset_top;



                var change_value = window_height + height_wrap;
                var n = Math.abs(top/change_value) ;
                var scrollToCenter;
                var change_top;

                if(top <0) {
                    if (scroll_to_iframe>0) {
                        //ngay o tren dau
                        //scrollToCeter la khoang cach scroll toi giua wrap
                        scrollToCenter = 0.5 * height_wrap;

                        if(scrollTop >= scrollToCenter) {
                            change_top =  -1 *(scrollTop - scrollToCenter);
                            if(change_top>= top) {
                                iframe_vimeo.css("top",top - change_top);

                            }
                        }

                    } else {
                        scroll_to_iframe = scroll_to_iframe * -1;
                        scrollToCenter = scroll_to_iframe + 0.5 * height_wrap;
                        if((scrollTop >= scroll_to_iframe) && (scrollTop >= scrollToCenter)) {
                            change_top =  -1 *(scrollTop - scrollToCenter);
                            if(change_top>= top*2) {
                                iframe_vimeo.css("top",change_top);
                            }
                        }
                    }

                } else {
                }
            }
        });
    </script>
<?php
}

//upload
elseif($params->get('background_type', 'image') == 'upload'){

    $document->addScript(JURI::base()."/modules/mod_zt_parallax/assets/js/jquery.video.parallax.js");
    $document->addScript(JURI::base()."/modules/mod_zt_parallax/assets/vendor/fancybox/lib/jquery.mousewheel-3.0.6.pack.js");
    $document->addScript(JURI::base()."/modules/mod_zt_parallax/assets/vendor/fancybox/source/jquery.fancybox.js");
    $document->addScript(JURI::base()."/modules/mod_zt_parallax/assets/vendor/fancybox/source/helpers/jquery.fancybox-media.js");
    $document->addStyleSheet(JURI::base()."/modules/mod_zt_parallax/assets/vendor/fancybox/source/jquery.fancybox.css");

    ?>
    <div class="zt_parallax_wrap <?php echo $moduleclass_sfx;?>" >
        <div  class="video-bg" style="min-height: <?php echo $params->get('setMinHeight', 300); ?>px;background: url("<?php echo $params->get('image_poster_uploadV', ''); ?>")" data-video-file-mp4="<?php echo $params->get('link_video_uploadV_mp4', '')?>" data-video-file-webm="<?php echo $params->get('link_video_uploadV_webm', '')?>" data-sound="<?php  if($params->get('mute', '')=='true'){echo 'false';} else{ echo 'true';}?>" data-width="<?php echo $params->get('width_uploadV', 16)?>" data-height="<?php echo $params->get('height_uploadV', 9)?>" data-link-image-poster="<?php echo $params->get('image_poster_uploadV', '')?>" data-overlay-color="<?php echo $params->get('overlay_color_uploadV', '#000000')?>" data-overlay-opacity="<?php echo (1 - floatval($params->get('opacity', 0.1)))?>" >
        <div class="zt-content" style="">
            <?php echo $text_content; ?>
        </div>
        <?php if($params->get('showSancyBox',true)=='true') { ?>
            <h6><?php echo $params->get('iconTitle', 'See the video'); ?></h6>
            <div class="zt-see-more">
                <p class="zt-play-video">
                    <a class="fancybox-media" href="<?php echo $params->get('linkSancyBox', ''); ?>">
                        <<?php echo $params->get('iconSancyBox', 'i'); ?> class="zt-custom-icon <?php  echo $params->get('classIconSancyBox', 'fa fa-play'); ?>"></<?php  echo $params->get('iconSancyBox', 'i'); ?>>
                    </a>
                </p>

            </div>
        <?php } ?>


    </div>
    </div>
    <div style="clear: both; height: 10px"></div>

    <script>
        jQuery(window).load(function(e){
            jQuery(".video-bg").bgVideo();
            if(jQuery().bgVideo){
                setTimeout(function(){
                    jQuery(".video-bg").bgVideo();
                },1e3);
                //fancybox-close
            }

            var window_width = jQuery(window).width();
            var fancybox_width = 0.6 * window_width;
            var fancybox_height = fancybox_width * 0.56 ;
            var id_video = jQuery('#module_<?php echo $module->id;?> video').attr("id");
            jQuery('#module_<?php echo $module->id;?> a.fancybox-media').fancybox({
                openEffect  : 'fade',
                closeEffect : 'none',
                padding     : 0,
                width       : fancybox_width,
                height      : fancybox_height,
                beforeLoad: function() {
                    document.getElementById(id_video).pause();
                },
                beforeClose: function() {
                    document.getElementById(id_video).play();
                },

                helpers : {
                    media : {},
                    title : {
                        type : 'inside'
                    },
                    overlay : {
                        css : {
                            'background' : 'rgba(0,0,0,0.9)'
                        }
                    }
                }
            });

        });
        //fancybox-wrap fancybox-desktop fancybox-type-iframe fancybox-opened

    </script>
<?php
}
//image
elseif ($params->get('background_type', 'image') == 'image'){
    $custom_css = JPATH_SITE . DS . 'templates' . DS . modZtParallaxHelper::getTemplate() . DS . 'css' . DS . $module->module . '_' . $params->get('zt_parallax_layout', 'default') . '.css';

    $document->addScript(JURI::base()."modules/mod_zt_parallax/assets/js/jquery.stellar.min.js");
    if (file_exists($custom_css)) {
        $document->addStylesheet(JURI::base(true) . '/templates/' . modZtParallaxHelper::getTemplate() . '/css/' . $module->module . '_' . $params->get('zt_parallax_layout', 'default') . '.css');
    } else {

        $document->addStylesheet(JURI::base(true) . '/modules/mod_zt_parallax/assets/css/mod_zt_parallax_' . $params->get('zt_parallax_layout', 'default') . '.css');
    }
    ?>
    <style>
        #zt_parallax_wrap<?php echo $module_id; ?>{
            background:url('<?php echo JURI::root() . $background_image; ?>') <?php echo $repeat_background . ' ' . $back . ' ' . $background_position; ?>;
        }
    </style>
    <div data-stellar-background-ratio="0.5" class="default zt_parallax_wrap <?php echo $moduleclass_sfx; ?>" id="zt_parallax_wrap<?php echo $module_id; ?>">
        <?php echo $text_content; ?>
    </div>
    <script>
        jQuery(document).ready(function(){
            jQuery(window).stellar({
                horizontalScrolling: false,
                verticalOffset: 40
            });

        });


    </script>
<?php } ?>

<?php
if($params->get('background_type', 'image') == 'youtube' ){
    $document->addScript(JURI::base()."/modules/mod_zt_parallax/assets/js/jquery.metadata.js");
    $document->addScript(JURI::base()."/modules/mod_zt_parallax/assets/js/jquery.mb.YTPlayer.js");
    $document->addStylesheet(JURI::base()."/modules/mod_zt_parallax/assets/css/mb.YTVPlayer.css");
    ?>
    <script>
        jQuery(document).ready(function(){
            jQuery(".movie").mb_YTPlayer();
        });
    </script>
<?php
}
echo '</div>';
?>