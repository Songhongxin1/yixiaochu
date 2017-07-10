// JavaScript Document
$(function() {
	
	  $('.media-nesw:nth-child(2n)').css("margin-right", "0");
	  $('.trade-news li:nth-child(3n)').css("border-bottom", "none");
	  $('.trade-news li:nth-child(3n)').css("margin-bottom", "0");
  
      //视频弹窗
	  $('.video-play').click(function() {
	    $('.page-bg').addClass('act');  
	    $('.video-cont').addClass('act');    
	  });
	  $('.page-bg').click(function() {
	    $('.page-bg').removeClass('act'); 
	    $('.video-cont').removeClass('act');
	  });
	  
	  //新闻滚动
	  $('#marquee').kxbdSuperMarquee({
	    isEqual:false,
	    distance:55,
	    time:4,
	    direction:'up'
	  });
	  //轮播
	  var w=585;
      var l=0;
      var timer=null;
      var len=$(".scroll ul li").length*2; 
      	$(".scroll ul").append($(".scroll ul").html()).css({'width':len*w, 'left': -len*w/2});
	    timer=setInterval(init,3000);
	    function init(){
	         $(".scroll .next").trigger('click');
	    }
	    $(".scroll ul li").hover(function(){
	         clearInterval(timer);
	        },function(){
	            timer=setInterval(init,3000);
	       });
	      $(".prev").click(function(){
	          l=parseInt($(".scroll ul").css("left"))+w; 
	             showCurrent(l); 
	          });
	          $(".next").click(function(){
	             l=parseInt($(".scroll ul").css("left"))-w;
	            showCurrent(l);
	      });
       function showCurrent(l){ 
	       if($(".scroll ul").is(':animated')){ 
	          return;
	       }
	       $(".scroll ul").animate({"left":l},800,function(){
                if(l==0){ 
               $(".scroll ul").css("left",-len*w/2);   
             }else if(l==(1-len)*w){ 
                 $(".scroll ul").css('left',(1-len/2)*w); 
                }
            }); 
         }
});

 