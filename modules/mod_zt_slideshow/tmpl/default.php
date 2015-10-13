<?php
/* {$id} */

$doc = JFactory::getDocument();
//    $doc->addScriptDeclaration($script);
if( $params->get('disable_mootools', 1)){
    if(isset($doc->_scripts[JURI::root(true) . '/media/system/js/mootools-more.js']))
            unset($doc->_scripts[JURI::root(true) . '/media/system/js/mootools-more.js']);
    if(isset($doc->_scripts[JURI::root(true) . '/media/system/js/mootools-core.js']))
        unset($doc->_scripts[JURI::root(true) . '/media/system/js/mootools-core.js']);
}
$doc->addScript(JUri::root() . '/modules/mod_zt_slideshow/assets/bxslider/vendor/jquery.easing.1.3.js');
$doc->addScript(JUri::root() . '/modules/mod_zt_slideshow/assets/bxslider/jquery.bxslider.min.js');
$doc->addScript(JUri::root() . '/modules/mod_zt_slideshow/assets/html5lightbox/html5lightbox.js');
$doc->addScript(JUri::root() . '/modules/mod_zt_slideshow/assets/background-video/js/jquery.video.parallax.js');
$doc->addStyleSheet(JUri::root() . '/modules/mod_zt_slideshow/assets/background-video/css/style.css');
$doc->addStyleSheet(JUri::root() . '/modules/mod_zt_slideshow/assets/bxslider/jquery.bxslider.css');
$doc->addStyleSheet(JUri::root() . '/modules/mod_zt_slideshow/assets/css/front/style.css');
$doc->addStyleSheet(JUri::root() . '/modules/mod_zt_slideshow/assets/css/front/animation.css');
$doc->addStyleSheet(JUri::root() . '/modules/mod_zt_slideshow/assets/fontawesome/css/font-awesome.min.css');
$doc->addScript(JUri::root() . '/modules/mod_zt_slideshow/assets/frontend.script.js');
?>
<div class="zt-slideshow-wrap" style="width: <?php echo $params->get('slider_width'); ?>; heigt: <?php echo $params->get('slider_height'); ?>">
    <div class="zt-slideshow">
    <?php
    foreach ($slides as $slide)
    {
        $slideParams = $slide['params'];
        $unvisible = 'display: none;';
        $opacity = $slideParams->get('color-overlay-opacity', '0');
        $defaultOverlay = $slideParams->get('background-image-color', 'black');
        $colorStyle = 'background-color: ' . $defaultOverlay . ';';
        $opacityStyle = 'opacity: ' . $opacity . ';';
        $opacityStyleReverse = 'opacity: ' . (1 - $opacity) . ';';
        $imageURL = ($slideParams->get('background-image', '') !== '') ? rtrim(JUri::root(), '/') . '/' . $slideParams->get('background-image') : '';
    ?>
    <div class="zt-slidershow-item">
        <div class="zt-slideshow-loading" style="<?php echo($unvisible); ?>"></div>
        <div class="full-background-wrap">
            <!-- Background color -->
            <div class="full-background full-background-color" style="<?php echo($colorStyle); ?>"></div>
            <!-- Background image -->
            <?php if($imageURL != ''): ?>
            <div class="full-background full-background-image" style="background-image: url('<?php echo $imageURL ?>');<?php echo($opacityStyleReverse); ?>"></div>
            <?php endif; ?>
            <!-- Background video -->
            <?php if ($slideParams->get('background-video-mp4', '') != '' && $slideParams->get('background-video-webm', '') != ''): ?>
            <div
                class="full-background full-background-video"
                style="min-height: <?php echo $slideParams->get('slider_height'); ?>; min-width: <?php echo $slideParams->get('slider_width'); ?>;"
                data-video-file-mp4="<?php echo $slideParams->get('background-video-mp4') ?>"
                data-video-file-webm="<?php echo $slideParams->get('background-video-webm') ?>"
                data-sound="true"
                <?php if($imageURL != ''):?>
                data-link-image-poster="<?php echo ($imageURL); ?>"
                <?php endif; ?>
                data-overlay-color="<?php echo($defaultOverlay); ?>"
                data-overlay-opacity="<?php echo($opacity); ?>">
                <?php if ($slideParams->get('button-mute') === 'enable') { ?>
                    <p class="btn-volumn">
                        <i class="fa fa-volume-up" onclick="muteBxSlider(this);"></i>
                    </p>
                <?php } ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="container">
            <div class="row">
                <!-- Left -->
                <?php $item = $slide['left']; ?>
                <?php if ($item->get('column') != 'none') : ?>
                    <div
                        class="left zt-slider-position <?php echo 'col-md-' . $item->get('column') . ' col-sm-' . $item->get('column'); ?>">
                        <?php $item = $slide['left']; ?>
                        <?php if ( $item->get('type') ) : ?>
                            <?php require __DIR__ . '/' . $item->get('type') . '.php'; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <!-- Right -->
                <?php $item = $slide['right']; ?>
                <?php if ($item->get('column') != 'none') : ?>
                    <div class="right zt-slider-position <?php echo 'col-md-' . $item->get('column') . ' col-sm-' . $item->get('column'); ?>">
                        <?php if ( $item->get('type') ) : ?>
                            <?php require __DIR__ . '/' . $item->get('type') . '.php'; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    </div>
</div>
<?php
$style = '.zt-slideshow .zt-slidershow-item {
            min-height: '.$params->get('slider_height').';
            height: '. $params->get('slider_height').';
        }

        .zt-slideshow .zt-slider-position {
            height: '. $params->get('slider_height').';
        }';

$doc->addStyleDeclaration($style);
?>
<script type="text/javascript">
var $bxSliderContainer = jQuery('div.zt-slideshow-wrap div.zt-slideshow');
var bxSliderSettings = {
    speed: <?php echo $params->get('transition_duration', 1000); ?>,
    <?php if($params->get('autoplay')): ?>
    auto: true,
    <?php endif; ?>
    <?php if($params->get('effects') != 'none'): ?>
    useCSS: false,
    easing: '<?php echo $params->get('effects'); ?>',
    <?php endif; ?>
    pause: <?php echo $params->get('display_time', 4000); ?>,
    <?php if (!$params->get('pagination')): ?>
    pager: false,
    <?php endif; ?>
    <?php if (!$params->get('navigation')): ?>
    controls: false,
    <?php endif; ?>
    onSliderLoad: function(currentIndex){
        $bxSliderContainer.find("> div:not('.bx-clone')").first().data('loaded', true);
    },
    onSlideBefore: function(){
        if(typeof(slider) !== 'undefined'){
            var $current = $bxSliderContainer.find("> div:not('.bx-clone')").eq(slider.getCurrentSlide());
        }else{
            var $current = $bxSliderContainer.find("> div:not('.bx-clone')").first();
        }
        $current.addClass('active');
        if(typeof($current.data('loaded')) === 'undefined'){
            $current.find('.zt-slideshow-loading').css('display', 'block');
        }        
    },
    onSlideAfter: function () {
        var $current = $bxSliderContainer.find("> div:not('.bx-clone')").find('.active');
        $current.removeClass('active');
        $current = $bxSliderContainer.find("> div:not('.bx-clone')").eq(slider.getCurrentSlide())
        $current.addClass('active');
        window.setTimeout(function(){
            if(typeof($current.data('loaded')) === 'undefined'){
                $current.find('.zt-slideshow-loading').fadeOut();
                $current.data('loaded', true);
            }
        }, 500);
    }
};
</script>