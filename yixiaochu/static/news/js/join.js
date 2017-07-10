// JavaScript Document
$(document).ready(function(){
    $('.zzsc_box ul li:nth-child(3n)').css("margin-right", "0");
    $(".join").click(function() {
        $(".page-bg").addClass("act");
        $(".join-info").addClass("act");
        $(".page-bg").click(function() {
           $(".page-bg").removeClass("act");
           $(".join-info").removeClass("act");
        });
    });


    $("#zzsc").find(".pre").hide();
    var page=1;
    var $show=$("#zzsc").find(".zzsc_box");
    var page_count=$show.find("ul").length;
    var $width_box=$show.parents("#wai_box").width();
    $show.find("li").hover(function(){
        $(this).find(".title").show();                              
    },function(){
        $(this).find(".title").hide();
    })
    function nav(){
        if(page==1){
            $("#zzsc").find(".pre").hide().siblings(".next").show();
        }else if(page==page_count){
            $("#zzsc").find(".next").hide().siblings(".pre").show();
        }else{
            $("#zzsc").find(".pre").show().siblings(".next").show();
        }
    }
    $("#zzsc").find(".next").click(function(){
        if(!$show.is(":animated")){
            $show.animate({left:'-='+$width_box},"normal");
            page++;
            nav();
            $number=page-1;
            $("#zzsc").find(".nav a:eq("+$number+")").addClass("now").siblings("a").removeClass("now");
            return false;
        }
    })
    $("#zzsc").find(".pre").click(function(){
    if(!$show.is(":animated")){
        $show.animate({left:'+='+$width_box},"normal");
        page--;
        nav();
        $number=page-1;
        $("#zzsc").find(".nav a:eq("+$number+")").addClass("now").siblings("a").removeClass("now");
        }
        return false;
    })
    $("#zzsc").find(".nav a").click(function(){
            $index=$(this).index();
            page=$index+1;
            nav();
            $show.animate({left:-($width_box*$index)},"normal");    
            $(this).addClass("now").siblings("a").removeClass("now");
            return false;
    })
                           
});

//判断手机号是否合法
var phones = $("input[name=phone]");
phones.blur(function(){
	var tel = phones.val();
	//alert(tel);
	var reg = /^0?1[3|4|5|8|7][0-9]\d{8}$/;
	 if (!reg.test(tel)) {
	      showDialog("手机号格式不正确","","/join");
	    }
});

//弹框函数
function showDialog(msg, title, url){
    var title = arguments[1] ? arguments[1] : '提示信息';
    var url = arguments[2] ? arguments[2] : '';
    var d = dialog({
        title: title,
        content: msg,
        modal:false,
        okValue: '确定',
        ok: function () {
            if(url != '')
            {
                window.location.href=url;
            }
            return true;
        }
    });
    d.width(320);
    d.show();
}

//ajax请求
$(".submit").click(function(){
	var phone = $("input[name='phone']").val();
	var company = $("input[name='company']").val();
	var username = $("input[name='username']").val();
	var address = $("input[name='address']").val();
	if(!company){
    	$("input[name='company']").focus();
        showDialog("公司不能为空","","/join");
        return false;
    }
    if(!username){
    	$("input[name='username']").focus();
        showDialog("姓名不能为空","","/join");
        return false;
    }
    if(!phone){
    	$("input[name='phone']").focus();
        showDialog("手机号不能为空","","/join");
        return false;
    }
    if(!address){
    	$("input[name='address']").focus();
        showDialog("地址不能为空","","/join");
        return false;
    }
	$.post('/join/index', {company:company,username:username,phone:phone,address:address},function(data){ 
	    if(data.status == -1){
	    	showDialog("手机号已存在","","/Join");
	    }else{
	    	showDialog("加盟信息已提交","","/Join");
	    }
	})
})