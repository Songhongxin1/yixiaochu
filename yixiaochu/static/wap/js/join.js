    $(document).ready(
        function() {
            var nowpage = 0;
            $(".container").swipe(
                {
                    swipe:function(event, direction, distance, duration, fingerCount) {
                         if(direction == "up"){
                            nowpage = nowpage + 1;
                         }else if(direction == "down"){
                            nowpage = nowpage - 1;
                         }

                         if(nowpage > 6){
                            nowpage = 6;
                         }

                         if(nowpage < 0){
                            nowpage = 0;
                         }

                        $(".container").animate({"top":nowpage * -100 + "%"},400);

                        $(".page").eq(nowpage).addClass("cur").siblings().removeClass("cur");
                    }
                }
            );
        }
    );
    $(function(){
       var mySwiper = new Swiper('.swiper-container',{
        pagination: '.pagination',
        loop:true,
        grabCursor: true,
        paginationClickable: true
      })
      $('.arrow-left').on('click', function(e){
        e.preventDefault()
        mySwiper.swipePrev()
      })
      $('.arrow-right').on('click', function(e){
        e.preventDefault()
        mySwiper.swipeNext()
      }) 


      var mySwiper = new Swiper('.swiper1-container',{
        pagination: '.pagination1',
        loop:true,
        grabCursor: true,
        paginationClickable: true
      })

      $(".join").click(function() {
        $(".page-bg").addClass("act");
        $(".join-info").addClass("act");
        $(".page-bg").click(function() {
           $(".page-bg").removeClass("act");
           $(".join-info").removeClass("act");
        });
      });
    });


    
    $(".submit").click(function(){
        var company = $("input[name='company']").val();
        var username = $("input[name='username']").val();
        var phone = $("input[name='phone']").val();
        var address = $("input[name='address']").val();
        if(!company){
        	$("input[name='company']").focus();
            $('.message').html('公司不能为空');
            return false;
        }
        if(!username){
        	$("input[name='username']").focus();
            $('.message').html('姓名不能为空');
            return false;
        }
        if(!phone){
        	$("input[name='phone']").focus();
            $('.message').html('手机号不能为空');
            return false;
        }else{
        	var isMobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
	        if(!isMobile.test(phone)){
	        	$('.message').html('手机格式错误');
	            $('input[name="phone"]').focus();
	            return false;
	        }
        }
        if(!address){
        	$("input[name='address']").focus();
            $('.message').html('地址不能为空');
            return false;
        }
        
        $.post('/news/join', {company:company,username:username,phone:phone,address:address},function(data){ 
            if(data.status == -1){
            	$('.message').html(data.msg);
            }else{
            	$(".join-info").removeClass("act");
            	$('.page-bg').show();
            	var n = 2
                setInterval(function(){
                    if(n>=0){
                        $("#time").html(n);
                    }
                     n--;
                    if(n<0){
                        window.location.href = mobileUrl+"/news/join";
                    }
                },1000);
            }
        })
    })
