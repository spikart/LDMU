/*******************************************************************************
 jquery.mb.components
 Copyright (c) 2001-2012. Matteo Bicocchi (Pupunzi); Open lab srl, Firenze - Italy
 email: mbicocchi@open-lab.com
 site: http://pupunzi.com

 Licences: MIT, GPL
 http://www.opensource.org/licenses/mit-license.php
 http://www.gnu.org/licenses/gpl.html
 ******************************************************************************/

/*
 * jQuery.mb.components: jQuery.mb.YTPlayer
 * version: 1.4.0
 * © 2001 - 2012 Matteo Bicocchi (pupunzi), Open Lab
 *
 * YT API:
 *
 */

(function(jQuery){

    jQuery.mbYTPlayer={
        name:"jQuery.mb.YTPlayer",
        version:"1.4.0",
        author:"Matteo Bicocchi",
        width:450,
        controls:{
            play:"<i class='fa fa-play'></i>",
            pause:"<i class='fa fa-pause'></i>",
            mute:"<i class='fa fa-volume-up'></i>",
            unmute:"<i class='fa fa-volume-off'></i>"
        },
        rasterImg:"images/raster.png",

        setYTPlayer:function(){
            var players=this;
            jQuery.getScript("http://ajax.googleapis.com/ajax/libs/swfobject/2/swfobject.js",function(){
                players.each(function(){

                    var player = jQuery(this);
                    if(!player.is("a")) return;

                    if (!player.attr("id")) player.attr("id", "YTP_"+new Date().getTime());
                    var ID=player.attr("id");

                    var dataObj=jQuery("<span/>");
                    dataObj.attr("id",ID+"_data").hide();
                    var data= dataObj.data();

                    data.opacity=1;
                    data.isBgndMovie=false;
                    data.width=jQuery.mbYTPlayer.width;
                    data.quality="default";
                    data.muteSound=false;
                    data.hasControls=true;
                    data.ratio="16/9";
                    data.bufferImg=false;
                    data.autoplay=true;

                    var BGisInit = typeof document.YTPBG != "undefined";

                    if (jQuery.metadata){
                        jQuery.metadata.setType("class");
                        if (player.metadata().quality) data.quality=player.metadata().quality;
                        if (player.metadata().width) data.width=player.metadata().width;
                        //if (player.metadata().opacity) data.opacity = jQuery.browser.msie ? 1 : player.metadata().opacity ? player.metadata().opacity: data.opacity;
                        if (player.metadata().opacity) data.opacity=player.metadata().opacity;
                        if (player.metadata().isBgndMovie && !BGisInit) {
                            data.isBgndMovie=player.metadata().isBgndMovie;
                            data.width=player.metadata().isBgndMovie.width? player.metadata().isBgndMovie.width:"window";
                        }
                        if (player.metadata().optimizeDisplay && data.isBgndMovie) {
                            data.optimizeDisplay=player.metadata().optimizeDisplay;
                        }

                        if (player.metadata().muteSound) {data.muteSound=player.metadata().muteSound;}
                        if (player.metadata().loop) {data.loop=player.metadata().loop;}
                        if (player.metadata().hasControls) {data.hasControls=player.metadata().hasControls;}
                        if (player.metadata().ratio) {data.ratio=player.metadata().ratio;}
                        if (player.metadata().bufferImg) {data.bufferImg=player.metadata().bufferImg;}
                        if (player.metadata().ID) {data.ID=player.metadata().ID;}
                        if (player.metadata().autoplay!=undefined) {data.autoplay=player.metadata().autoplay;}
                        if (player.metadata().showControls!=undefined) {data.showControls=player.metadata().showControls;}
                        if (player.metadata().addRaster!=undefined) {data.addRaster=player.metadata().addRaster;}else{data.addRaster=false}

                        if (player.metadata().lightCrop!=undefined) {data.lightCrop=player.metadata().lightCrop;}else{data.lightCrop=false}
                    }

                    var el= data.ID?jQuery("#"+data.ID):jQuery("body");
                    if(data.ID){
                        el.css({overflow:"hidden"});
                    }
                    if(data.width=="window") {
                        data.height="100%";
                        data.width= "100%";
                    } else
                        data.height= data.ratio=="16/9" ? Math.ceil((9*data.width)/16): Math.ceil((3*data.width)/4);

                    var videoWrapper="";

                    jQuery(el).prepend(dataObj);
                    console.log(dataObj);

                    if(data.isBgndMovie){
                        if (data.ID){
                            var bodyWrapper=jQuery("<div/>").css({position:"relative",zIndex:0});
                            var elPos = el.css("position") == "static" ? "relative" : el.css("position");
                            el.css("position", elPos);

                            jQuery(el).wrapInner(bodyWrapper);
                            jQuery(el).prepend(player);
                        }else{
                            jQuery(el).css({position:"relative",zIndex:1});
                            jQuery(el).before(player);
                        }

                        var pos= data.ID?"absolute":"fixed";

                        videoWrapper=jQuery("<div/>").attr("id","wrapper_"+ID).css({overflow:"hidden",position:pos,left:0,top:0, width:"100%", height:"100%", opacity:0});
                        player.wrap(videoWrapper);
                        if(!data.width.toString().indexOf("%")==-1) {
                            var videoDiv=jQuery("<div/>").css({position:pos,top: data.ratio=="4/3" && !data.ID?-(data.height/4):0,left:0, display:"block", width:data.width, height:data.height});
                            player.wrap(videoDiv);
                        }
                    }else{
                        videoWrapper=jQuery("<span/>").attr("id","wrapper_"+ID).css({width:data.width, height:data.height, position:"relative", opacity:0}).addClass("mb_YTVPlayer");
                        player.wrap(videoWrapper);
                    }

                    if(data.optimizeDisplay){
                        jQuery(window).resize(function(){
                            jQuery(player).optimizeDisplay();
                        });
                        jQuery(document).on("YTPStart", function(){
                            jQuery(player).optimizeDisplay();
                            setTimeout(function(){videoWrapper.css({opacity:1});},2500);
                        });
                    }

                    var params = { allowScriptAccess: "always", wmode:"transparent", allowFullScreen:"true" };
                    var atts = { id: ID };
                    data.movieURL=player.attr("href")?(player.attr("href").match( /[\\?&]v=([^&#]*)/))[1]:false;

                    //swfobject.embedSWF(swfUrl, id, width, height, version, expressInstallSwfurl, flashvars, params, attributes, callbackFn)
                    swfobject.embedSWF("http://www.youtube.com/apiplayer?enablejsapi=1&version=3&playerapiid="+ID,ID, data.width, data.height, "8", null, null, params, atts);

                    var defData = {};
                    dataObj.get(0).defaults=jQuery.extend(defData,data);
                });
            });
        },

        setMovie: function(){

            var player = jQuery(this).get(0);

            player.onVideoLoaded=undefined;

            var data = jQuery("#"+player.id+"_data").data();
            var BGisInit = typeof document.YTPBG != "undefined";
            var movieID= data.movieURL;

            jQuery(player).css({opacity:data.opacity});
            var pos= data.ID?"absolute":"fixed";

            var bufferImg=data.bufferImg ? jQuery("<div/>").addClass("mbYTP_bufferImg").css({position:pos,top:0,left:0,width:"100%",height:"100%",background:"url("+data.bufferImg+")"}).hide() : false;
            var playerContainer=jQuery(player).parents("div:first");
            var raster=jQuery("<div/>").addClass("mbYTP_raster").css({opacity:0,position:pos,top:0,left:0,width:"100%",height:"100%",background:"url("+jQuery.mbYTPlayer.rasterImg+")"});
            if (data.bufferImg) jQuery(playerContainer).after(bufferImg);

            //if it is as background
            if(data.isBgndMovie && !BGisInit){
                if (data.addRaster && jQuery.mbYTPlayer.rasterImg && jQuery(".mbYTP_raster").length==0){
                    jQuery(playerContainer).append(raster);
                }

                //can't be more than one bgnd
                if(!data.ID)
                    document.YTPBG=true;

                if(movieID)
                    if(data.autoplay)
                        player.loadVideoByUrl("http://www.youtube.com/v/"+movieID, 0);
                    else
                        player.cueVideoByUrl("http://www.youtube.com/v/"+movieID, 0);

                if (data.isBgndMovie.mute) player.mute();
                if(data.showControls) jQuery(player).buildYTPControls();

            }else{
                player.cueVideoByUrl("http://www.youtube.com/v/"+movieID, 0);
                jQuery(player).buildYTPControls();
            }

            player.setPlaybackQuality(data.quality);

            // player.addEventListener("onStateChange", '(function(state) { return playerState(state, "' + player.id + '"); })');

            setInterval(function(){
                playerState(player.getPlayerState(),player.id);
            },1000);

        },

        changeMovie:function(url, opt){

            var player = jQuery(this).get(0);
            var data = jQuery("#"+player.id+"_data").data();

            if(opt){
                jQuery.extend(data,opt);
            }else{
                var defData=jQuery("#"+player.id+"_data").get(0).defaults;
                jQuery.extend(data,defData);
            }

            data.movieURL=(url.match( /[\\?&]v=([^&#]*)/))[1];
            player.loadVideoByUrl("http://www.youtube.com/v/"+data.movieURL, 0);

            jQuery(player).optimizeDisplay();

        },

        getPlayer:function(){
            return this.get(0);
        },

        playYTP: function(){
            var player= jQuery(this).get(0);
            var data = jQuery("#"+player.id+"_data").data();
            var controls = data.ID ?  jQuery(player).parent().parent() : jQuery(player).parent();

            var playBtn=controls.find(".mb_YTVPPlaypause");
            playBtn.html(jQuery.mbYTPlayer.controls.pause);
            player.playVideo();
        },

        stopYTP:function(){
            var player= jQuery(this).get(0);
            var data = jQuery("#"+player.id+"_data").data();
            var controls = data.ID ?  jQuery(player).parent().parent() : jQuery(player).parent();

            var playBtn=controls.find(".mb_YTVPPlaypause");
            playBtn.html(jQuery.mbYTPlayer.controls.play);
            player.pauseVideo();
        },

        pauseYTP:function(){
            var player= jQuery(this).get(0);
            var data = jQuery("#"+player.id+"_data").data();
            var controls = data.ID ?  jQuery(player).parent().parent() : jQuery(player).parent();

            var playBtn=controls.find(".mb_YTVPPlaypause");
            playBtn.html(jQuery.mbYTPlayer.controls.play);
            player.pauseVideo();
        },

        setYTPVolume:function(val){
            var player = jQuery(this).get(0);
            var data = jQuery("#"+player.id+"_data").data();
            if(!val && !data.vol && player.getVolume()==0)
                data.vol=100;
            else if((!val && player.getVolume()>0) || (val && player.getVolume()==val))
                data.vol=0;
            else
                data.vol=val;
            player.setVolume(data.vol);
        },

        muteYTPVolume:function(){
            var player= jQuery(this).get(0);
            var data = jQuery("#"+player.id+"_data").data();
            var controls = data.ID ?  jQuery(player).parent().parent() : jQuery(player).parent();
            var muteBtn= controls.find(".mb_YTVPMuteUnmute");
            muteBtn.html(jQuery.mbYTPlayer.controls.unmute);
            player.mute();
        },

        unmuteYTPVolume:function(){
            var player= jQuery(this).get(0);
            var data = jQuery("#"+player.id+"_data").data();
            var controls = data.ID ?  jQuery(player).parent().parent() : jQuery(player).parent();
            var muteBtn=controls.find(".mb_YTVPMuteUnmute");
            muteBtn.html(jQuery.mbYTPlayer.controls.mute);
            player.unMute();
        },

        manageYTPProgress:function(){
            var player= jQuery(this).get(0);
            var data = jQuery("#"+player.id+"_data").data();
            var YTPlayer = data.ID ?  jQuery(player).parent().parent() : jQuery(player).parent();

            var progressBar= YTPlayer.find(".mb_YTVPProgress");
            var loadedBar=YTPlayer.find(".mb_YTVPLoaded");
            var timeBar=YTPlayer.find(".mb_YTVTime");
            var totW= progressBar.outerWidth();

            var startBytes= player.getVideoStartBytes();
            var totalBytes= player.getVideoBytesTotal();
            var loadedByte= player.getVideoBytesLoaded();
            var currentTime=Math.floor(player.getCurrentTime());
            var totalTime= Math.floor(player.getDuration());
            var timeW= (currentTime*totW)/totalTime;
            var startLeft=0;

            if(startBytes) {
                startLeft=player.timeW;
            }

            var loadedW= (loadedByte*(totW-startLeft))/totalBytes;
            loadedBar.css({left:startLeft, width:loadedW});
            timeBar.css({left:0,width:timeW});
            return {totalTime:totalTime,currentTime: currentTime};
        },

        buildYTPControls:function(){
            var player= jQuery(this).get(0);
            var data = jQuery("#"+player.id+"_data").data();
            if (typeof player.isInit != "undefined") return;
            player.isInit=true;
            var YTPlayer= jQuery(this).parent();
            var controlBar=jQuery("<span/>").addClass("mb_YTVPBar").css({whiteSpace:"noWrap",position: data.isBgndMovie && !data.ID ? "fixed" : "absolute"}).hide();

            var buttonBar=jQuery("<div/>").addClass("buttonBar");
            var playpause =jQuery("<span>"+jQuery.mbYTPlayer.controls.play+"</span>").addClass("mb_YTVPPlaypause").click(function(){
                if(player.getPlayerState()== 1){
                    jQuery(player).pauseYTP();
                }else{
                    jQuery(player).playYTP();
                }
            });
            var MuteUnmute=jQuery("<span>"+jQuery.mbYTPlayer.controls.mute+"</span>").addClass("mb_YTVPMuteUnmute").click(function(){
                if(player.isMuted()){
                    jQuery(player).unmuteYTPVolume();
                }else{
                    jQuery(player).muteYTPVolume();
                }
            });
            var idx=jQuery("<span/>").addClass("mb_YTVPTime");
            var progressBar =jQuery("<div/>").addClass("mb_YTVPProgress").css("position","absolute").click(function(e){
                timeBar.css({width:(e.clientX-timeBar.offset().left)});
                player.timeW=e.clientX-timeBar.offset().left;
                YTPlayer.find(".mb_YTVPLoaded").css({width:0});
                var totalTime= Math.floor(player.getDuration());
                player.goto=(timeBar.outerWidth()*totalTime)/progressBar.outerWidth();
                player.seekTo(player.goto, true);
                YTPlayer.find(".mb_YTVPLoaded").css({width:0});
            });
            var loadedBar = jQuery("<div/>").addClass("mb_YTVPLoaded").css("position","absolute");
            var timeBar = jQuery("<div/>").addClass("mb_YTVTime").css("position","absolute");

            progressBar.append(loadedBar).append(timeBar);
            buttonBar.append(playpause).append(MuteUnmute).append(idx);
            controlBar.append(buttonBar).append(progressBar);
            if (data.ID){
                YTPlayer.before(controlBar);
            }else{
                YTPlayer.append(controlBar);
            }

            if (!data.isBgndMovie){
                YTPlayer.css({opacity:data.opacity});

                YTPlayer.hover(function(){
                    controlBar.fadeIn();
                    clearInterval(player.getState);

                    player.getState=setInterval(function(){

                        //todo: check if audio is muted.

                        if(player.isMuted()){
                            YTPlayer.parent().find(".mb_YTVPMuteUnmute").html(jQuery.mbYTPlayer.controls.unmute);
                        }

                        var prog= jQuery(player).manageYTPProgress();
                        jQuery(".mb_YTVPTime").html(jQuery.mbYTPlayer.formatTime(prog.currentTime)+" / "+ jQuery.mbYTPlayer.formatTime(prog.totalTime));
                        if(player.getPlayerState()== 1 && jQuery(".mb_YTVPPlaypause").html()!=jQuery.mbYTPlayer.controls.pause)
                            YTPlayer.parent().find(".mb_YTVPPlaypause").html(jQuery.mbYTPlayer.controls.pause);
                        if(player.getPlayerState()== 2)
                            YTPlayer.parent().find(".mb_YTVPPlaypause").html(jQuery.mbYTPlayer.controls.play);
                    },1000);
                },function(){
                    controlBar.fadeOut();
                    clearInterval(player.getState);
                });

            }else{
                controlBar.fadeIn();
                clearInterval(player.getState);
                player.getState=setInterval(function(){
                    var prog= jQuery(player).manageYTPProgress();

                    if(player.isMuted()){
                        YTPlayer.parent().find(".mb_YTVPMuteUnmute").html(jQuery.mbYTPlayer.controls.unmute);
                    }

                    YTPlayer.parent().find(".mb_YTVPTime").html(jQuery.mbYTPlayer.formatTime(prog.currentTime)+" / "+ jQuery.mbYTPlayer.formatTime(prog.totalTime));

                    if(player.getPlayerState()== 1 && jQuery(".mb_YTVPPlaypause").html()!=jQuery.mbYTPlayer.controls.pause)
                        YTPlayer.parent().find(".mb_YTVPPlaypause").html(jQuery.mbYTPlayer.controls.pause);
                    if(player.getPlayerState()== 2)
                        YTPlayer.parent().find(".mb_YTVPPlaypause").html(jQuery.mbYTPlayer.controls.play);
                },1000);
            }
        },

        formatTime: function(s){
            var min= Math.floor(s/60);
            var sec= Math.floor(s-(60*min));
            return (min<9?"0"+min:min)+" : "+(sec<9?"0"+sec:sec);
        }
    };

    jQuery.fn.mb_YTPlayer = jQuery.mbYTPlayer.setYTPlayer;
    jQuery.fn.mb_setMovie = jQuery.mbYTPlayer.setMovie;
    jQuery.fn.changeMovie = jQuery.mbYTPlayer.changeMovie;

    jQuery.fn.getPlayer = jQuery.mbYTPlayer.getPlayer;
    jQuery.fn.buildYTPControls = jQuery.mbYTPlayer.buildYTPControls;
    jQuery.fn.playYTP = jQuery.mbYTPlayer.playYTP;
    jQuery.fn.stopYTP = jQuery.mbYTPlayer.stopYTP;
    jQuery.fn.pauseYTP = jQuery.mbYTPlayer.pauseYTP;
    jQuery.fn.muteYTPVolume = jQuery.mbYTPlayer.muteYTPVolume;
    jQuery.fn.unmuteYTPVolume = jQuery.mbYTPlayer.unmuteYTPVolume;
    jQuery.fn.setYTPVolume = jQuery.mbYTPlayer.setYTPVolume;
    jQuery.fn.manageYTPProgress = jQuery.mbYTPlayer.manageYTPProgress;

})(jQuery);

function onYouTubePlayerReady(playerId) {
    var player=jQuery("#"+playerId);
    player.mb_setMovie();

    jQuery(document).on("mousedown",function(e){
        if(e.target.tagName.toLowerCase() == "a")
            player.pauseYTP();
    });
}

function playerState(state, el) {
    var player=jQuery("#"+el).get(0);
    var data = jQuery("#"+player.id+"_data").data();

    if (state==0 && data.isBgndMovie) {
        jQuery(document).trigger("YTPEnd");
        if(data.loop)
            player.playVideo();
        else
            jQuery(player).stopYTP();
    }

    if (state==0 && !data.isBgndMovie) {
        jQuery(document).trigger("YTPEnd");
        jQuery(player).stopYTP();
    }

    if ((state==-1 || state==3)) {
        jQuery(document).trigger("YTPBuffering");
        jQuery(".mbYTP_bufferImg").show();
    }

    if (state==1 && data.isBgndMovie) {
        jQuery(player).css({opacity:data.opacity});
        jQuery(".mbYTP_raster").css({opacity:1,backgroundColor:"transparent"});
        jQuery("#wrapper_"+player.id).animate({opacity:1},1000);
        jQuery(document).trigger("YTPStart");
        jQuery(".mbYTP_bufferImg").hide();

    }

    if(state==1 && !data.isBgndMovie){
        jQuery(player).css({opacity:data.opacity});
        player.totalBytes=player.getVideoBytesTotal();
        jQuery(document).trigger("YTPStart");
        jQuery(".mbYTP_bufferImg").hide();
    }

    if(state==2)
        jQuery(document).trigger("YTPPause");
}

jQuery.fn.toggleVideoState=function(){
    var player=this.get(0);
    var isInit=player.isInit;
    if (isInit=="undefined")
        this.mb_YTPlayer();
    else if (player.getPlayerState()== 1)
        player.pauseVideo();
    else
        player.playVideo();
};

jQuery.fn.optimizeDisplay=function(){
    var player=this.get(0);
    var data = jQuery("#"+player.id+"_data").data();
    var wrapper = jQuery("#wrapper_"+player.id);
    var lightCrop= data.lightCrop;

    var win={};
    var el= data.ID?jQuery("#"+data.ID):jQuery(window);

    win.width= el.width();
    win.height= el.height();

    var vid={};
    vid.width= win.width +( lightCrop ? (win.width*20/100): 0 );
    vid.height = data.ratio=="16/9" ? Math.ceil((9*win.width)/16): Math.ceil((3*win.width)/4);

    var marginTop= -((vid.height-win.height)/2);
    var marginLeft= -( lightCrop ? (win.width*10/100): 0 ) ;
    console.log(lightCrop);

    if(vid.height<win.height){
        vid.height = win.height +(  lightCrop ? (win.height*20/100) :0 );
        vid.width= data.ratio=="16/9" ? Math.ceil((16*win.height)/9): Math.ceil((4*win.height)/3);
        marginTop=-( lightCrop ? (win.height*10/100) : 0 );
        marginLeft= -((vid.width-win.width)/2);
    }

    wrapper.css({width:vid.width, height:vid.height, marginTop:marginTop, marginLeft:marginLeft});

};
