/**
 * 申请查询页js
 */
define(function(require, exports, module){
	window.jQuery = window.$ = require("jquery");
	module.exports = {
			//加载更多
			load_more:function(){
				$(".check-more").click(function(){
					var page = $(this).attr('data-page');
					$.ajax({
						url:'/usercenter/buy_apply',
						data:{
							page:page
						},
						type:'post',
						success:function(data){
							var content = '';
							$.each(data.data, function(k, v){
								content += '<table border="0" cellspacing="0" cellpadding="0">';
								content += '<tr>';
								content += '<td class="head1">申请ID</td>';
								content += '<td class="head2">'+v.id+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>申请楼盘</td>';
								content += '<td>'+v.house_name+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>申请户型</td>';
								content += '<td>'+v.model_name+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>申请状态</td>';
								content += '<td class="text-yellow">';
								if(v.order_status == 1){
									content += '待审核';
								}else if(v.order_status == 2){
									content += '审核通过';
								}else if(v.order_status == 3){
									content += '审核未通过';
								}
								content += '</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>申请时间</td>';
								content += '<td>'+v.create_time+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>操作</td>';
								content += '<td><a href="javascript:;"><span >查看回执单</span></a></td>';
								content += '</tr>';
								content += '</table>';
							})
							$('.check-more').before(content);
							if(data.next_page){
								$('.check-more').attr('data-page', data.next_page);
							}else{
								$('.check-more').remove();
							}
						}
						
					})
				})
			}
	}
})