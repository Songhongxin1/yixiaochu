// JavaScript Document
$(function() {
        $(".slideInner").slide({
            slideContainer: $('.slideInner a'),
            effect: 'easeOutCirc',
            autoRunTime: 4000,
            slideSpeed: 1000,
            nav: true,
            autoRun: true,
            prevBtn: $('a.prev'),
            nextBtn: $('a.next')
        });

  $('.news-hot li:last-child').css("border-bottom", "none");
//  $('.premises li:nth-child(4n)').css("margin-right", "0");


  //视频弹窗
  $('.video').click(function() {
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
 var w=640;
  var l=0;
  var timer=null;
  var len=$(".scroll ul li").length*2; 
 $(".scroll ul").append($(".scroll ul").html()).css({'width':len*w, 'left': -len*w/2});
timer=setInterval(init,4000);
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

$(function() {
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
        $("#focus .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); 
    }
});
//根据地区查看楼盘
$(function(){
	$("#chosen_house li").mouseover(function(){
		//首先移除激活的地区显示
		var area_id = $("#chosen_house li a[class=act]").parent("li").attr('data-area-id');
		$("#chosen_house li a[class=act]").removeClass('act');
		$('#area_'+area_id).hide();
		var new_area_id = $(this).attr('data-area-id');
		$(this).children().addClass('act');
		$("#area_"+new_area_id).show();
	})
})