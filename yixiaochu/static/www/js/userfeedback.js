/** 
 * 会员中心js
 * @author: jianming@gz-zc.cn
 */
define(function(require, exports, module){
    window.jQuery = window.$ = require("jquery");
    require('dialog');
    var common = require('public'); 

    module.exports = {
        //删除图片
        delPic: function() {
            $(".auth-step1").on('click','.del-pic',function(){
                $(this).parent().remove();
            });
        },

        //保存用户反馈信息
        saveFeedback: function() {
            $(".save-feedback").click(function() {
                var feedback_content = $('textarea[name="feedback_content"]');
                var phone_num = $('input[name="phone_num"]');
                var qq_num = $('input[name="qq_num"]');
                var source_url = $('input[name="source_url"]');
                var feedback_img = $('input[name="feedback_img"]');
                
                if ($.trim(feedback_content.val()) == "") {
                	common.showDialog("请填写反馈信息！"); //弹窗式提醒
                	//showMsg(feedback_content, '请填写反馈信息！'); 
                    return false;
                } else {
                    showMsg(feedback_content, '');
                }

                var d = dialog({
                    title: '提示',
                    content: '确认提交您的反馈信息？',
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $(this).html('提交审核中...');
                        $.post(
                            '/userfeedback/save_info', 
                            {
                                'feedback_content': feedback_content.val(),
                                'phone_num': phone_num.val(), 
                                'qq_num': qq_num.val(), 
                                'source_url': source_url.val(),
                                'feedback_img': feedback_img.val()
                            }, 
                            function(data){
                            	common.showDialog(data.msg, '', '/userfeedback');
                            }
                        );
                    },
                    cancelValue: '取消',
                    cancel: function () {}
                });
                d.showModal();
            });
            
            $("textarea").keydown(function(){
            	var max = 500;
				if($(this).val().length >= max) {
					common.showDialog("输入的内容请不要超过"+ max +"个字符"); //弹窗式提醒
					$(this).val($(this).val().substring(0, max-1)) ;
					return;
				}
            });
        }

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
 