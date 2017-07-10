// JavaScript Document
$(function() {
  $('.video-play').click(function() {
    $('.page-bg').addClass('act');  
    $('#banner-video').addClass('act');    
  });
  $('.video-but').click(function() {
  	$('.page-bg').addClass('act');  
    $(this).children('.video-cont').addClass('act');
  });  
  $('.ewm-weibo').hover(function() {
    $(this).prev('.ewm-qq').children('.ewm-info').hide();
  }, function() {
    $(this).prev('.ewm-qq').children('.ewm-info').show();
  });
  $('.page-bg').click(function() {
    $('.page-bg').removeClass('act'); 
    $('.video-cont').removeClass('act');
  });
  $('.buy-hot .hot-list').hover(function() {
    $('.num,.buy-img,.buy-text').removeClass('act');
    $(this).children('.num,.buy-img,.buy-text').addClass('act');
  }, function() {
  });
  
  
//轮播
  $('.play,.play ul li,.play ul img').width(document.body.clientWidth);
  var oDiv = $("#play"); 
  var count = $("#play ul li").length;  
  var countwidth = $("#play ul li").width();  
  var oUl = $("#play ul").css("width",count*countwidth); 
  var now = 0;
  var next = $("#next");
  var prev = $("#prev");
  
  for(var i = 0; i < count; i++){
    $("#play ol").append("<li>" + Number(i+1) + "</li>");
    $("#play ol li:first").addClass("active");
  }
  
  var aBtn = $("#play ol li");
  aBtn.each(function(index){
    $(this).click(function(){
      clearInterval(timer);
      tab(index);
      timer=setInterval(autoRun,2000);
    });
  });
  
  function tab(index){
    now = index;
    aBtn.removeClass("active");
    aBtn.eq(index).addClass("active");
    oUl.stop(true,false).animate({"left":-countwidth * now},400);
  }
  
  next.click(function(){
    clearInterval(timer);
    now++;
    if(now==count){
      now=0;
    }
    tab(now);
    timer=setInterval(autoRun, 2000);
  });
  
  prev.click(function(){
    clearInterval(timer);
    now--;
    if(now==-1){
      now=count-1;
    }
    tab(now);
    timer=setInterval(autoRun, 2000);
  });
  
  function autoRun(){
    now++;
    if(now==count){
      now=0;
    }
    tab(now);
  };
  var timer=setInterval(autoRun, 2000);
});