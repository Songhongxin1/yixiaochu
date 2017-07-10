/** 
 * @author: james
 */
define(function(require, exports, module){
    window.jQuery = window.$ = require("jquery");
    require('dialog');
    var common = require('public');
    module.exports = {
    		doReg: function() {
 	    	   $("body").keydown(function() {
	    	        if (event.keyCode == "13") {
	    	            $(".J_reg").click();
	    	        }
	    	    });
    			 $(".J_reg").click(function(){
    				 	var user_mobile = $("input[name='phone']").val();
    				 	var psw = $("input[name='password']").val();
    				 	var re_psw = $("input[name='repassword']").val();
    				 	var verify = $("input[name='code']").val();
    				 	var token = $(".J_user_token").val();
    				 	  
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
    			        
    			        var pswPattern = /^((?=.*[0-9].*)(?=.*[A-Za-z].*))[_0-9A-Za-z]{6,20}$/;
    			        if(!pswPattern.test(psw)){
    			        	common.showTips('J_password', '密码必须由数字、字母组合且大于6位！');
    			            $('input[name="password"]').focus();
    			            return false;
    			        }
    			        
    			        if(re_psw != psw){
    			        	common.showTips('J_repassword', '两次输入的密码不一致！');
    			            $('input[name="repassword"]').focus();
    			            return false;
    			        }
    			        if(verify == ''){
    			        	common.showTips('J_code', '请输入验证码！');
    			            $('input[name="code"]').focus();
    			            return false;
    			        }
    			        
    			        var arge = $('input[name="argee"]:checked').val();
            			if(arge == undefined){
            				common.showDialog('同意《注册条款》和《免责声明》才能注册');
            				return false;
            			}
            			
    			        $.post(
    			    			'/passport/check_reg', 
    			    			{mobile:user_mobile,password:psw,repassword:re_psw,verify:verify,token:token}, 
    			    			function(data){
    			    				if(data.status != '0'){
    			    					common.showDialog(data.msg);
    			    				}else{
    			    					common.showDialog("注册成功，点击确定跳转到登录页面", "", data.url);
    			    				}
    			    	});
    			        
    			        
    			    }); 
    			    
    		},
    		
    		checkArgee:function(){
    			$('input[name="argee"]').click(function(){
    				var arge = $('input[name="argee"]:checked').val();
        			if(arge == undefined){
        				common.showDialog('同意《注册条款》和《免责声明》才能注册');
        			}
    			});
    		},
    		//注册获取验证码
    		getcode:function(){
    		    $('.J_get_code').click(function(){
                    var btn = $(this);
                    var count = 60;
                    var mobile_num = $('input[name="phone"]').val();
                    var token = $(".J_user_token").val();
                    var is_mobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
                    if(!is_mobile.test(mobile_num)){
                        common.showTips('J_phone', '请输入11位有效手机号！');
                        return false;
                    }
                    //判断手机号是否注册
                    $.post("/passport/exist_phone", {mobile:mobile_num}, function(data){
                        if(data.status == -1){
                            common.showDialog(data.msg);
                            return false;
                        }else if(data.status == -2){
                            common.showDialog(data.msg, '提示信息', '/passport/login');
                            return false;
                        }else{
                            $.post(
                                    "/publicservice/mobile_code", 
                                    {mobile:mobile_num,token:token},
                                    function(data){
                                        if(data.status !=0){
                                            common.showDialog(data.msg);
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
                        }
                    })
                    
                    
                });
    		}
    } 
    
});