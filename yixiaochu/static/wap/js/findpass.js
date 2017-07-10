/** 
 * @author: james
 */
define(function(require, exports, module){
    window.jQuery = window.$ = require("jquery");
    require('dialog');
    var common = require('public');
    module.exports = {
    		findPass:function(){
    			$("body").keydown(function() {
	    	        if (event.keyCode == "13") {
	    	            $(".J_findpass").click();
	    	        }
	    	    });
 
    			$(".J_findpass").click(function(){
    				var user_mobile = $("input[name='phone']").val();
				 	var psw = $("input[name='password']").val();
				 	var re_psw = $("input[name='repassword']").val();
				 	var verify = $("input[name='code']").val();
				 	var token = $(".J_user_token").val();
				 	
        			if(user_mobile == ''){
        	            common.showTips('J_phone', '手机号不能为空！', 'top');
        	            $('input[name="phone"]').focus();
        	            return false;
        	        }
        	        var isMobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
        	        if(!isMobile.test(user_mobile)){
        	            common.showTips('J_phone', '手机号不正确！', 'top');
        	            $('input[name="phone"]').focus();
        	            return false;
        	        }
        	        if(verify == ''){
        	            common.showTips('J_code', '请输入验证码！', 'top');
        	            $('input[name="code"]').focus();
        	            return false;
        	        }
        	        if(psw == ''){
        	            common.showTips('J_password', '请输入密码！', 'top');
        	            $('input[name="password"]').focus();
        	            return false;
        	        }
        	        
        	        var pswPattern = /^((?=.*[0-9].*)(?=.*[A-Za-z].*))[_0-9A-Za-z]{6,20}$/;
			        if(!pswPattern.test(psw)){
			        	common.showTips('J_password', '密码必须由数字、字母组合且大于6位！', 'top');
			            $('input[name="password"]').focus();
			            return false;
			        }
			        
        	        if(re_psw != psw){
        	            common.showTips('J_repassword', '两次输入的密码不一致！', 'top');
        	            $('input[name="repassword"]').focus();
        	            return false;
        	        }
        	        $.post(
        	    			'/passport/check_find', 
        	    			{mobile:user_mobile,password:psw,repassword:re_psw,verify:verify,token:token}, 
        	    			function(data){
        	    				if(data.status != '0'){
        	    					common.showDialog(data.msg);
        	    				}else{
        	    					common.showDialog("请使用新密码登陆", "密码找回成功", '/passport/login');
        	    				}
        	    	});
        		});
    		}
    		
    }
    
});