jQuery(document).ready(function(){
    slider = jQuery('div.zt-slideshow-wrap > div.zt-slideshow').bxSlider(bxSliderSettings);
    muteBxSlider = function(el){
        var $this = jQuery(el);
        var $video = $this.closest('.full-background-video').find('video');
        if($this.hasClass('fa-volume-up')){
            $this.removeClass('fa-volume-up');
            $this.addClass('fa-volume-off');
            $video.prop('muted', true);
        }else{
            $this.removeClass('fa-volume-off');
            $this.addClass('fa-volume-up');
            $video.prop('muted', false);
        }
    };
    var $videos = jQuery('.zt-slideshow-wrap .zt-slidershow-item:not(".bx-clone") .full-background-wrap .full-background-video');
    if($videos.length > 0){
        $videos.bgVideo();
    }    
});
