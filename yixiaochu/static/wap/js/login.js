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
    	    	  
	    	    //var showTips = $('.message');
	        	//showTips.text('手机号不能为空！').show();
	        	
    			$(".J_login").click(function(){
    				
    				var user_mobile = $("input[name='phone']").val();
				 	var psw = $("input[name='password']").val();
				    var token = $(".J_user_token").val();
				    var back_url = $('input[name="back_url"]').val();
				     
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
    		        if(psw == ''){
    		        	common.showTips('J_password', '请输入密码！', 'top');
    		            $('input[name="password"]').focus();
    		            return false;
    		        }
 
    		        $.post(
			    			'/passport/check_login', 
			    			{mobile:user_mobile,password:psw,token:token,auto_login:1,back_url:back_url}, 
			    			function(data){
			    				 
			    				if(data.status != '0'){
			    					common.showDialog(data.msg);
			    				}else{
			    					window.location.href=data.back_url;
			    				}
			    	});
			        
    		        
    		    });  
    		}
    }
    
});
 