// JavaScript Document
$(function() {
//房贷计算器
  $('.calculator-left .check').click(function() {
    $('.calculator-left .check.act').removeClass('act');
    $(this).addClass('act');
  });
//固定导航
  var navH = $(".detile-nav").offset().top;
  $(window).scroll(function(){
    var scroH = $(this).scrollTop();
    if(scroH >= navH){
        $(".detile-nav").css({"position":"fixed","top":0});
    }  else if(scroH<navH){
        $(".detile-nav").css({"position":"static"});
    }
  });
//导航选择
   var AllHet = $(window).height();
   var mainHet= $('.floatCtro').height();
   var fixedTop = (AllHet - mainHet)/2 
   $('div.floatCtro p').click(function(){
    var ind = $('div.floatCtro p').index(this)+1;
    var topVal = $('#float0'+ind).offset().top;
    $('body,html').animate({scrollTop:topVal},1000)
  })
  
   $(window).scroll(scrolls)
   scrolls()
   function scrolls(){
     var f1,f2,f3,f4,f5,f6;
     var fixRight = $('div.floatCtro p');
     var sTop = $(window).scrollTop();
    
     fl = $('#float01').offset().top;
     f2 = $('#float02').offset().top;
     f3 = $('#float03').offset().top;
     f4 = $('#float04').offset().top;
     f5 = $('#float05').offset().top;
     f6 = $('#float06').offset().top;

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
     if(sTop>=f6-100){
       fixRight.eq(5).addClass('cur').siblings().removeClass('cur');
       }
   }
//相册弹窗
  $('.album').click(function() {
    $('.page-bg').addClass('act');
    $(this).next('.album-box').addClass('act');    
  });
  $(".album-cont").thumbnailImg({
      large_elem: ".large_box",
      small_elem: ".small_list",
      left_btn: ".left_btn",
      right_btn: ".right_btn"
  });

    $(".album-right li").click(function(){
        $(".album-right li.act").removeClass("act");
        $(this).addClass("act");
        $(".album-cont.act").removeClass("act");
        $(".album-cont").eq($(this).index()).addClass("act");
    });

  $('.ases-box .statu').click(function() {
      $(this).parents(".box-cont").find("a").removeClass("act");
      $(this).toggleClass('act');
  });
//星星点评
  var degree = ['','1分','2分','3分','4分','5分'];
  //点星星
  $(document).on('mouseover','i[cjmark]',function(){
    var num = $(this).index();
    var pmark = $(this).parents('.revinp');
    var mark = pmark.prevAll('input');
  
    if(mark.prop('checked')) return false;
    
    var list = $(this).parent().find('i');
    for(var i=0;i<=num;i++){
      list.eq(i).attr('class','level_solid');
    }
    for(var i=num+1,len=list.length-1;i<=len;i++){
      list.eq(i).attr('class','level_hollow');
    }
    $(this).parent().next().html(degree[num+1]);

  })
  //点击星星
  $(document).on('click','i[cjmark]',function(){
    var num = $(this).index();
    var pmark = $(this).parents('.revinp');
    var mark = pmark.prevAll('input');
    
    if(mark.prop('checked')){
      mark.val('');
      mark.prop('checked',false);mark.prop('disabled',true);  
    }else{
      mark.val(num);
      mark.prop('checked',true);mark.prop('disabled',false);  
    }
  })
//户型弹窗
  $('.layout-lists .check').click(function() {
    $('.page-bg').addClass('act');
    $(this).next('.layout-box').addClass('act');
  });
  
//关闭弹窗
  $('.close-box,.qx').click(function() {
    $('.ases-box').removeClass('act');
    $('.layout-box').removeClass('act');
    $('.album-box').removeClass('act');
    $('.page-bg').removeClass('act');
  });


    //$("#model-lists-all li").css("display","none");
    //$(".ases-lists li").css("display","none");
    for(jsq=0;jsq<4;jsq++){
        $(".ases-lists li:hidden:eq(0)").fadeIn(1000)
    }

    for(jsq=0;jsq<4;jsq++){
         $(".bedroom-type-all:hidden:eq(0)").fadeIn(1000)
     }

  $(".right-list li a").click(function(){
        $(this).parents("ul").find("li a").removeClass('act');
        $(this).addClass('act');
       var className = "."+$(this).attr("data-class");
        $("#model-lists-all li").css("display","none");
        for(jsq=0;jsq<4;jsq++){
            $(className+":hidden:eq(0)").fadeIn(1000)
        }
        $("#checkall").attr("data-class",$(this).attr("data-class")).html("展开全部");
    });

    $(".checkall").click(function(){
        var className = "."+$(this).attr("data-class");
       for(jsq=0;jsq<4;jsq++){
            $(className+":hidden:eq(0)").fadeIn(2000)
        }
        if($(className+":hidden").length <=0){
            $(this).html("没有数据了");
            return false;
        }
    });

    $(".check-allases").click(function(){

        if($(".ases-lists li:hidden").length <=0){
            $(".check-allases").html("没有数据了");
            return false;
        }
        for(jsq=0;jsq<2;jsq++){
            $(".ases-lists li:hidden:eq(0)").fadeIn(2000)
        }


    });


});