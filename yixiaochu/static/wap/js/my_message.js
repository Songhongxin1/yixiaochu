/**
 * 我的消息页
 * @author chaokai@gz-zc.cn
 */
define(function(require, reports, module){
	window.jQuery = window.$ = require("jquery");
	var common = require('common');
	module.exports = {
			check_all:function(){
				$('input[name="check_all"]').click(function(){
	                $('input[name="info_ids"]').prop("checked", $(this).prop("checked"));
	            });
			},
			//标记为已读
	        makeread: function() {
	            $(".make_read").click(function(){
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
	        //删除所选消息
	        delmsg: function() {
	            $(".del_msg").click(function(){
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
	        },
	        
	}
})