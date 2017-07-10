/** 
 * 公共模块
 * 
 * @author: james
 */
define(function(require, exports, module){
    window.jQuery = window.$ = require("jquery");
    require('dialog');
    require('jquerycookie');
    require('jqueryplaceholder');
    
    module.exports = {
            /**
             * 加载日历控件
             */
            initDatePicker: function(params) {
                $(".Wdate").focus(function(){
                    WdatePicker(params);
                });
            },

    		
    		/**
    		 * 获取验证码
    		 */
    		getCode:function(){
    			$('.J_get_code').click(function(){
    		        var btn = $(this);
    		        var count = 60;
    		        var mobile_num = $('input[name="phone"]').val();
    		        var token = $(".J_user_token").val();
    		        var is_mobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
    		        if(token == ''){
    		        	showDialog('参数错误');
    		            return false;
    		        }
    		        if(!is_mobile.test(mobile_num)){
    		        	showTips('J_phone', '请输入11位有效手机号！', 'top');
    		            return false;
    		        }
    		        $.post(
			        		"/publicservice/mobile_code", 
			        		{mobile:mobile_num,token:token},
			        		function(data){
			        			if(data.status !=0){
			        				showDialog(data.msg);
			        			}
			        		},
			        		'json'
			        );
    		        
    		        var resend = setInterval(function(){
    		            count--;
    		            if (count > 0){
    		                btn.val(count+"秒后可重新获取");
    		                $.cookie("captcha", count, {path: '/', expires: (1/86400)*count});
    		            }else {
    		                clearInterval(resend);
    		                btn.val("获取验证码").removeAttr('disabled style');
    		            }
    		        }, 1000);
    		        btn.attr('disabled',true).css('cursor','not-allowed');
    		    });  
    			
    		},
    		
    		/**
    		 * 导航菜单效果
    		 */
    		changeMenu:function(){
    			 	$(".menu li a").wrapInner( '<span class="out"></span>' );     
    			 	$(".menu li a").each(function() {
    			 		$( '<span class="over">' +  $(this).text() + '</span>' ).appendTo( this );
    			 	});
    			 	$(".menu li a").hover(function() {
    			 		$(".out", this).stop().animate({'top':  '90px'},  300); 
    			 		$(".over",  this).stop().animate({'top':  '0px'},   300); 
    			 	}, function() {
    			 		$(".out", this).stop().animate({'top':  '0px'},   300); 
    			 		$(".over",  this).stop().animate({'top':  '-90px'}, 300); 
    			 	});
    		},
    		
    		/**
    		 * IEplaceholder
    		 */
    		setPlaceholder:function(){
    			 $('input').placeholder();
    		},
    		
    		 /**
    	     * 暴露提示信息模块
    	     */
    		showTips:showTips,
    		
    		/**
    		 * 暴露弹出框
    		 */
    		showDialog:showDialog
    		
    		
    }
    
    /**
     * 绝对定位的提示信息
     * 
     * @param id
     * @param msg
     * @param position
     */
    function showTips (id, msg, position){
		var position = arguments[2] ? arguments[2] : 'right';
    	 var d = dialog({
             align: position,
             content: msg,
             quickClose: true
         });
         d.show(document.getElementById(id));
	}
    
    /**
     * 普通提示信息
     * 
     * @param msg
     * @param title
     * @param url 
     */
    function showDialog(msg, title, url){

    	var title = arguments[1] ? arguments[1] : '提示信息';
    	var url = arguments[2] ? arguments[2] : '';
        var d = dialog({
            title: title,
            content: msg,
            okValue: '确定',
            ok: function () {
            	if(url != '')
            	{
            		window.location.href=url;
            	}
                return true;
            }
        });
        d.width(200);
        d.showModal();
    }
    
});

