/**--------------------------------------------------------------------
# Package - JoomlaMan Module
# Version 1.0
# --------------------------------------------------------------------
  # Author - JoomlaMan http://www.joomlaman.com
  # Copyright © 2012 - 2013 JoomlaMan.com. All Rights Reserved.
  # @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
  # Websites: http://www.JoomlaMan.com
  ---------------------------------------------------------------------* */
jQuery.noConflict();
(function ($) {
  $.fn.ztSelectMulti = function(){
    this.each(function () {
      var $this = $(this);
      var $div = $('<div>').addClass('ztlist-multipe');
      $this.after($div);
      $.each($this.find('option'), function(i,el){
        var $option = $('<div>').addClass('option').attr('index',i).text($(el).text());
        if($(el).is(':selected')){
          $option.addClass('selected');
        }
        $option.click(function(){
          $(this).toggleClass('selected');
          if($(this).hasClass('selected')){
            $this.find('option').eq(i).attr('selected', true);
          }else{
            $this.find('option').eq(i).attr('selected', false);
          }
        }).appendTo($div);
      });
      $div.wrap('<div style="float:left;">');
      var ready = false;
      setInterval(function(){
        if($this.parents('.pane-slider').hasClass('pane-down') && $this.parent().css('display') != 'none' && !ready){
          $div.jScrollPane({
            autoReinitialise:true,
            showArrows:true,
            scrollbarWidth:27,
            scrollbarMargin:0
          });
          ready = true;
        }
      }, 100);
    $this.css({
      display:'none'
    });
    });
};
$.fn.ztSelectSingle = function(){
  this.each(function () {
    var $this = $(this);
    $this.wrap('<div style="float:left"/>');
    var $div = $('<div>').addClass('ztlist-single-options');
    var $div_select = $('<div>').addClass('ztlist-single').addClass('slideUp');
    $this.after($div);
    $this.after($div_select);
    jQuery(document).click(function(){
      $div.parent().slideUp();
      $div_select.removeClass('slideDown').addClass('slideUp');
    })	
    $div_select.toggle(function(){
      if($(this).hasClass('slideDown')){
        $div.parent().slideUp();
        $(this).removeClass('slideDown').addClass('slideUp');
      }else{
        $div.parents('.overlay').css({
          display:'block'
        });
        $div.parent().slideDown();
        $(this).removeClass('slideUp').addClass('slideDown');
      }
    },function(){
      if($(this).hasClass('slideDown')){
        $div.parent().slideUp();
        $(this).removeClass('slideDown').addClass('slideUp');
      }else{
        $div.parents('.overlay').css({
          display:'block'
        });
        $div.parent().slideDown();
        $(this).removeClass('slideUp').addClass('slideDown');
      }
    });
    $.each($this.find('option'), function(i,el){
      var $option = $('<div>').addClass('option').attr('index',i).text($(el).text());
      if($(el).is(':selected')){
        $option.addClass('selected');
        $div_select.text($(el).text());
      }
      $option.click(function(){
        $(this).addClass('selected');
        $this.find('option').eq(i).attr('selected', true);
        $div_select.text($(this).text());
        $this.trigger('change');
        $div.find('.option').not(this).removeClass('selected');
        $div.parent().slideUp();
      }).appendTo($div);
    });
    var ready = false;
    $div.wrap('<div class="overlay" style="position:absolute; z-index:1000"/>');
    setInterval(function(){
      if($this.parents('.pane-slider').hasClass('pane-down') && $this.parents('li').css('display') != 'none' && !ready){
        if($div.height()>160) $div.height(160);
        $div.jScrollPane({
          showArrows:true,
          scrollbarWidth:28,
          scrollbarMargin:0
        });
        $div.parent().not('.overlay').css({
          display:'none'
        });
        ready = true;
      }
    }, 100);
    $this.css({
      display:'none'
    });
  });
};
$.fn.ztCheckbox = function(){
  this.each(function () {
    var $this = $(this);
    //var $hidden = $('<input type="hidden" value="0"/>').attr("name", $this.attr('name'));
    var $div = $('<div>').addClass('ztcheckbox');
    if($this.is(':checked')){
      $div.addClass('checked');
    }
    $div.click(function(){
      $(this).toggleClass('checked');
      if($(this).hasClass('checked')){
        $this.attr('checked', true);
      }else{
        $this.attr('checked', false);
      }
      $this.trigger('click');
    });
    $this.after($div);
    $this.css({
      display:'none'
    });
  });
}
	
$.fn.ztRadio = function(){
  this.each(function () {
    var $this = $(this);
    var $div = $('<div>').addClass('ztradio').attr('name',$this.attr('name'));
    if($this.is(':checked')){
      $div.addClass('checked');
    }
    $div.click(function(){
      $.each($('.ztradio'), function(i, el){
        if($(el).attr('name') == $div.attr('name')){
          $(el).removeClass('checked');
        }
      });
      $(this).addClass('checked');
      $this.attr('checked', true);
      $this.trigger('click');
    });
    $this.after($div);
    $this.css({
      display:'none'
    });
  });
}
$.fn.ztOnOff = function(){
  this.each(function () {
    var $this = $(this);
    var $div = $('<div>').addClass('ztonoff').attr('name',$this.attr('name'));
    var $spanon = $('<span>').addClass('ztonoff-on');
    var $spanoff = $('<span>').addClass('ztonoff-off');
    var $hidden = $('<input type="hidden" value="0"/>');
    $this.after($hidden);
    $div.append($spanon).append($spanoff).append('<div style="clear:both"/>');
    if($this.is(':checked')){
      $div.addClass('checked');
      $hidden.attr("name", "");
    }else{
      $hidden.attr("name", $this.attr('name'));
    }
    if($this.hasClass('showhide')){
      $div.addClass('showhide');
    }else{
      $div.addClass('onoff');
    }
    $spanon.click(function(){
      $div.addClass('checked');
      $this.attr('checked', 'checked');
      $this.trigger('change');
      $hidden.attr("name", "");
    });
    $spanoff.click(function(){
      $div.removeClass('checked');
      alert($this.attr('id'));
      $this.attr('checked', false);
      $this.trigger('change');
      $hidden.attr("name", $this.attr('name'));
    });
    $this.after($div);
    $div.wrap('<div style="float:left;">');
    $this.css({
      display:'none'
    });
  });
}
	
$.fn.ztMedia= function(){
  this.each(function () {
    var $this = $(this);
    $this.parent().parent().css({
      position:'relative'
    });
    $this.parent().parent().find('.modal').addClass('media-upload-btn');
    $this.parent().parent().find('a').not('.modal').addClass('ztmedia-clear').html('X');
  });
}
$(document).ready(function(){
  $('.zt-field input[type=radio]').ztRadio();
  $('select.zt-field.multi').ztSelectMulti();
  $('input.zt-field.ztmedia').ztMedia();
  $('select.zt-field.single').ztSelectSingle();
  $('input[type=checkbox].zt-field.onoff,input[type=checkbox].zt-field.showhide').ztOnOff();
})
})(jQuery);