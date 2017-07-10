/**
 * 配送员管理页js
 * @author chaokai@gz-zc.cn
 */
define(function(require, exports, module){
    
    window.jQuery = window.$ = require('jquery');
    require('dialog');
    
    module.exports = {
            //检查密码
            checkpassword:function(){
                var errortip = $('<i style="color: #C56767"></i>');
                $('input[name=password]').blur(function(){
                    var password = $(this).val();
                    if(password == ''){
                        errortip.text('请输入密码');
                        $(this).after(errortip);
                    }else{
                        errortip.text('');
                    }
                })
                //检查重复密码
                $('input[name=repassword]').blur(function(){
                    var repassword = $(this).val();
                    if(repassword == ''){
                        errortip.text('重复密码不能为空');
                        $(this).after(errortip);
                    }else{
                        errortip.text('');
                    }
                    if(password != repassword){
                        errortip.text('两次输入密码不一致');
                        $(this).after(errortip);
                    }else{
                        errortip.text('');
                    }
                })
                //提交时检查密码
                $('form').on('submit', function(e){
                    var password = $('input[name=password]').val();
                    var repassword = $('input[name=repassword]').val();
                    if(password == '' || repassword == '' || password != repassword){
                        errortip.text('两次输入密码不一致');
                        $('input[name=repassword]').after(errortip);
                        return false;
                    }
                })
            },
            //修改时检查密码
            checkpass:function(){
                var errortip = $('<i style="color: #C56767"></i>');
                //检查重复密码
                $('input[name=repassword]').blur(function(){
                    var repassword = $(this).val();
                    var password = $('input[name=password]').val();
                    if(password != repassword){
                        errortip.text('两次输入密码不一致');
                        $(this).after(errortip);
                    }else{
                        errortip.text('');
                    }
                })
                //提交时检查密码
                $('form').on('submit', function(e){
                    var password = $('input[name=password]').val();
                    var repassword = $('input[name=repassword]').val();
                    if(password != '' && repassword != '' && password != repassword){
                        errortip.text('两次输入密码不一致');
                        $('input[name=repassword]').after(errortip);
                        return false;
                    }
                })
            },
            //删除
            del:function(){
                $('.del').click(function(e){
                    e.preventDefault();
                    var url = $(this).attr('href');
                    var d = dialog({
                        title: '提示',
                        content: '确认删除？',
                        okValue: '确定',
                        ok: function () {
                            var obj = this;
                            $.get(url, function(data){
                                if(data.status == 0){
                                    window.location.reload();
                                }else{
                                    obj.title('错误');
                                    obj.content(data.msg);
                                }
                            })
                            return false;
                        },
                        cancel: function(){
                            d.close();
                        },
                        cancelValue: '取消'
                    });
                    d.width(320);
                    d.showModal();
                })
            },
            //禁止/取消登陆
            limit:function(){
                $('.limit').click(function(e){
                    e.preventDefault();
                    var url = $(this).attr('href');
                    var d = dialog({
                        title: '提示',
                        content: '确认操作？',
                        okValue: '确定',
                        ok: function () {
                            var obj = this;
                            $.get(url, function(data){
                                if(data.status == 0){
                                    window.location.reload();
                                }else{
                                    obj.title('错误');
                                    obj.content(data.msg);
                                }
                            })
                            return false;
                        },
                        cancel: function(){
                            d.close();
                        },
                        cancelValue: '取消'
                    });
                    d.width(320);
                    d.showModal();
                })
            }
    }
})