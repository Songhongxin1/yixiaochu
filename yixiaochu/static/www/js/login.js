/** 
 * @author: james
 */
define(function(require, exports, module){
    window.jQuery = window.$ = require("jquery");
    require('dialog');
    var common = require('public');
    module.exports = {
    		login:function(){
	    	   $("body").keydown(function() {
	    	        if (event.keyCode == "13") {
	    	            $(".J_login").click();
	    	        }
	    	    });
    	    	  
    			$(".J_login").click(function(){
    				
    				var user_mobile = $("input[name='phone']").val();
				 	var psw = $("input[name='password']").val();
				    var token = $(".J_user_token").val();
				    var back_url = $('input[name="back_url"]').val();
				    var auto_Login = $('input[name="auto_Login"]:checked').val();
				     
				    if(user_mobile == ''){
    		        	common.showTips('J_phone', '手机号不能为空！');
    		            $('input[name="phone"]').focus();
    		            return false;
    		        }
    		        var isMobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
    		        if(!isMobile.test(user_mobile)){
    		        	common.showTips('J_phone', '手机号不正确！');
    		            $('input[name="phone"]').focus();
    		            return false;
    		        }
    		        if(psw == ''){
    		        	common.showTips('J_password', '请输入密码！');
    		            $('input[name="password"]').focus();
    		            return false;
    		        }
    		        
    		        if(auto_Login == undefined){
    		        	auto_Login = 0;
    		        }
    		        
    		        $.post(
			    			'/passport/check_login', 
			    			{mobile:user_mobile,password:psw,token:token,auto_login:auto_Login,back_url:back_url}, 
			    			function(data){
			    				 
			    				if(data.status != '0'){
			    					common.showDialog(data.msg);
			    				}else{
			    					window.location.href=data.back_url;
			    				}
			    	});
			        
    		        
    		    });  
    		},
    		
    		checkAutoLogin:function(){
    			$('input[name="auto_Login"]').click(function(){
    				var auto_Login = $('input[name="auto_Login"]:checked').val();
        			if(auto_Login == 1){
        				common.showDialog('请确认你的电脑环境是安全的，不要在开放的环境如网吧中使用自动登录');
        			}
    			});
    		}
    }
    
});
 