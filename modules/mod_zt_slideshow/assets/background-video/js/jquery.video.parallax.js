(function(e){
    e.fn.extend({
        bgVideo:function(e){
            return this.each(function(e){
                    var t=jQuery(this);
                    var check = false;
                    if(t.find("video").length>0) {
                        check =false;
                    } else {
                        check =true;
                    }
                    var videoFileMp4;
                    (!t.data("video-file-mp4")) ? videoFileMp4: videoFileMp4 = t.data("video-file-mp4");
                    var videoFileWebm;
                    (!t.data("video-file-webm")) ? videoFileWebm: videoFileWebm = t.data("video-file-webm");


                    var width;
                    (!t.data("width")) ? width =16: width = t.data("width");
                    var height;
                    (!t.data("height")) ? height =9: height = t.data("height");
                    var linkImagePoster;
                    (t.data("link-image-poster")) ? linkImagePoster = t.data("link-image-poster"):linkImagePoster;
                    var overlayColor;
                    (t.data("overlay-color")) ? overlayColor = t.data("overlay-color"):overlayColor = "#000000";
                    var overlayOpacity;
                    (t.data("overlay-opacity")) ? overlayOpacity = t.data("overlay-opacity"): overlayOpacity = 0.1;

                    var n={videofileMp4:videoFileMp4,
                        videofileWebm:videoFileWebm,
                        videowidth:width,
                        videoheight:height,
                        videoposter:linkImagePoster,
                        videoparallax:true,
                        videooverlaycolor:overlayColor,
                        videooverlayopacity:overlayOpacity,
                        videosound:t.data("sound")};

                    t.css({position:"relative",overflow:"hidden","z-index":"1"});
                    var r="";
                    if(n.videooverlaycolor){
                        overlay='<div class="vid-overlay" style="position:absolute;width:100%;height:100%;top:0;left:0;background:'+n.videooverlaycolor+';z-index:-2;-webkit-backface-visibility: hidden;-webkit-transform: translateZ(0);" ></div>'
                    }
                    r+='<div class="vid-bg" style="position:absolute;width:100%;height:100%;top:0;left:0;z-index:-10;background: url('+n.videoposter+') center center; background-size: cover;">';

                        r+='<video id="video'+e+'"  preload="auto" autoplay="autoplay" loop="loop"';
                        if(n.videosound){
                        }else{
                            r+=' muted="muted" '
                        }
                        if(n.videoposter){
                            r+=' poster="'+n.videoposter+'" '
                        }
                        r+='style="display:none;top:0;left:0;position: relative;z-index:-11;width:100%;height:100%;">';
                        r+='<source src="'+n.videofileMp4+'" type="video/mp4" />';
                        r+='<source src="'+n.videofileWebm+'" type="video/webm" />';
                        r+="bgvideo</video>";r+="</div>";
//                        if(n.videosound){
//                            r+='<a href="#" class="mute-video" style="position: absolute;z-index:50; bottom:20px;left:50%;margin-left: -10px;color:#ffffff;display:block;width: 20px;height: 20px;"><i class="fa fa-volume-up fa-fw"></i></a>'
//                        }else{
//                        }

                    if(check) {
                        t.prepend(overlay);
                        t.append(r);
                    }

                    t.find(".vid-overlay").css({opacity:n.videooverlayopacity});
                    t.find(".vid-bg video").fadeIn(1e3);

                        setProportion(t,n.videowidth,n.videoheight,n.videoparallax);
                        jQuery(window).resize(function(){
                            setProportion(t,n.videowidth,n.videoheight,n.videoparallax);
                            parallaxVideo(t)
                        });


                    if(n.videoparallax){
                        //parallaxVideo(t);
                        jQuery(window).scroll(function(){
                            parallaxVideo(t)
                        })
                    }
                }
            )
        }
    })
})(jQuery);

(function (d) {
    d.fn.visible = function (e, i) {
        var a = d(this).eq(0),
            f = a.get(0),
            c = d(window),
            g = c.scrollTop();
        c = g + c.height();
        var b = a.offset().top,
            h = b + a.height();
        a = e === true ? h : b;
        b = e === true ? b : h;
        return !!(i === true ? f.offsetWidth * f.offsetHeight : true) && b <= c && a >= g
    }
})(jQuery);

function setProportion(e,t,n,r){
    var i=getProportion(e,t,n,r);
    e.find(".vid-bg").width(i*t);
    e.find(".vid-bg").height(i*n);
    e.find(".vid-bg video").width(i*t);
    e.find(".vid-bg video").height(i*n);

    var s=(e.width()>>1)-(e.find(".vid-bg video").width()>>1)|0;
    var o=(e.height()>>1)-(e.find(".vid-bg video").height()>>1)|0;
    e.find(".vid-bg video").css({left:s,top:o})
    //console.log( e.find(".vid-bg video").css("top"));

}
function getProportion(e,t,n,r){
    var i=jQuery(window).width();
    var s=jQuery(window).height();
    var o=i/s;
    var u=e.width();
    var a=e.height();
    var f=u/a;
    var l=t/n;
    var c=a/n;
    if(f>=l){c=u/t}
    else if(r&&a<jQuery(window).height()){
        c=jQuery(window).height()/n
    }
    return c
}
function parallaxVideo(e){
    //e = video-bg
    var t=e.visible(true);
    if(t){
        var n=parseInt(jQuery(e).offset().top);
        var r=n-jQuery(window).scrollTop();
        var i=-(r);
        var s=i+"px";
        var height_video =   parseInt(e.find(".vid-bg video").css("height"));
        var height_wrap =   parseInt(e.css("height"));
        var top_max = -(height_video - height_wrap);
        if(i>top_max) {
            e.find(".vid-bg video").css({top:s});
        }


    }
}
