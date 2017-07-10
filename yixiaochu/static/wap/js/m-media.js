// JavaScript Document
$(function() {
  $('.spread').click(function() {
    $(this).removeClass('act');
    $('.collect').addClass('act');
  });
  $('.collect-but').click(function() {
    $('.collect').removeClass('act');
    $('.spread').addClass('act');
  });
  $('.video-cont').click(function() {
    $('.page-bg').addClass('act');
    $(this).next('.video-detile').addClass('act');    
  });
  $('.close-video').click(function() {
    $('.page-bg').removeClass('act');
    $('.video-detile').removeClass('act');    
  });
  
  function b(){ 
	    t = parseInt(x.css('top'));
	    y.css('top','19px');  
	    x.animate({top: t - 19 + 'px'},'slow'); 
	    if(Math.abs(t) == h-19){ 
	      y.animate({top:'0px'},'slow');
	      z=x;
	      x=y;
	      y=z;
	    }
	    setTimeout(b,3000);
	  }
	  $(document).ready(function(){
	    $('.swap').html($('.news_li').html());
	    x = $('.news_li');
	    y = $('.swap');
	    h = $('.news_li li').length * 19; 
	    setTimeout(b,3000);    
	  })
});