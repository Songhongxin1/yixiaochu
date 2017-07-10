// JavaScript Document
$(function() {
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
  $('.case-list:nth-child(4n)').css("margin-right", "0");
  var sWidth = $("#focus").width(); 
    var len = $("#focus ul li").length; 
    var index = 0;
    var picTimer;    
    var btn = "<div class='btnBg'></div><div class='title'></div><div class='btn'>";
    for(var i=0; i < len; i++) {
        btn += "<span></span>";
    }
    $("#focus").append(btn);
    $("#focus .btnBg").css("opacity",0.5);
    $("#focus .btn span").css("opacity",0.4).mouseover(function() {
        index = $("#focus .btn span").index(this);
        showPics(index);
    }).eq(0).trigger("mouseover");
    $("#focus .preNext").css("opacity",0.2).hover(function() {
        $(this).stop(true,false).animate({"opacity":"0.5"},300);
    },function() {
        $(this).stop(true,false).animate({"opacity":"0.2"},300);
    });    
    $("#focus ul").css("width",sWidth * (len));  
    $("#focus").hover(function() {
        clearInterval(picTimer);
    },function() {
        picTimer = setInterval(function() {
            showPics(index);
            index++;
            if(index == len) {index = 0;}
        },3000); 
    }).trigger("mouseleave");     
    function showPics(index) { 
        var nowLeft = -index*sWidth; 
        $("#focus ul").stop(true,false).animate({"left":nowLeft},300);
        $("#focus .title").text($("#focus ul li").eq(index).contents("a").contents("img").attr("alt"));
        $("#focus .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //
    }
});