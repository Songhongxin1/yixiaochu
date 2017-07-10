// JavaScript Document
$(function() {
  $('.media-lists.style2 li:nth-child(3n)').css("margin-right", "0");
  $('.media-lists.statu li:nth-child(3n)').css("margin-right", "0");
  $('.media-lists.style3 li:nth-child(2n)').css("margin-right", "0");
  $('.media-lists.style5 li:nth-child(2n)').css("margin-right", "0");
  $('.media-cont.base li:nth-child(3n)').css("margin-right", "0");
  $('.media-right-nav p:first-child').css("border-top", "none");
  $('.media-right-nav p:last-child').css("border-bottom", "none");

  /*导航选择*/
  var AllHet = $(window).height();
   var mainHet= $('.media-right-nav').height();
   var fixedTop = (AllHet - mainHet)/2 
   $('div.media-right-nav p').click(function(){
    var ind = $('div.media-right-nav p').index(this)+1;
    var topVal = $('#float0'+ind).offset().top;
    $('body,html').animate({scrollTop:topVal},800)
  })
   $(window).scroll(scrolls)
   scrolls()
   function scrolls(){
     var f1,f2,f3,f4,f5;
     var fixRight = $('div.media-right-nav p');
     var sTop = $(window).scrollTop();
     fl = $('#float01').offset().top;
     f2 = $('#float02').offset().top;
     f3 = $('#float03').offset().top;
     f4 = $('#float04').offset().top;
     f5 = $('#float05').offset().top;
     if(sTop>=fl){
       fixRight.eq(0).addClass('cur').siblings().removeClass('cur');
       }
     if(sTop>=f2-100){
       fixRight.eq(1).addClass('cur').siblings().removeClass('cur');
       }
     if(sTop>=f3-100){
       fixRight.eq(2).addClass('cur').siblings().removeClass('cur');
       }
     if(sTop>=f4-100){
       fixRight.eq(3).addClass('cur').siblings().removeClass('cur');
       }
     if(sTop>=f5-100){
       fixRight.eq(4).addClass('cur').siblings().removeClass('cur');
       }
   }
 
//视频弹窗
  $('.video-play').click(function() {
    $('.page-bg').addClass('act');  
    $('.video-cont').addClass('act');    
  });
  $('.video-cont .close').click(function() {
    $('.page-bg').removeClass('act'); 
    $('.video-cont').removeClass('act');
  });
});
//轮播
$(function(){
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