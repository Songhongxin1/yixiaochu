/*
 * 菜品分类管理js
 */
define(function(require, exports, module){
    window.jQuery = window.$ = require('jquery');
    
    module.exports = {
            add: function(){
                var html = '<form class="form-inline">'+
                            '<div class="form-group">'+
                                '<label>分类名称：</label>'+
                                    '<input type="text" class="form-control" name="name" id="type_name">'+
                                        '<p class="text-warning" id="type_add_tip"></p>'+
                                        '</div>'+
                                        '</form>';
                $('#action_add').click(function(){
                    var d = dialog({
                        title:'添加分类',
                        content:html,
                        okValue:'保存',
                        ok:function(){
                            var obj = this;
                            //输入框获取焦点后不显示提示信息
                            $('#type_name').on('focus', function(){
                                $('#type_add_tip').text('');
                            })
                            
                            var name = $.trim($('#type_name').val());
                            if(name == ''){
                                $('#type_add_tip').text('请输入分类名称');
                            }
                            //ajax保存
                            $.post('/foodstype/add', {name:name}, function(data){
                                if(data.status == 0){
                                    window.location.reload();
                                }else{
                                    $('#type_add_tip').text(data.msg);
                                }
                            })
                            
                            return false;
                        },
                        cancelValue:'取消',
                        cancel:function(){}
                    })
                    d.width(400);
                    d.showModal();
                    
                })
                
            },
            //修改
            edit:function(){
                $('.action_edit').click(function(){
                    var edit_name = $(this).attr('data-value');
                    var edit_id = $(this).attr('data-id');
                    var html = '<form class="form-inline">'+
                    '<div class="form-group">'+
                    '<label>分类名称：</label>'+
                    '<input type="text" class="form-control" name="name" id="edit_type_name" value="'+edit_name+'">'+
                    '<input type="hidden" class="form-control" name="id" id="edit_type_id" value="'+edit_id+'">'+
                    '<p class="text-warning" id="type_edit_tip"></p>'+
                    '</div>'+
                    '</form>';
                    var d = dialog({
                        title:'修改分类',
                        content:html,
                        okValue:'保存',
                        ok:function(){
                            var obj = this;
                            //输入框获取焦点后不显示提示信息
                            $('#type_name').on('focus', function(){
                                $('#type_edit_tip').text('');
                            })
                            
                            var name = $.trim($('#edit_type_name').val());
                            if(name == ''){
                                $('#type_edit_tip').text('请输入分类名称');
                            }
                            //ajax保存
                            $.post('/foodstype/edit', {id:edit_id,name:name}, function(data){
                                if(data.status == 0){
                                    window.location.reload();
                                }else{
                                    $('#type_edit_tip').text(data.msg);
                                }
                            })
                            
                            return false;
                        },
                        cancelValue:'取消',
                        cancel:function(){}
                    })
                    d.width(400);
                    d.showModal();
                    
                })
            },
            //删除
            del:function(){
                $('.del').click(function(e){
                    e.preventDefault();
                    var url = $(this).attr('href');
                    var d = dialog({
                        title:'提示',
                        content:'确认删除？',
                        cancelValue:'取消',
                        cancel:function(){},
                        okValue:'确认',
                        ok:function(){
                            var obj = this;
                            $.get(url, function(data){
                                if(data.status == 0){
                                    window.location.reload();
                                }else{
                                    obj.content(data.msg);
                                }
                            })
                            return false;
                        }
                    });
                    d.width(320);
                    d.showModal();
                })
            }
    }
})