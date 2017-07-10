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
    require('lazyimg');
    
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
    		        if(!is_mobile.test(mobile_num)){
    		        	showTips('J_phone', '请输入11位有效手机号！');
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
    		 * 需要全站通用执行的js代码
    		 */
    		publicExec:function(){
                //头部下拉框切换
                $(".list ul li").click(function(){
                    $(".cur-sel").html($(this).text());
                    $(".cur-sel").attr('data-val', $(this).attr('data-val'));
                });

                //点击头部搜索按钮
                $('.top-search a').click(function(){
                    if ($("input[name='keywords']").val() != '') {
                        if ($(".cur-sel").attr('data-val') == '1') {    //楼盘搜索
                            window.location.href = loupanUrl + '/loupan?keywords=' + $("input[name='keywords']").val();
                        }
                        if ($(".cur-sel").attr('data-val') == '3') {    //资讯搜索
                            window.location.href = newsUrl + '/search/' + $("input[name='keywords']").val();
                        }
                    }
                });

			    //底部合作伙伴切换
		 	    $('.footer .hot').click(function() {
		 	        $('.company-con').toggleClass('act'); 
		 	    });
		 	  
		 	    //返回头部
		 	    $(".right-nav").css("right",(document.body.clientWidth-1180)/2-60);
		 	    var backtotop = $('#backtotop');
		 	    function backTotop() {
    		 	    t = $(document).scrollTop();
    		 	    if (t > 100 || $(window).width > 480) {
    		 	    	backtotop.addClass('showme');
    		 	    } else {
    		 	    	backtotop.removeClass('showme');
    		 	    }
		 	    }
		 	    backTotop();
		 	    $(window).scroll(function () {
		 	        backTotop();
		 	    });
		 	    backtotop.click(function () {
		 	        $('body,html').animate({scrollTop:0},600);
		 	        return false;
		 	    });
		 	    
		 	    //右侧菜单栏 用户反馈事件绑定
		 	   $(".right-nav > .file").click(function(){
		 		  window.open(baseUrl + '/userfeedback');
		 	    });
		 	    
    		},


            /**
             * 校验身份证号码是否正确
             */
             validateIDCard: function(idCard) {
                //15位和18位身份证号码的正则表达式
                var regIdCard=/^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/;
                //如果通过该验证，说明身份证格式正确，但准确性还需计算
                if(regIdCard.test(idCard)){
                    if(idCard.length==18){
                        var idCardWi=new Array( 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ); //将前17位加权因子保存在数组里
                        var idCardY=new Array( 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ); //这是除以11后，可能产生的11位余数、验证码，也保存成数组
                        var idCardWiSum=0; //用来保存前17位各自乖以加权因子后的总和
                        for(var i=0;i<17;i++){
                            idCardWiSum+=idCard.substring(i,i+1)*idCardWi[i];
                        }
                        var idCardMod=idCardWiSum%11;//计算出校验码所在数组的位置
                        var idCardLast=idCard.substring(17);//得到最后一位身份证号码
                        //如果等于2，则说明校验码是10，身份证号码最后一位应该是X
                        if(idCardMod==2){
                            if(idCardLast=="X"||idCardLast=="x"){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            //用计算出的验证码与最后一位身份证号码匹配，如果一致，说明通过，否则是无效的身份证号码
                            if(idCardLast==idCardY[idCardMod]){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }else if(idCard.length == 15){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
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
    		showDialog:showDialog,
    		
    		 /**
    		  * 图片延迟加载
    		  */
    		lazyImg:function(){
    			$("img").lazyimg({threshold:300});
    		}
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
                window.event.returnValue = true;
            }
        });
        d.width(320);
        d.showModal();
    }
});

