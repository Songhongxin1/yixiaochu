
window.$ = window.jQuery = require('jquery');
var bxSlider = require('./jquery.bxslider.js');
$('.slider').bxSlider({
    slideWidth: 80,
    minSlides: 1,
    maxSlides: 3,
    moveSlides: 1,
    slideMargin: 10
});
//设置轮播图
var size = $('.img li').length;  
//轮播
for(var i=1;i<=size;i++){   
    var li="<li></li>"; 
    $(".num").append(li);
}

//手动控制图片轮播
$(".img li").eq(0).css({'display':'list-item'});  
$(".num li").eq(0).addClass("active");  
$(".num li").mouseover(function(){
    $(this).addClass("active").siblings().removeClass("active");  
    var index=$(this).index();  
    i=index;  
    $(".img li").eq(index).stop().fadeIn(800).siblings().stop().fadeOut(800);   
})
//自动控制图片轮播
var i=0;  
var t=setInterval(move,2500);  
//向左切换函数
function moveL(){
    i--;
    if(i==-1){
        i=size-1;  
    }
    $(".num li").eq(i).addClass("active").siblings().removeClass("active");  
    $(".img li").eq(i).fadeIn(800).siblings().fadeOut(800);
}
//向右切换函数
function move(){
    i++;
    if(i==size){
        i=0;  
    }
    $(".num li").eq(i).addClass("active").siblings().removeClass("active");  
    $(".img li").eq(i).fadeIn(800).siblings().fadeOut(800);  
}
//定时器开始与结束
$(".out").hover(function(){
    clearInterval(t);   
},function(){
    t=setInterval(move,2500);  
})
$('.foods-lists li:nth-child(2n)').css("margin-right", "0");
/*列表翻页*/
$.fn.changeImg=function(options){       
    var defalutes={
        'boxWidth':800,
        'changeLen':5,
        'changeSpend':300,
        'autoChange':true,
        'changeHandle':true,
        'autoTime':5000
    };
    
    var ops=$.extend(defalutes, options),
        $that=$(this);
    
    var _html='<a href="javascript:;" class="change-bnt prev-bnt"></a><a href="javascript:;" class="change-bnt next-bnt"></a>';
    
    
    var $changeBox=$that.find(".focus-img-con"),
        $changeUl=$changeBox.find("ul"),
        $changeLi=$changeBox.find("li"),
        $changePrev='',
        $changeNext='',
        _len=$changeLi.length,
        _timer='';
        
        
    $changeBox.width(ops.boxWidth);
    if(ops.changeHandle){
        $that.append(_html);
        $changePrev=$that.find(".prev-bnt");
        $changeNext=$that.find(".next-bnt");
    };
    
    
    var oWidth=$changeLi.eq(0).outerWidth(),
        bWidth=oWidth*_len,
        _handle=true;
    $changeUl.width(bWidth);
    
    
    $changePrev.on("click",function(){
        if(_handle){
            _handle=false;
            clearInterval(_timer);
            $changeUl.css('right','auto');
            for(var i=0; i<ops.changeLen; i++){
                var _li=$changeUl.find("li").eq(i).clone(true);
                $changeUl.append(_li);
            };
            $changeUl.stop().animate({
                'left':-oWidth*ops.changeLen
            },300,function(){
                for(var i=0; i<ops.changeLen; i++){
                    $changeUl.find("li").eq(0).remove();
                };
                $changeUl.css('left',0);
                _handle=true;
            });
            autoPlay();
        };
    });
    
    var _len1=_len-1;
    $changeNext.on("click",function(){
        
        $changeUl.css('right',0);
        if(_handle){
            _handle=false;
            clearInterval(_timer);
            $changeUl.css('left','auto');
            for(var i=0; i<ops.changeLen; i++){
                var $_li=$changeUl.find("li").eq(_len1).clone(true);
                $changeUl.prepend($_li);
            };
            
            $changeUl.stop().animate({
                'right':-oWidth*(_len-ops.changeLen)
            },300,function(){
                for(var i=0; i<ops.changeLen; i++){
                    $changeUl.find("li").eq(_len).remove();
                };
                _handle=true;
            });
            autoPlay();
        };
    });
    
    
    function autoPlay(){
        if(ops.autoChange){
            _timer=setInterval(function(){
                $changePrev.click();
            },ops.autoTime)
        }
    }
    autoPlay(); 
    
    return this;
}
