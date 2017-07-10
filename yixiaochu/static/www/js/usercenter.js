/** 
 * 会员中心js
 * @author: jianming@gz-zc.cn
 */
define(function(require, exports, module){
    window.jQuery = window.$ = require("jquery");
    require('dialog');
    var common = require('public'); 

    module.exports = {

        //用户头像裁剪和上传
        uploadPortrait: function(){
            //点击添加头像照片
            $(".up-img").click(function(){
                $(".page-bg").fadeIn();
                $(".upimg-cont").fadeIn();
                $(".close-box").click(function(){
                    $(".upimg-cont").fadeOut();
                    $(".page-bg").fadeOut();     
                });
            });

            //头像上传裁剪
            var jcrop_api,boundx,boundy;
            var preview = $('.pic-preview');
            var pcnt = $('.pic-preview .img-size1');
            var pimg = $('.pic-preview .img-size1 img');
            var xsize = pcnt.width();
            var ysize = pcnt.height();
            var x = ($('.pic-source img').width() /2)-150;
            var y = ($('.pic-source img').height() /2)-150;
            
            var option = {
                minSize: [100,100],
                maxSize: [600,600],
                setSelect: [0, 0, 200, 200],
                allowSelect:false,
                onChange: showCoords,   
                onSelect: showCoords,
                aspectRatio: 1
            }
            var call_back = function(){
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];
                jcrop_api = this;
                  
                //初始化位置
                var rx = xsize / 300;
                var ry = ysize / 300;
                pimg.css({
                    width: Math.round(rx * boundx) + 'px',
                    height: Math.round(ry * boundy) + 'px',
                    marginLeft: '-' + Math.round(rx * x) + 'px',
                    marginTop: '-' + Math.round(ry * y) + 'px'
                });
               
            }
            
            $(".upload-photo").change(function(){
                if(typeof(jcrop_api) != 'undefined'){
                    jcrop_api.destroy();
                }
                $('.edit_cont .tip_msg').text('图片上传中..');
                var data = new FormData();
                $.each($('.upload-photo')[0].files, function(i, file) {
                    data.append('portrait', file);
                });
                $(".jpic-preview img, .pic-source img").removeAttr('style'); 
                $.ajax({
                    url:uploadUrl+'/file/set_portrait',
                    type:'POST',
                    data:data,
                    cache: false,
                    contentType: false,    
                    processData: false,    
                    success:function(data) {
                        $('.edit_cont .tip_msg').text('图片上传完毕');
                        if(data.status==0) {
                            x = (data.width / 2)-150;
                            y = (data.height / 2)-150;
                            option.setSelect = [x,y,300,300];  
                            $(".pic-source img").attr('src',data.url);
                            $(".pic-preview img").attr('src',data.url);
                            $('#img_url').val(data.url);
                            $('.pic-source img').Jcrop(option,call_back);
                        }else{
                            if(typeof(jcrop_api) != 'undefined'){
                                jcrop_api.destroy();
                            }
                        }
                     }
                 });
            });
            
            function showCoords(c) {
                $('#x').val(c.x);
                $('#y').val(c.y);
                $('#w').val(c.w);
                $('#h').val(c.h);
                if (parseInt(c.w) > 0) {
                    var rx = xsize / c.w;
                    var ry = ysize / c.h;
                    pimg.css({
                      width: Math.round(rx * boundx) + 'px',
                      height: Math.round(ry * boundy) + 'px',
                      marginLeft: '-' + Math.round(rx * c.x) + 'px',
                      marginTop: '-' + Math.round(ry * c.y) + 'px'
                    });
                }
            };


            //裁剪头像
            $('.save-portrait').on('click', function(){
                var x = parseInt($('#x').val());
                var y = parseInt($('#y').val());
                var w = parseInt($('#w').val());
                var h = parseInt($('#h').val());
                var img_url = $('#img_url').val();
                if (w) {
                    $.post(
                    	uploadUrl+'/file/cut_img', 
                        {'x':x,'y':y,'w':w,'h':h,'img_url':img_url}, 
                        function(data){
                            if(data.status==0){
                                $("#portrait").val(data.url);
                                $(".up-img").attr('style', 'padding:0; border: 0');
                                $(".up-img").html('<img src="'+data.full_url+'" style="width: 113px; height: 113px; border-radius: 50%">');
                                $(".close-box").click();
                            }else{
                                common.showDialog(data.msg);
                            }
                        }
                    );
                } else {
                    common.showDialog('请选择裁剪区域');
                }
            });
        },

        //编辑资料和取消编辑切换效果
        switchForm: function() {
            $('.edit').click(function(){
                if ($(this).attr('data-val') == 1) {
                    $('.user-info').hide();
                    $('#user_form').show();
                    $('.tab-title').html('编辑资料');
                    $(this).html('取消编辑');
                    $(this).attr('data-val', '2');
                } else {
                    $('#user_form').hide();
                    $('.user-info').show();
                    $('.tab-title').html('个人资料');
                    $(this).html('编辑资料');
                    $(this).attr('data-val', '1');
                }
            });
        },

        //保存用户基本资料
        saveInfo: function() {
            $(".save-info").click(function(){
                $.ajax({
                    url: "/usercenter/save_info",
                    type: "post",
                    data: $("#user_form").serialize(),
                    dataType: "json",
                    error: function(data) {
                        common.showDialog(data.msg);
                    },
                    success: function(data) {
                        common.showDialog(data.msg, '' , '/usercenter');
                    }
                });
            });
        },

        //修改密码
        modifyPwd: function() {
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
                        common.showDialog(data.msg);
                    },
                    success: function(data) {
                        common.showDialog(data.msg, '', '/usercenter/modify_pwd');
                    }
                });


            });
        },
         
        //加载日历控件
        initDatePicker: function(params) {
            $(".Wdate").focus(function(){
                $(this).parent().click();
                WdatePicker(params);
            });
        },

        //删除图片
        delPic: function() {
            $(".auth-step1").on('click','.del-pic',function(){
                $(this).parent().remove();
            });
        },

        //保存身份证信息
        saveIdentity: function() {
            $(".save-identity").click(function() {
                var real_name = $('input[name="real_name"]');
                var card_number = $('input[name="card_number"]');
                var card_front = $('input[name="card_front"]');
                var card_back = $('input[name="card_back"]');
                var card_expiration = $("input[name='card_expiration']");

                if ($.trim(real_name.val()) == "") {
                    showMsg(real_name, '请填写姓名！');
                    return false;
                } else {
                    showMsg(real_name, '');
                }

                if ($.trim(card_number.val()) == "") {
                    showMsg(card_number, '请填写身份证号码！');
                    return false;
                } else {
                    if (!common.validateIDCard(card_number.val())) {
                        showMsg(card_number, '身份证号码格式不正确！');
                        return false;
                    }
                    showMsg(card_number, '');
                }

                if ($.trim(card_front.val()) == "") {
                    showMsg($("#uploader_card_front"), '请上传手持身份证正面照！');
                    return false;
                } else {
                    showMsg($("#uploader_card_front"), '');
                }

                if ($.trim(card_back.val()) == "") {
                    showMsg($("#uploader_card_back"), '请上传身份证反面照！');
                    return false;
                } else {
                    showMsg($("#uploader_card_back"), '');
                }

                if($("input[type='radio']:checked").val() == 1) {
                    card_expiration.val($("input[name='card_expiration_short']").val());
                } else {
                    card_expiration.val('长期');
                }

                if ($.trim(card_expiration.val()) == "") {
                    showMsg(card_expiration, '请填写身份证有效期');
                    return false;
                } else {
                    showMsg(card_expiration, '');
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
                                'card_expiration': card_expiration.val()
                            }, 
                            function(data){
                                if(data.flag){
                                    location.reload();
                                }else{
                                    common.showDialog(data.msg);
                                }
                            }
                        );
                    },
                    cancelValue: '取消',
                    cancel: function () {}
                });
                d.showModal();
            });
        },

        //点击消息标题,展开消息详情，并标记为已读
        bindMsgTitle: function() {
            $(".msg-title").click(function(){
                $(this).next().toggle();
                var obj = $(this);
                if (obj.attr('data-is-read') == 0) {
                    $.post(
                        '/usercenter/mark_read', 
                        {'ids': obj.attr("data-id")}, 
                        function(data){
                            if(data.flag){
                                obj.attr('data-is-read','1');
                                obj.addClass('title-read').removeClass('title-noread')
                            }else{
                                common.showDialog(data.msg);
                            }
                        }
                    );
                }
            });
        },

        //标记为已读
        markRead: function() {
            $(".mark-read").click(function(){
                var ids =[]; 
                $('input[name="info_ids"]:checked').each(function(){ 
                    ids.push($(this).val()); 
                }); 
                if (ids.length == 0) {
                    common.showDialog("请先勾选您需要处理的消息");
                    return false;
                }

                $.post(
                    '/usercenter/mark_read', 
                    {'ids': ids}, 
                    function(data){
                        common.showDialog(data.msg, '', '/usercenter/message');
                    }
                );
            });
        },

        //全选
        checkAll: function() {
            $('input[name="check-all"]').click(function(){
                $('input[name="info_ids"]').prop("checked", $(this).prop("checked"));
            });
        },

        //删除消息
        delMsg: function() {
            $(".del-msg").click(function(){
                var ids =[]; 
                $('input[name="info_ids"]:checked').each(function(){ 
                    ids.push($(this).val()); 
                }); 
                if (ids.length == 0) {
                    common.showDialog("请先勾选您需要处理的消息");
                    return false;
                }

                $.post(
                    '/usercenter/del_msg', 
                    {'ids': ids}, 
                    function(data){
                        common.showDialog(data.msg, '' ,'/usercenter/message');
                    }
                );

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
 