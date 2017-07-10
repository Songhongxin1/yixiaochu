/**
 * 会员中心，修改信息
 */
define(function(require, exports, module){
    window.jQuery = window.$ = require("jquery");
    require('dialog');
    module.exports = {
    		//上传头像
    		upload_img:function(_self){
    			$("#uploadbtn").click(function(){
    				$("#uploadImg").trigger('click');
    				$('#uploadImg').unbind().on('change',function(e){
    					_self = $(_self);
    					data = new FormData();
    					$.each($('#uploadImg')[0].files, function(i, file) {
    						data.append('file', file);
    					});
                        data.append('type', 'portrait');
    					$.ajax({
    						url:uploadUrl+'/file/upload',
    						type:'POST',
    						data:data,
    						cache: false,
    						contentType: false,    
    						processData: false,
    						beforeSend:function(){
    						},
    						success:function(data){
    							if (data.error == 0) {
    								var _img = $('<img style="width:100%; height:100%;"/>');
    								_img.attr('src', data.full_url);
    								$("#uploadbtn").html(_img).css({padding:0});
    								_self.find("input[type='hidden']").val(data.url);
    								e.stopPropagation();
    							}else{
    								var d = dialog({
    									title:'错误！',
    									content:data.message.replace(/<\/?[^>]*>/, ''),
    									ok:function(){
    									}
    								})
    								d.showModal();
    							} 
    						}
    					});
    				})
    			})
    		},
    		//上传身份证正反面
    		upload_file:function(_self){
    			$(_self).find(".uploadbtn").click(function(){
    				up_area = $(this).parent();
    				$("#uploadImg").trigger('click');
    				$('#uploadImg').unbind().on('change',function(e){
    					var data = new FormData();
    					var load_toast = '';
    					$.each($('#uploadImg')[0].files, function(i, file) {
    						data.append('file', file);
    					});
                        data.append('type', 'image');
    					$.ajax({
    						url:uploadUrl+'/file/upload',
    						type:'POST',
    						data:data,
    						cache: false,
    						contentType: false,    
    						processData: false,
    						beforeSend:function(){
    						},
    						success:function(data){
    							if (data.error == 0) {
    								var _img = $('<img style="width:100%; height:100%;"/>');
    								_img.attr('src', data.full_url);
    								up_area.find('.uploadbtn').html(_img).css({padding:0});
    								up_area.find("input[type='hidden']").val(data.url);
    								$('#uploadImg').val('');
    								e.stopPropagation();
    							}else{
    								var d = dialog({
    									title:'错误！',
    									content:data.message.replace(/<\/?[^>]*>/, ''),
    									ok:function(){
    									}
    								})
    								d.showModal();
    							} 
    						}
    					});
    				})
    			})
    		},
    		//保存修改
    		save_info:function(){
    			$("#submit").click(function(){
    				//邮箱验证
    				var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/; 
    				if(!reg.test($("#userinfo input[name=email]").val())){
    					showDialog('邮箱格式不对');
    					return false;
    				}
    				$.post('/usercenter/save_info', $("#userinfo").serialize(), function(data){
    					var d = dialog({
    						title:'提示！',
    						content:data.msg,
    						okValue:'我知道了',
    						ok:function(){
    							
    						}
    					})
    					d.showModal();
    				})
    			})
    		},
    		//修改密码
            modify_pwd: function() {
                $('.save-pwd').click(function(){
                    var old_pwd = $("input[name='old_pwd']");
                    var new_pwd = $("input[name='new_pwd']");
                    var confirm_pwd = $("input[name='confirm_pwd']");

                    if (old_pwd.val() == "") {
                        showMsg(old_pwd, '请输入原密码');
                        return false;
                    } else {
                        showMsg(old_pwd, '');
                    }

                    if (new_pwd.val() == "") {
                        showMsg(new_pwd, '请输入新密码');
                        return false;
                    } else {
                        showMsg(new_pwd, '');
                    }

                    if (confirm_pwd.val() == "") {
                        showMsg(confirm_pwd, '请确定新密码');
                        return false;
                    } else {
                        showMsg(confirm_pwd, '');
                    }

                    if(confirm_pwd.val() != new_pwd.val()) {
                        showMsg(confirm_pwd, '两次密码输入不一致');
                        return false;
                    } else {
                        showMsg(confirm_pwd, '');
                    }

                    $.ajax({
                        url: "/usercenter/modify_pwd",
                        type: "post",
                        data: $("#pwd_form").serialize(),
                        dataType: "json",
                        error: function(data) {
                            showDialog(data.msg);
                        },
                        success: function(data) {
                            var d = dialog({
                                title: '提示',
                                content: data.msg,
                                okValue: '我知道了',
                                ok: function () {
                                    window.location.href = '/passport/logout';
                                },
                            });
                            d.showModal();
                        }
                    });
                });
            },
            //身份认证信息提交
          //保存身份证信息
            saveIdentity: function() {
                $(".save-identity").click(function() {
                    var real_name = $('input[name="real_name"]');
                    var card_number = $('input[name="card_number"]');
                    var card_front = $('input[name="card_front"]');
                    var card_back = $('input[name="card_back"]');
                    var card_expiration = $("input[name='card_expiration']");

                    if ($.trim(real_name.val()) == "") {
                    	showDialog('请填写姓名！');
                        return false;
                    } 

                    if ($.trim(card_number.val()) == "") {
                    	showDialog('请填写身份证号码！');
                        return false;
                    } 

                    if ($.trim(card_front.val()) == "") {
                    	showDialog('请上传手持身份证正面照！');
                        return false;
                    } 

                    if ($.trim(card_back.val()) == "") {
                    	showDialog('请上传身份证反面照！');
                        return false;
                    } 

                    if($("input[type='radio']:checked").val() == 1) {
                        card_expiration_val = $("input[name='card_expiration_short']").val();
                    } else {
                        card_expiration_val = '长期';
                    }

                    if ($.trim(card_expiration_val) == "") {
                    	showDialog('请填写身份证有效期');
                        return false;
                    } 

                    var d = dialog({
                        title: '提示',
                        content: '请仔细核对您填写的身份信息是否正确，确认提交？',
                        okValue: '确定',
                        ok: function () {
                            this.title('提交中…');
                            $(this).html('提交审核中...');
                            $.post(
                                '/usercenter/authenticate', 
                                {
                                    'real_name': real_name.val(),
                                    'card_number': card_number.val(), 
                                    'card_front': card_front.val(), 
                                    'card_back': card_back.val(), 
                                    'card_expiration': card_expiration_val
                                }, 
                                function(data){
                                    if(data.flag){
                                    	$('.page-bg').addClass('act');
                                        $('.statu-box').addClass('act');
                                    }else{
                                        showDialog(data.msg);
                                    }
                                }
                            );
                        },
                        cancelValue: '取消',
                        cancel: function () {}
                    });
                    d.show();
                });
            },
            //关闭提交成功提示
            close_box:function(){
            	$('.close-box').click(function() {
                    $('.statu-box').removeClass('act');
                    $('.page-bg').removeClass('act');                
                    window.location.reload();
                });
            }
    }
    function showDialog(content) {
        var d = dialog({
            title: '提示',
            content: content,
            okValue: '我知道了',
            ok: function () {},
        });
        d.width(320);
        d.show();
    }

    function showMsg(obj, msg) {
        if (msg != '') {
            obj.next("span").html(msg);
            obj.focus();
        } else {
            obj.next("span").html("");
        }
    }
});